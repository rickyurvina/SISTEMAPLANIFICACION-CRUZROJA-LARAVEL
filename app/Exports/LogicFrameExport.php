<?php

namespace App\Exports;

use App\Models\Admin\Company;
use App\Models\Common\Setting;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogicFrameExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $projectId;

    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    public function view(): View
    {
        $project = Project::findOrFail($this->projectId);
        $project->load(['objectives.results']);
        $companyName = Setting::where('company_id', $project->company_id)->where('key', 'company.name')->first()->value;
        $results = Task::with('indicators')->orderBy('objective_id', 'asc')
            ->orderBy('id', 'asc')
            ->where('project_id', $this->projectId)
            ->where('parent', '!=', 'root')
            ->where('type', 'project')->get();
        return view('modules.project.exports.logic-frame-export', compact('project', 'results', 'companyName'));
    }

    public function styles(Worksheet $sheet)
    {
        $highestRowAndColumn = $sheet->getHighestRowAndColumn();
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
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->applyFromArray($styleArray);
        $sheet->getStyle('A1:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->getAlignment();
    }
}
