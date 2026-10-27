<?php

namespace App\Services\Pdf;

/**
 * Renders a standard UMSC report: letterhead, applied-filters summary, a
 * paginated data table (header row repeats on every page), and a footer
 * with page numbers + generation timestamp.
 */
class ReportPdfBuilder
{
    protected const MARGIN = 40;
    protected const ROW_HEIGHT = 20;
    protected const HEADER_ROW_HEIGHT = 24;
    protected const BRAND_GREEN = [0, 88, 15];      // #00580f
    protected const LIGHT_GREEN = [232, 245, 233];  // header row fill
    protected const ZEBRA_GRAY = [248, 250, 252];   // alternating row fill
    protected const TEXT_DARK = [33, 37, 41];
    protected const TEXT_MUTED = [108, 117, 125];
    protected const BORDER = [222, 226, 230];

    /**
     * @param string $title       e.g. "Nikah Applications Report"
     * @param string $generatedBy e.g. "Director for Sharia — District Khadhi, Bugweri"
     * @param array  $filters     ['Status' => 'Submitted', 'From' => '2026-01-01', ...] — only non-empty entries are shown
     * @param array  $columns     [['label' => 'Application ID', 'key' => 'application_id', 'weight' => 1.4], ...]
     * @param array  $rows        array of assoc arrays keyed by each column's 'key'
     */
    public function build(string $title, string $generatedBy, array $filters, array $columns, array $rows): string
    {
        $pdf = new SimplePdf(SimplePdf::A4_PORTRAIT);
        $pageW = $pdf->pageWidth();
        $pageH = $pdf->pageHeight();
        $margin = self::MARGIN;
        $contentWidth = $pageW - (2 * $margin);

        $filterLines = $this->buildFilterLines($filters);
        $letterheadHeight = 96 + (count($filterLines) > 0 ? 16 : 0);
        $footerHeight = 30;

        $usableHeight = $pageH - (2 * $margin) - $letterheadHeight - self::HEADER_ROW_HEIGHT - $footerHeight;
        $rowsPerPage = max(1, (int) floor($usableHeight / self::ROW_HEIGHT));

        $colWidths = $this->computeColumnWidths($columns, $contentWidth);
        $chunks = array_chunk($rows, $rowsPerPage);

        if (empty($chunks)) {
            $chunks = [[]];
        }

        $totalPages = count($chunks);

        foreach ($chunks as $pageIndex => $chunk) {
            $pdf->addPage();
            $y = $pageH - $margin;

            $y = $this->drawLetterhead($pdf, $margin, $y, $contentWidth, $title, $generatedBy, $filterLines, count($rows));
            $y = $this->drawTableHeader($pdf, $margin, $y, $columns, $colWidths);

            foreach ($chunk as $i => $row) {
                $y = $this->drawTableRow($pdf, $margin, $y, $columns, $colWidths, $row, $i % 2 === 1);
            }

            $this->drawFooter($pdf, $margin, $pageW, $pageIndex + 1, $totalPages);
        }

        return $pdf->output();
    }

    protected function buildFilterLines(array $filters): array
    {
        $parts = [];

        foreach ($filters as $label => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $parts[] = "{$label}: {$value}";
        }

        return $parts ? [implode('   •   ', $parts)] : [];
    }

    protected function computeColumnWidths(array $columns, float $contentWidth): array
    {
        $totalWeight = array_sum(array_map(fn ($c) => $c['weight'] ?? 1, $columns));
        $widths = [];

        foreach ($columns as $col) {
            $weight = $col['weight'] ?? 1;
            $widths[] = $contentWidth * ($weight / $totalWeight);
        }

        return $widths;
    }

    protected function drawLetterhead(SimplePdf $pdf, float $margin, float $y, float $contentWidth, string $title, string $generatedBy, array $filterLines, int $totalRows): float
    {
        $pdf->text($margin, $y, 'UMSC', 18, true, self::BRAND_GREEN);
        $pdf->text($margin + 50, $y, 'DIRECTORATE OF SHARIA', 11, true, self::TEXT_MUTED);
        $pdf->text($margin, $y - 16, 'Uganda Muslim Supreme Council', 9, false, self::TEXT_MUTED);

        $generatedLabel = 'Generated ' . now()->format('d M Y, H:i');
        $genWidth = $pdf->textWidth($generatedLabel, 9);
        $pdf->text($margin + $contentWidth - $genWidth, $y, $generatedLabel, 9, false, self::TEXT_MUTED);

        $y -= 34;
        $pdf->line($margin, $y, $margin + $contentWidth, $y, self::BRAND_GREEN, 1.5);
        $y -= 22;

        $pdf->text($margin, $y, $title, 14, true, self::TEXT_DARK);

        $countLabel = $totalRows . ' record' . ($totalRows === 1 ? '' : 's');
        $countWidth = $pdf->textWidth($countLabel, 10);
        $pdf->text($margin + $contentWidth - $countWidth, $y, $countLabel, 10, false, self::TEXT_MUTED);

        $y -= 16;
        $pdf->text($margin, $y, $generatedBy, 9, false, self::TEXT_MUTED);
        $y -= 14;

        foreach ($filterLines as $line) {
            $pdf->text($margin, $y, $pdf->fitText($line, $contentWidth, 8.5), 8.5, false, self::TEXT_MUTED);
            $y -= 14;
        }

        $y -= 10;

        return $y;
    }

    protected function drawTableHeader(SimplePdf $pdf, float $margin, float $y, array $columns, array $colWidths): float
    {
        $width = array_sum($colWidths);
        $rowTop = $y;
        $rowBottom = $y - self::HEADER_ROW_HEIGHT;

        $pdf->rect($margin, $rowBottom, $width, self::HEADER_ROW_HEIGHT, null, self::LIGHT_GREEN);

        $x = $margin;
        foreach ($columns as $i => $col) {
            $label = $pdf->fitText($col['label'], $colWidths[$i] - 10, 9);
            $pdf->text($x + 5, $rowTop - 16, $label, 9, true, self::BRAND_GREEN);
            $x += $colWidths[$i];
        }

        return $rowBottom;
    }

    protected function drawTableRow(SimplePdf $pdf, float $margin, float $y, array $columns, array $colWidths, array $row, bool $shaded): float
    {
        $width = array_sum($colWidths);
        $rowBottom = $y - self::ROW_HEIGHT;

        if ($shaded) {
            $pdf->rect($margin, $rowBottom, $width, self::ROW_HEIGHT, null, self::ZEBRA_GRAY);
        }

        $x = $margin;
        foreach ($columns as $i => $col) {
            $value = (string) ($row[$col['key']] ?? '');
            $value = $pdf->fitText($value, $colWidths[$i] - 10, 9);
            $pdf->text($x + 5, $y - 14, $value, 9, false, self::TEXT_DARK);
            $x += $colWidths[$i];
        }

        $pdf->line($margin, $rowBottom, $margin + $width, $rowBottom, self::BORDER, 0.5);

        return $rowBottom;
    }

    protected function drawFooter(SimplePdf $pdf, float $margin, float $pageW, int $pageNum, int $totalPages): void
    {
        $label = "Page {$pageNum} of {$totalPages}   |   UMSC Sharia Case Management System";
        $width = $pdf->textWidth($label, 8);
        $pdf->text(($pageW - $width) / 2, 24, $label, 8, false, self::TEXT_MUTED);
    }
}
