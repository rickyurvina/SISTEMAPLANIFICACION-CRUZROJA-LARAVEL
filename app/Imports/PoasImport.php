<?php

namespace App\Imports;

use App\Models\Poa\PoaActivity;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PoasImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(Collection $rows)
    {
        return new PoaActivity([
            'code' => $row['code_program'],
            'poa_program_id' => $row['detalle_ingreso'],
            'indicator_unit_id' => $row['detalle_ingreso'],
            'plan_detail_id' => $row['detalle_ingreso'],
            'name' => $row['detalle_ingreso'],
            'user_id_in_charge' => $row['detalle_ingreso'],
            'status' => PoaActivity::STATUS_SCHEDULED,
            'cost' => $row['detalle_ingreso'],
            'impact' => $row['detalle_ingreso'],
            'complexity' => $row['detalle_ingreso'],
            'company_id' => session('company_id'),
            'location_id' => $row['detalle_ingreso'],
            'description' => $row['detalle_ingreso'],
            'measure_id' => $row['detalle_ingreso'],
            'aggregation_type' => $row['detalle_ingreso'],
            'measure' => $row['detalle_ingreso'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.code_program' => ['required', 'exists:plan_details,code'],
            '*.code_indicator' => ['required', 'exists:msr_measures,code'],
            '*.impact' => ['required', 'between:1,3'],
            '*.complexity' => ['required', 'between:1,3'],
            '*.cost' => ['nullable', 'numeric'],
            '*.code_location' => ['required', 'exists:catalog_geographic_classifiers,full_code'],
            '*.email_responsable' => ['required',  'exists:users,email'],
            '*.name_activity' => ['required', 'max:255'],
            '*.description' => ['nullable', 'max:500'],
            '*.code' =>['required','numeric'],
            '*.aggregation_type' =>  ['required', Rule::in(['sum', 'ave'])],
            '*.ene_planned' => ['nullable', 'numeric'],
            '*.feb_planned' =>  ['nullable', 'numeric'],
            '*.mar_planned' =>  ['nullable', 'numeric'],
            '*.abr_planned' =>  ['nullable', 'numeric'],
            '*.may_planned' =>  ['nullable', 'numeric'],
            '*.jun_planned' =>  ['nullable', 'numeric'],
            '*.jul_planned' =>  ['nullable', 'numeric'],
            '*.ago_planned' =>  ['nullable', 'numeric'],
            '*.sep_planned' =>  ['nullable', 'numeric'],
            '*.oct_planned' =>  ['nullable', 'numeric'],
            '*.nov_planned' =>  ['nullable', 'numeric'],
            '*.dic_planned' =>  ['nullable', 'numeric'],
            '*.ene_advanced' =>  ['nullable', 'numeric'],
            '*.feb_advanced' =>  ['nullable', 'numeric'],
            '*.mar_advanced' =>  ['nullable', 'numeric'],
            '*.abr_advanced' =>  ['nullable', 'numeric'],
            '*.may_advanced' =>  ['nullable', 'numeric'],
            '*.jun_advanced' =>  ['nullable', 'numeric'],
            '*.jul_advanced' =>  ['nullable', 'numeric'],
            '*.ago_advanced' =>  ['nullable', 'numeric'],
            '*.sep_advanced' =>  ['nullable', 'numeric'],
            '*.oct_advanced' =>  ['nullable', 'numeric'],
            '*.nov_advanced' =>  ['nullable', 'numeric'],
            '*.dic_advanced' =>  ['nullable', 'numeric']
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
