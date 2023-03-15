<?php

namespace Database\Seeders;

use App\Models\Projects\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateYearToProjects extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try {
            DB::beginTransaction();
            Project::where('year', '=', null)
                ->update(['year' => now()->year]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw  new \Exception($exception->getMessage());
        }
    }
}
