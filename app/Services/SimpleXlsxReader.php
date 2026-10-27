<?php

namespace App\Services;

use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

/**
 * A deliberately minimal .xlsx reader.
 *
 * An .xlsx file is just a ZIP archive of XML files. Rather than pull in a
 * Composer package (which requires a working `composer update` on every
 * machine this is deployed to, and has already caused lock-file headaches),
 * this reads the handful of XML parts we actually need using PHP's built-in
 * ZipArchive + SimpleXML extensions, which ship with virtually every PHP
 * install.
 *
 * It supports exactly what the Bulk Import feature needs: plain text and
 * numeric cell values on the first worksheet, with shared strings resolved.
 * It does NOT support formulas, styles, multiple sheets, or rich formatting.
 */
class SimpleXlsxReader
{
    /** @var string[] */
    protected array $sharedStrings = [];

    /**
     * Read the first worksheet and return it as a zero-indexed array of
     * rows, each row a zero-indexed array of column => string value
     * (sparse — empty cells are simply absent from the row array).
     *
     * @return array<int, array<int, string>>
     */
    public function readFirstSheet(string $absolutePath): array
    {
        if (!class_exists(ZipArchive::class)) {
            throw new RuntimeException(
                'The PHP "zip" extension is not enabled on this server, so .xlsx files cannot be read. '
                . 'Please enable "extension=zip" in your php.ini and restart the server.'
            );
        }

        $zip = new ZipArchive();
        $opened = $zip->open($absolutePath);

        if ($opened !== true) {
            throw new RuntimeException('This file could not be opened — please make sure it is a valid .xlsx workbook.');
        }

        try {
            $this->loadSharedStrings($zip);
            $sheetXml = $this->loadFirstSheetXml($zip);

            return $this->parseSheet($sheetXml);
        } finally {
            $zip->close();
        }
    }

    protected function loadSharedStrings(ZipArchive $zip): void
    {
        $contents = $zip->getFromName('xl/sharedStrings.xml');

        if ($contents === false) {
            return; // Workbook has no shared strings table — every cell is inline/numeric.
        }

        $xml = @simplexml_load_string($contents);

        if (!$xml) {
            return;
        }

        foreach ($xml->si as $si) {
            if (isset($si->t)) {
                $this->sharedStrings[] = (string) $si->t;
                continue;
            }

            // Rich text run (<r><t>...</t></r> repeated) — concatenate all runs.
            $text = '';
            foreach ($si->r as $run) {
                $text .= (string) $run->t;
            }
            $this->sharedStrings[] = $text;
        }
    }

    protected function loadFirstSheetXml(ZipArchive $zip): SimpleXMLElement
    {
        $target = $this->resolveFirstSheetTarget($zip);
        $contents = $zip->getFromName('xl/' . ltrim($target, '/'));

        // Fall back to the overwhelmingly common convention if relationship
        // resolution above failed for any reason.
        if ($contents === false) {
            $contents = $zip->getFromName('xl/worksheets/sheet1.xml');
        }

        if ($contents === false) {
            throw new RuntimeException('Could not find a worksheet inside this workbook.');
        }

        $xml = @simplexml_load_string($contents);

        if (!$xml) {
            throw new RuntimeException('This file does not look like a valid Excel workbook.');
        }

        return $xml;
    }

    protected function resolveFirstSheetTarget(ZipArchive $zip): string
    {
        $default = 'worksheets/sheet1.xml';

        $workbookXml = $zip->getFromName('xl/workbook.xml');
        $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');

        if ($workbookXml === false || $relsXml === false) {
            return $default;
        }

        $workbook = @simplexml_load_string($workbookXml);
        $rels = @simplexml_load_string($relsXml);

        if (!$workbook || !$rels || !isset($workbook->sheets->sheet[0])) {
            return $default;
        }

        $namespaces = $workbook->sheets->sheet[0]->attributes('r', true);
        $rId = isset($namespaces['id']) ? (string) $namespaces['id'] : null;

        if (!$rId) {
            return $default;
        }

        foreach ($rels->Relationship as $rel) {
            if ((string) $rel['Id'] === $rId) {
                $target = (string) $rel['Target'];

                return str_starts_with($target, 'worksheets/') ? $target : 'worksheets/' . basename($target);
            }
        }

        return $default;
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function parseSheet(SimpleXMLElement $xml): array
    {
        $rows = [];

        if (!isset($xml->sheetData->row)) {
            return $rows;
        }

        foreach ($xml->sheetData->row as $row) {
            $rowIndex = (int) $row['r'];
            $cells = [];

            foreach ($row->c as $cell) {
                $ref = (string) $cell['r']; // e.g. "C4"
                $colLetters = preg_replace('/\d+/', '', $ref) ?: '';
                $colIndex = $this->columnLettersToIndex($colLetters);

                $cells[$colIndex] = $this->extractCellValue($cell);
            }

            $rows[$rowIndex] = $cells;
        }

        return $rows;
    }

    protected function extractCellValue(SimpleXMLElement $cell): string
    {
        $type = (string) $cell['t'];

        if ($type === 'inlineStr') {
            return isset($cell->is->t) ? trim((string) $cell->is->t) : '';
        }

        if (!isset($cell->v)) {
            return '';
        }

        $raw = (string) $cell->v;

        if ($type === 's') {
            return trim($this->sharedStrings[(int) $raw] ?? '');
        }

        // Numeric / boolean / everything else — return the raw value as-is.
        return trim($raw);
    }

    protected function columnLettersToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $index = 0;

        for ($i = 0; $i < strlen($letters); $i++) {
            $index = $index * 26 + (ord($letters[$i]) - ord('A') + 1);
        }

        return max(0, $index - 1); // zero-based
    }
}
