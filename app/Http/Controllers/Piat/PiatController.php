<?php

namespace App\Http\Controllers\Piat;

use App\Abstracts\Http\Controller;
use App\Jobs\Poa\PoaPiatActivityDeleteRescheduling;
use App\Models\Poa\Piat\PoaActivityPiatReport;
use App\Models\Poa\Piat\PoaActivityPiatRescheduling;
use App\Models\Poa\PoaActivity;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Illuminate\Support\Facades\Auth;

class PiatController extends Controller
{
    //
    public function reportPiat(PoaActivityPiatReport $activityPiatReport)
    {
        $activityPiatReport->load(
            [
                'piat',
                'responsableToCreate',
                'responsableToApprove',
                'poaMatrixReportAgreementCommitment',
                'poaMatrixReportBeneficiaries',
            ]);
        $activityPiatReport->loadMedia(['file']);
        $media = $activityPiatReport->media;
        $filesEdit = [];

        foreach ($media as $item) {
            $fileElement = [];
            $fileElement['id'] = $item->id;
            $fileElement['name'] = $item->filename;
            $fileElement['user_id'] = Auth::id();
            $fileElement['date'] = $item->created_at;
            array_push($filesEdit, $fileElement);
        }
        setlocale(LC_TIME, 'es_ES.utf8');
//        return view('livewire.poa.reports.download.report-piat',
//            [
//                'activityPiatReport' => $activityPiatReport,
//                'filesEdit' => $filesEdit,
//            ]);
        $pdf = PDFSnappy::loadView('livewire.poa.reports.download.report-piat',
            [
                'activityPiatReport' => $activityPiatReport,
                'filesEdit' => $filesEdit,
            ]);
        $pdf->setOption('orientation', 'Portrait');
        $pdf->setOption('margin-left', 8);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 8);
        $pdf->setOption('margin-bottom', 2);
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('print-media-type', true);
        $pdf->setOption('dpi', 300);
        $pdf->setOption('disable-smart-shrinking', false);
        $pdf->setOption('enable-smart-shrinking', true);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'reporte_piat.pdf');
    }

    public function showReschedulings($piat_id)
    {
        $piat = \App\Models\Poa\Piat\PoaActivityPiat::find($piat_id);
        if (user()->cannot('manage-reschedulings-poa-activity-piat' || 'view-reschedulings-poa-activity-piat')) {
            abort(403);
        } else {
            return view('modules.piat.activity-piat-rescheduling', ['piat' => $piat]);
        }
    }

    public function deleteRescheduling($rescheduleId)
    {
        $activityId=PoaActivityPiatRescheduling::find($rescheduleId)->poa_activity_piat_id;
        $response = $this->ajaxDispatch(new PoaPiatActivityDeleteRescheduling($rescheduleId));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.rescheduling', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('piat.piat_rescheduling', $activityId);
    }

}
