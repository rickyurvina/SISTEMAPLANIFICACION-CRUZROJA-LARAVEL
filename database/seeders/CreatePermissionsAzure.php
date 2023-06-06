<?php

namespace Database\Seeders;

use App\Jobs\Admin\AttachPermissionByAction;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class CreatePermissionsAzure extends Seeder
{
    use Jobs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            'admin' => [
                'Planning.Read' =>
                    [
                        'action'=>'',
                        'spanish_label'=>'Permiso de Azure para ingresar al portal de planificación'
                    ] ,
                'ERP.Read' =>
                    [
                        'action'=>'',
                        'spanish_label'=>'Permiso de Azure para ingresar al portal del ERP'
                    ] ,
            ]
        ];
        $this->ajaxDispatch(new AttachPermissionByAction($rows));
    }
}
