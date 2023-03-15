<?php

namespace App\Http\Livewire\Piat;

use App\Jobs\Poa\CreateMatrixReportAgreementsCommitments;
use App\Jobs\Poa\DeletePoaMatrixReportAgreementsCommitments;
use App\Models\Auth\User;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Models\Poa\Piat\PoaActivityPiatReport;
use App\Models\Poa\Piat\PoaMatrixReportBeneficiaries;
use App\Models\Projects\Activities\Task;
use App\Traits\Jobs;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use function flash;
use function user;

class PoaReportPiatModal extends Component
{
    use Jobs, WithFileUploads;

    //For PoaActivityPiat table

    public $piatReportAgreComm;
    public $agreCommResponsable;
    public $users;
    public $piat;
    public $piatReport;
    public $file = null;
    public $contMen = 0;
    public $contWomen = 0;
    public $contDisability = 0;
    public $under6 = 0;
    public $btw6And12 = 0;
    public $btw13And17 = 0;
    public $btw18And29 = 0;
    public $btw30And39 = 0;
    public $btw40And49 = 0;
    public $btw50And59 = 0;
    public $btw60And69 = 0;
    public $btw70And79 = 0;
    public $greaterThan80 = 0;
    public $agreCommDescription;
    public $accomplished = false;
    public $poaMatrixReportBeneficiaries;
    public array $goals = [];
    public $period;
    public $model;
    public $taskDetail;

    protected $listeners = [
        'loadReportForm' => 'edit'
    ];

    public function messages()
    {
        return [
            'reportInitTime.after' => 'La hora final debe ser antes de la hora inicio.',
        ];
    }

    public function mount()
    {
        $this->users = User::where('enabled', true)->get();
    }

    public function edit($id = null)
    {
        if ($id) {
            $this->piat = PoaActivityPiat::find($id);
            $this->model = $this->piat->piatable;
            if ($this->model) {
                if ($this->model->measureAdvances->count() > 0) {
                    $taskGoals = $this->model->measureAdvances;
                    if ($taskGoals->sum('goal') > 0) {
                        $this->goals = [];
                        $count = 1;
                        foreach ($taskGoals as $goal) {
                            $element = [];
                            $element['id'] = $goal->id;
                            $element['year'] = now()->format('Y');
                            $element['goal'] = $goal->goal;
                            $element['actual'] = $goal->actual;
                            $element['men'] = $goal->men;
                            $element['women'] = $goal->women;
                            if ($this->model::class == Task::class) {
                                $element['period'] = $goal->period()->first()->start_date->format('M,Y');
                            } else {
                                $element['period'] = Indicator::FREQUENCIES[12][$count] . ',' . $goal->period()->first()->start_date->format('Y');;
                            }
                            array_push($this->goals, $element);
                            $count++;
                        }
                    }
                }
            }
            $this->piatReport = PoaActivityPiatReport::with(
                [
                    'poaMatrixReportAgreementCommitment',
                    'responsableToApprove',
                    'poaMatrixReportBeneficiaries',
                    'responsableToCreate',
                    'piat'
                ])
                ->where('id_poa_activity_piat', $id)->first();
            $this->poaMatrixReportBeneficiaries = $this->piat->poaMatrixReportBeneficiaries;
            if ($this->piatReport) {
                $this->accomplished = $this->piatReport->accomplished;
                $this->beneficiariesReport();
                $this->piatReportAgreComm = $this->piatReport->poaMatrixReportAgreementCommitment;
            }
        }
    }

    public function submitAgreementsCommitments()
    {
        $data = $this->validate([
            'agreCommResponsable' => 'required',
            'agreCommDescription' => 'required',
        ]);
        $data += [
            'id_poa_activity_piat_report' => $this->piatReport->id,
            'responsable' => $this->agreCommResponsable,
            'description' => $this->agreCommDescription,
        ];
        $response = $this->ajaxDispatch(new CreateMatrixReportAgreementsCommitments($data));

        if ($response['success']) {
            $this->reset(
                [
                    'agreCommResponsable',
                    'agreCommDescription',
                ]);
            flash(trans_choice('messages.success.added_or_updated', 0, ['type' => __('general.poa_activity_piat_report_agreements')]))->success()->livewire($this);
        } else {
            flash(trans_choice('messages.error', 0, ['type' => __('general.poa_activity_piat_report_agreements')]))->error()->livewire($this);
        }
        self::edit($this->piat->id);
    }

