<?php

namespace App\Models\Projects\Stakeholders;

use App\Abstracts\Model;
use App\Models\Auth\User;
use Plank\Mediable\Mediable;

class ProjectCommunicationMatrix extends Model
{
    use  Mediable;

    protected bool $tenantable = false;

    protected $table = 'prj_project_communication_matrix';

    const OPEN='abierto';
    const CLOSED='cerrado';

    const NO_DELIVERED='No entregado';
    const DELIVERED='Entregado';

    const DAILY="diario";
    const WEEKLY="semanal";
    const MONTHLY="mensual";

    const EXECUTIVE_SUMMARY='Resumen Ejecutivo';
    const COMMUNICATIONAL_SUMMARY='Resumen Ejecutivo';
    const ACCOUNTABILITY_SUMMARY='Rendicion de cuentas';
    const ANNEXED='ANEXO';

    const REPORTS=
        [
            self::EXECUTIVE_SUMMARY,
            self::COMMUNICATIONAL_SUMMARY,
            self::ACCOUNTABILITY_SUMMARY,
            self::ANNEXED,
        ];


    const FREQUENCIES=[
      self::DAILY,
      self::WEEKLY,
      self::MONTHLY,
    ];

    protected $fillable =
        [
            'start_date',
            'end_date',
            'frequency',
            'state',
            'color',
            'information_type',
            'format_information_presentation',
            'user_id',
            'prj_project_stakeholder_id',
        ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->information_type = mb_strtoupper($model->information_type);
            $model->format_information_presentation = mb_strtoupper($model->format_information_presentation);
        });
        static::updating(function ($model){
            $model->information_type = mb_strtoupper($model->information_type);
            $model->format_information_presentation = mb_strtoupper($model->format_information_presentation);
        });
    }

    public function stakeholder()
    {
        return $this->belongsTo(ProjectStakeholder::class, 'prj_project_stakeholder_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
