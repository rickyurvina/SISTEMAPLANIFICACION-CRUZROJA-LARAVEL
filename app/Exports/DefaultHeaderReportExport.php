<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DefaultHeaderReportExport implements FromView, WithEvents
{

    private $view;

    private $reportTitle;

    private $rowHeight;

    private $autoSize;

    private $columnWidth;

    /**
     *
     * @param View $view
     * @param string $reportTitle
     * @param int $rowHeight
     * @param bool $autoSize
     * @param int $columnWidth
     */
    public function __construct(View $view, string $reportTitle, int $rowHeight = 40, bool $autoSize = false, int $columnWidth = 40)
    {
        $this->view = $view;
        $this->reportTitle = $reportTitle;
        $this->rowHeight = $rowHeight;
        $this->autoSize = $autoSize;
        $this->columnWidth = $columnWidth;
    }

    public function view(): View
    {
        return $this->view;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $titleText = new RichText();
                $titleText->createText($this->reportTitle);
                $date = new RichText();
                $date->createText(trans('general.date') . ': ' . date('d/m/Y'));
                $companyName = new RichText();
                $companyName->createText(company_name());

                // Add a rows before the first row
                $event->sheet->getDelegate()->insertNewRowBefore(1, 4);

                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('/img/LOGO_CRE_2.jpg'));
                $drawing->setHeight(40);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Add company text
                $event->sheet->getDelegate()->getCell('A2')->setValue($companyName);

                // Add title text
                $event->sheet->getDelegate()->getCell('A3')->setValue($titleText);

                // Add current date
                $event->sheet->getDelegate()->getCell('A4')->setValue($date);

                $highestRowAndColumn = $event->sheet->getDelegate()->getHighestRowAndColumn();

                // All headers
                $headersRange = 'A2:C4';
                $headersStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '0046AD'
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT
                    ]
                ];
                $event->sheet->getDelegate()->getStyle($headersRange)->applyFromArray($headersStyle);

                // Merge company Row
                $companyRowRange = 'A2:' . $highestRowAndColumn['column'] . '2';
                $event->sheet->getDelegate()->mergeCells($companyRowRange);

                // Merge title Row
                $titleRange = 'A3:' . $highestRowAndColumn['column'] . '3';
                $event->sheet->getDelegate()->mergeCells($titleRange);

                // Merge date Row
                $dateRowRange = 'A4:' . $highestRowAndColumn['column'] . '4';
                $event->sheet->getDelegate()->mergeCells($dateRowRange);

                // Set all columns to specific width
                for ($i = 'A'; $i <= $highestRowAndColumn['column']; $i++) {
                    if ($this->autoSize) {
                        $event->sheet->getDelegate()->getColumnDimension($i)->setAutoSize(true);
                    } else {
                        $event->sheet->getDelegate()->getColumnDimension($i)->setWidth($this->columnWidth);
                    }
                }

                // Apply array of styles to A1:(last cell) cell range
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A2:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->applyFromArray($styleArray);

                // Set headers rows to height 30
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(30);

                // Set A5:(last cell) range to wrap text in cells
                $event->sheet->getDelegate()->getStyle('A5:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])
                    ->getAlignment()->setWrapText(true);

                // Set A5:(last cell) range to height 40
                for ($i = 5; $i <= $highestRowAndColumn['row']; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight($this->rowHeight);
                }

                // Set A5:(last cell) range to bold false
                $event->sheet->getDelegate()->getStyle('A5:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->getFont()->setBold(false);
            },
        ];
    }
}