    public function deleteAgreementsCommitments($idValue)
    {
        $response = $this->ajaxDispatch(new DeletePoaMatrixReportAgreementsCommitments($idValue));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => __('poa.piat_matrix_report_divider_agreement_commitment')]))->success()->livewire($this);
        } else {
            flash(trans_choice('messages.error', 0, ['type' => __('general.poa_activity_piat_report_agreements')]))->error()->livewire($this);
        }
        self::edit($this->piat->id);
    }

    public function updatedAccomplished($value)
    {
        $this->piatReport->accomplished = $value;
        $this->piatReport->save();
        $this->piatReport->refresh();
    }

    public function getCsvFile()
    {
        $this->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        try {
            $name = $this->file->getClientOriginalName();
            $tempPath = $this->file->getRealPath();
            $spreadsheet = IOFactory::load($tempPath);
            $sheet = $spreadsheet->getActiveSheet();
            $row_limit = $sheet->getHighestDataRow();
            $row_range = range(2, $row_limit);
            $data = array();
            $pivot = array();
            $cont = 0;

            DB::beginTransaction();

            foreach ($row_range as $row) {
                $data[] = [
                    'names' => $sheet->getCell('A' . $row)->getValue(),
                    'surnames' => $sheet->getCell('B' . $row)->getValue(),
                    'gender' => $sheet->getCell('C' . $row)->getFormattedValue(),
                    'identification' => $sheet->getCell('D' . $row)->getFormattedValue(),
                    'disability' => $sheet->getCell('E' . $row)->getValue(),
                    'age' => $sheet->getCell('F' . $row)->getValue(),
                ];

                $benefCreated = PoaMatrixReportBeneficiaries::create($data[$cont]);

                $pivot[$benefCreated->id] = [
                    'observations' => $sheet->getCell('G' . $row)->getValue(),
                    'belong_to_board' => $sheet->getCell('H' . $row)->getValue(),
                    'participation_initial_time' => $sheet->getCell('I' . $row)->getFormattedValue(),
                    'participation_end_time' => $sheet->getCell('J' . $row)->getFormattedValue(),
                ];
                $cont++;
            }
            if ($this->taskDetail->unit->is_for_people) {
                $oldAdvanceMen = $this->taskDetail->men;
                $oldAdvanceWomen = $this->taskDetail->women;
                $oldAdvance = $this->taskDetail->actual;
                $advanceMen = 0;
                $advanceWomen = 0;
                foreach ($data as $item) {
                    if ($item['gender'] == 'H') {
                        $advanceMen++;
                    } else {
                        $advanceWomen++;
                    }
                }
                $this->taskDetail->men = $oldAdvanceMen + $advanceMen;
                $this->taskDetail->women = $oldAdvanceWomen + $advanceWomen;
                $this->taskDetail->actual = $oldAdvance + $advanceMen + $advanceWomen;
                $this->taskDetail->save();
            }
            $this->piatReport->poaMatrixReportBeneficiaries()->attach($pivot);
            $this->reset(['file']);
            $this->dispatchBrowserEvent('fileReset');
            DB::commit();
            flash(trans_choice('messages.success.document_added', ['type' => __('general.poa_activity_piat_report_agreements')]))->success()->livewire($this);
            $this->piatReport->refresh();
            $this->beneficiariesReport();
        } catch (\Exception $exception) {
            DB::rollback();
            flash($exception->getMessage())->error()->livewire($this);
        }
    }

    public function beneficiariesReport()
    {
        $beneficiaries = $this->piatReport->poaMatrixReportBeneficiaries;

        $this->contWomen = 0;
        $this->contMen = 0;
        $this->contDisability = 0;

        $this->under6 = 0;
        $this->btw6And12 = 0;
        $this->btw13And17 = 0;
        $this->btw18And29 = 0;
        $this->btw30And39 = 0;
        $this->btw40And49 = 0;
        $this->btw50And59 = 0;
        $this->btw60And69 = 0;
        $this->btw70And79 = 0;
        $this->greaterThan80 = 0;

        foreach ($beneficiaries as $beneficiary) {
            if ($beneficiary->gender === 'M') {
                $this->contWomen++;
            } else {
                $this->contMen++;
            }

            if ($beneficiary->disability === 'SI') {
                $this->contDisability++;
            }

            $age = $beneficiary->age;
            switch ($age) {
                case ($age < 6):
                    $this->under6++;
                    break;
                case ($age >= 6 && $age <= 12):
                    $this->btw6And12++;
                    break;
                case ($age >= 13 && $age <= 17):
                    $this->btw13And17++;
                    break;
                case ($age >= 18 && $age <= 29):
                    $this->btw18And29++;
                    break;
                case ($age >= 30 && $age <= 39):
                    $this->btw30And39++;
                    break;
                case ($age >= 40 && $age <= 49):
                    $this->btw40And49++;
                    break;
                case ($age >= 50 && $age <= 59):
                    $this->btw50And59++;
                    break;
                case ($age >= 60 && $age <= 69):
                    $this->btw60And69++;
                    break;
                case ($age >= 70 && $age <= 79):
                    $this->btw70And79++;
                    break;
                case ($age > 80):
                    $this->greaterThan80++;
                    break;
            }
        }
    }

    public function approveReport()
    {
        if (user()->can('approve-piat-report-poa')) {
            $this->piatReport->update(
                [
                    'approved_by' => user()->id
                ]);
            flash(trans_choice('messages.success.approved', 0, ['type' => trans('general.poa_activity_piat_report')]))->success()->livewire($this);
        }
        $this->piatReport->refresh();
    }

    public function generateReport()
    {
        try {
            DB::beginTransaction();
            $this->piatReport = PoaActivityPiatReport::create(
                [
                    'id_poa_activity_piat' => $this->piat->id,
                    'accomplished' => false,
                    'approved_by' => -1,
                    'created_by' => user()->id,
                    'date' => now(),
                    'initial_time' => now()->format('H:i:s'),
                    'end_time' => now()->format('H:i:s', strtotime('now +1 hour'))
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            flash($e->getMessage())->error()->livewire($this);
            DB::rollBack();
        }
    }

    public function resetModal()
    {
        $this->reset(
            [
                'piatReportAgreComm',
                'agreCommResponsable',
                'piat',
                'piatReport',
                'file',
                'contMen',
                'contWomen',
                'contDisability',
                'under6',
                'btw6And12',
                'btw13And17',
                'btw18And29',
                'btw30And39',
                'btw40And49',
                'btw50And59',
                'btw60And69',
                'btw70And79',
                'greaterThan80',
                'agreCommDescription',
            ]);
    }

    public function downloadReportPiat()
    {
        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));
        return view('livewire.poa.reports.download.report-piat', ['date' => $date]);
        $pdf = PDFSnappy::loadView('livewire.poa.reports.download.report-piat');
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('dpi', 300);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ReportPiat.pdf');
    }

    public function updatedPeriod()
    {
        $this->taskDetail = $this->model->measureAdvances->find($this->period);
    }
}
