<?php

namespace App\Services\Pdf;

/**
 * A deliberately minimal PDF 1.4 writer.
 *
 * Why hand-rolled instead of a Composer package (e.g. dompdf)? Because every
 * Composer dependency we add requires a matching composer.lock regeneration,
 * and we don't have a PHP/Composer environment available to do that reliably
 * for every machine this project gets deployed to — that exact problem is
 * what broke Bulk Import earlier. PDF, unlike .xlsx, can't be read with
 * built-in PHP extensions, so instead this class WRITES plain PDF syntax
 * directly: a handful of indirect objects, an xref table, and a trailer.
 *
 * Capabilities (intentionally limited to what reports need):
 *  - Multiple pages, A4 portrait or landscape
 *  - Left-aligned text in the 2 standard Helvetica fonts (regular/bold)
 *  - Lines and filled/stroked rectangles (table borders, header bars)
 *  - Automatic text width estimation for column truncation
 *
 * No images, no embedded fonts, no Unicode beyond Latin-1 — exactly enough
 * for a clean, professional tabular report.
 */
class SimplePdf
{
    public const A4_PORTRAIT = [595.28, 841.89];
    public const A4_LANDSCAPE = [841.89, 595.28];

    protected array $pageSize;
    protected array $pages = [];      // each: ['content' => string]
    protected string $currentContent = '';
    protected bool $hasPage = false;

    /** Approximate Helvetica glyph widths (per 1000 units) for common ASCII ranges. */
    protected const AVG_CHAR_WIDTH = 556;

    public function __construct(array $pageSize = self::A4_PORTRAIT)
    {
        $this->pageSize = $pageSize;
    }

    public function addPage(): static
    {
        if ($this->hasPage) {
            $this->pages[] = ['content' => $this->currentContent];
        }
        $this->currentContent = '';
        $this->hasPage = true;

        return $this;
    }

    public function pageWidth(): float
    {
        return $this->pageSize[0];
    }

    public function pageHeight(): float
    {
        return $this->pageSize[1];
    }

    /**
     * Draw left-aligned text. $y is measured from the BOTTOM of the page
     * (standard PDF coordinate space), matching everything else here.
     */
    public function text(float $x, float $y, string $text, float $size = 10, bool $bold = false, array $color = [0, 0, 0]): static
    {
        $font = $bold ? '/F2' : '/F1';
        $escaped = $this->escape($text);
        [$r, $g, $b] = $this->normalizeColor($color);

        $this->currentContent .= sprintf(
            "BT %s %.2F Tf %.3F %.3F %.3F rg %.2F %.2F Td (%s) Tj ET\n",
            $font,
            $size,
            $r, $g, $b,
            $x, $y,
            $escaped
        );

        return $this;
    }

    public function rect(float $x, float $y, float $w, float $h, ?array $stroke = null, ?array $fill = null, float $lineWidth = 1.0): static
    {
        $ops = '';

        if ($fill !== null) {
            [$r, $g, $b] = $this->normalizeColor($fill);
            $ops .= sprintf("%.3F %.3F %.3F rg\n", $r, $g, $b);
        }

        if ($stroke !== null) {
            [$r, $g, $b] = $this->normalizeColor($stroke);
            $ops .= sprintf("%.3F %.3F %.3F RG %.2F w\n", $r, $g, $b, $lineWidth);
        }

        $ops .= sprintf("%.2F %.2F %.2F %.2F re ", $x, $y, $w, $h);

        if ($fill !== null && $stroke !== null) {
            $ops .= "B\n";
        } elseif ($fill !== null) {
            $ops .= "f\n";
        } else {
            $ops .= "S\n";
        }

        $this->currentContent .= $ops;

        return $this;
    }

    public function line(float $x1, float $y1, float $x2, float $y2, array $color = [0, 0, 0], float $width = 1.0): static
    {
        [$r, $g, $b] = $this->normalizeColor($color);

        $this->currentContent .= sprintf(
            "%.3F %.3F %.3F RG %.2F w %.2F %.2F m %.2F %.2F l S\n",
            $r, $g, $b, $width, $x1, $y1, $x2, $y2
        );

        return $this;
    }

