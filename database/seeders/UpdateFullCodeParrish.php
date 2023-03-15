<?php

namespace Database\Seeders;

use App\Models\Common\CatalogGeographicClassifier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateFullCodeParrish extends Seeder
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
            CatalogGeographicClassifier::where('description', '=', 'SAN FRANCISCO DEL VERGEL')
                ->update([
                    'full_code' => '19.08.52'
                ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