    /**
     * Estimate the rendered width of $text at $size using a flat average
     * glyph width. Good enough for column-fit truncation, not for precise
     * typesetting.
     */
    public function textWidth(string $text, float $size): float
    {
        return (strlen($text) * self::AVG_CHAR_WIDTH / 1000) * $size;
    }

    /**
     * Truncate $text with an ellipsis so it fits within $maxWidth points at
     * the given font size.
     */
    public function fitText(string $text, float $maxWidth, float $size): string
    {
        if ($this->textWidth($text, $size) <= $maxWidth) {
            return $text;
        }

        $ellipsis = '...';
        $low = 0;
        $high = strlen($text);

        while ($low < $high) {
            $mid = intdiv($low + $high + 1, 2);
            $candidate = substr($text, 0, $mid) . $ellipsis;

            if ($this->textWidth($candidate, $size) <= $maxWidth) {
                $low = $mid;
            } else {
                $high = $mid - 1;
            }
        }

        return $low > 0 ? substr($text, 0, $low) . $ellipsis : $ellipsis;
    }

    protected function normalizeColor(array $color): array
    {
        return [
            max(0, min(1, ($color[0] ?? 0) / 255)),
            max(0, min(1, ($color[1] ?? 0) / 255)),
            max(0, min(1, ($color[2] ?? 0) / 255)),
        ];
    }

    protected function escape(string $text): string
    {
        // PDF's base-14 fonts only support Latin-1 (WinAnsiEncoding); fold
        // anything else down so the stream never contains invalid bytes.
        $converted = @mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
        $text = $converted !== false ? $converted : preg_replace('/[^\x20-\x7E]/', '?', $text);

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    /**
     * Render the full document to a raw PDF byte string.
     */
    public function output(): string
    {
        if ($this->hasPage) {
            $this->pages[] = ['content' => $this->currentContent];
            $this->hasPage = false;
            $this->currentContent = '';
        }

        if (empty($this->pages)) {
            $this->pages[] = ['content' => ''];
        }

        $objects = [];     // 1-indexed object number => object body (without "N 0 obj" wrapper)
        $nextId = 1;

        $catalogId = $nextId++;
        $pagesId = $nextId++;
        $fontRegularId = $nextId++;
        $fontBoldId = $nextId++;

        $pageIds = [];
        $contentIds = [];

        foreach ($this->pages as $page) {
            $pageIds[] = $nextId++;
            $contentIds[] = $nextId++;
        }

        $objects[$catalogId] = "<< /Type /Catalog /Pages {$pagesId} 0 R >>";

        $kids = implode(' ', array_map(fn ($id) => "{$id} 0 R", $pageIds));
        $objects[$pagesId] = "<< /Type /Pages /Kids [{$kids}] /Count " . count($pageIds) . ' >>';

        $objects[$fontRegularId] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
        $objects[$fontBoldId] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>';

        [$w, $h] = $this->pageSize;

        foreach ($this->pages as $i => $page) {
            $pageId = $pageIds[$i];
            $contentId = $contentIds[$i];

            $objects[$pageId] = "<< /Type /Page /Parent {$pagesId} 0 R "
                . "/MediaBox [0 0 " . round($w, 2) . ' ' . round($h, 2) . '] '
                . "/Resources << /Font << /F1 {$fontRegularId} 0 R /F2 {$fontBoldId} 0 R >> >> "
                . "/Contents {$contentId} 0 R >>";

            $stream = $page['content'];
            $objects[$contentId] = "<< /Length " . strlen($stream) . " >>\nstream\n{$stream}endstream";
        }

        return $this->assemble($objects, $catalogId);
    }

    protected function assemble(array $objects, int $catalogId): string
    {
        ksort($objects);

        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n"; // binary marker comment, standard practice
        $offsets = [0];

        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$body}\nendobj\n";
        }

        $xrefStart = strlen($pdf);
        $count = count($objects) + 1;

        $pdf .= "xref\n0 {$count}\n";
        $pdf .= "0000000000 65535 f \n";

        for ($id = 1; $id < $count; $id++) {
            $offset = $offsets[$id] ?? 0;
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size {$count} /Root {$catalogId} 0 R >>\n";
        $pdf .= "startxref\n{$xrefStart}\n%%EOF";

        return $pdf;
    }
}
