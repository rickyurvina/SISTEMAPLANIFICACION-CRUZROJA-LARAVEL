<?php

namespace Database\Seeders;

use App\Models\Common\Catalog;
use App\Models\Common\CatalogDetail;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $color_red = "#CC0027";
        $color_orange = "#F69200";
        $color_yellow = "#FFFF00";
        $color_green = "#33CC33";
        $color_dark_green = "#008A3E";

        $json_data = [
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Muy Bajo",
                "color" => $color_yellow,
                "value" => 10,
                "impact" => 10,
                "probability" => 1,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Muy Bajo",
                "color" => $color_yellow,
                "value" => 9,
                "impact" => 9,
                "probability" => 1,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Muy Bajo",
                "color" => $color_green,
                "value" => 8,
                "impact" => 8,
                "probability" => 1,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Muy Bajo",
                "color" => $color_green,
                "value" => 7,
                "impact" => 7,
                "probability" => 1,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Muy Bajo",
                "color" => $color_green,
                "value" => 6,
                "impact" => 6,
                "probability" => 1,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Muy Bajo",
                "color" => $color_dark_green,
                "value" => 5,
                "impact" => 5,
                "probability" => 1,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Muy Bajo",
                "color" => $color_dark_green,
                "value" => 4,
                "impact" => 4,
                "probability" => 1,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Muy Bajo",
                "color" => $color_dark_green,
                "value" => 3,
                "impact" => 3,
                "probability" => 1,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Muy Bajo",
                "color" => $color_dark_green,
                "value" => 2,
                "impact" => 2,
                "probability" => 1,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Muy Bajo",
                "color" => $color_dark_green,
                "value" => 1,
                "impact" => 1,
                "probability" => 1,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Bajo",
                "color" => $color_yellow,
                "value" => 20,
                "impact" => 10,
                "probability" => 2,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Bajo",
                "color" => $color_yellow,
                "value" => 18,
                "impact" => 9,
                "probability" => 2,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Bajo",
                "color" => $color_yellow,
                "value" => 16,
                "impact" => 8,
                "probability" => 2,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Bajo",
                "color" => $color_green,
                "value" => 14,
                "impact" => 7,
                "probability" => 2,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Bajo",
                "color" => $color_green,
                "value" => 12,
                "impact" => 6,
                "probability" => 2,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Bajo",
                "color" => $color_green,
                "value" => 10,
                "impact" => 5,
                "probability" => 2,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Bajo",
                "color" => $color_dark_green,
                "value" => 8,
                "impact" => 4,
                "probability" => 2,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Bajo",
                "color" => $color_dark_green,
                "value" => 6,
                "impact" => 3,
                "probability" => 2,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Bajo",
                "color" => $color_dark_green,
                "value" => 4,
                "impact" => 2,
                "probability" => 2,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Bajo",
                "color" => $color_dark_green,
                "value" => 2,
                "impact" => 1,
                "probability" => 2,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Medio Uno",
                "color" => $color_orange,
                "value" => 30,
                "impact" => 10,
                "probability" => 3,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Medio Uno",
                "color" => $color_yellow,
                "value" => 27,
                "impact" => 9,
                "probability" => 3,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Medio Uno",
                "color" => $color_yellow,
                "value" => 24,
                "impact" => 8,
                "probability" => 3,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Medio Uno",
                "color" => $color_yellow,
                "value" => 21,
                "impact" => 7,
                "probability" => 3,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Medio Uno",
                "color" => $color_green,
                "value" => 18,
                "impact" => 6,
                "probability" => 3,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Medio Uno",
                "color" => $color_green,
                "value" => 15,
                "impact" => 5,
                "probability" => 3,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Uno",
                "color" => $color_green,
                "value" => 12,
                "impact" => 4,
                "probability" => 3,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Uno",
                "color" => $color_dark_green,
                "value" => 9,
                "impact" => 3,
                "probability" => 3,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Uno",
                "color" => $color_dark_green,
                "value" => 6,
                "impact" => 2,
                "probability" => 3,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Medio Uno",
                "color" => $color_dark_green,
                "value" => 3,
                "impact" => 1,
                "probability" => 3,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Medio Dos",
                "color" => $color_orange,
                "value" => 40,
                "impact" => 10,
                "probability" => 4,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Medio Dos",
                "color" => $color_orange,
                "value" => 36,
                "impact" => 9,
                "probability" => 4,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Medio Dos",
                "color" => $color_yellow,
                "value" => 32,
                "impact" => 8,
                "probability" => 4,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Medio Dos",
                "color" => $color_yellow,
                "value" => 28,
                "impact" => 7,
                "probability" => 4,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Medio Dos",
                "color" => $color_yellow,
                "value" => 24,
                "impact" => 6,
                "probability" => 4,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Medio Dos",
                "color" => $color_green,
                "value" => 20,
                "impact" => 5,
                "probability" => 4,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Dos",
                "color" => $color_green,
                "value" => 16,
                "impact" => 4,
                "probability" => 4,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Dos",
                "color" => $color_green,
                "value" => 12,
                "impact" => 3,
                "probability" => 4,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Dos",
                "color" => $color_dark_green,
                "value" => 8,
                "impact" => 2,
                "probability" => 4,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Medio Dos",
                "color" => $color_dark_green,
                "value" => 4,
                "impact" => 1,
                "probability" => 4,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Medio Alto Uno",
                "color" => $color_orange,
                "value" => 50,
                "impact" => 10,
                "probability" => 5,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Medio Alto Uno",
                "color" => $color_orange,
                "value" => 45,
                "impact" => 9,
                "probability" => 5,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Medio Alto Uno",
                "color" => $color_orange,
                "value" => 40,
                "impact" => 8,
                "probability" => 5,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Medio Alto Uno",
                "color" => $color_yellow,
                "value" => 35,
                "impact" => 7,
                "probability" => 5,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Medio Alto Uno",
                "color" => $color_yellow,
                "value" => 30,
                "impact" => 6,
                "probability" => 5,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Medio Alto Uno",
                "color" => $color_yellow,
                "value" => 25,
                "impact" => 5,
                "probability" => 5,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Uno",
                "color" => $color_green,
                "value" => 20,
                "impact" => 4,
                "probability" => 5,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Uno",
                "color" => $color_green,
                "value" => 15,
                "impact" => 3,
                "probability" => 5,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Uno",
                "color" => $color_green,
                "value" => 10,
                "impact" => 2,
                "probability" => 5,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Medio Alto Uno",
                "color" => $color_dark_green,
                "value" => 5,
                "impact" => 1,
                "probability" => 5,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Medio Alto Dos",
                "color" => $color_red,
                "value" => 60,
                "impact" => 10,
                "probability" => 6,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Medio Alto Dos",
                "color" => $color_orange,
                "value" => 54,
                "impact" => 9,
                "probability" => 6,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Medio Alto Dos",
                "color" => $color_orange,
                "value" => 48,
                "impact" => 8,
                "probability" => 6,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Medio Alto Dos",
                "color" => $color_orange,
                "value" => 42,
                "impact" => 7,
                "probability" => 6,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Medio Alto Dos",
                "color" => $color_yellow,
                "value" => 36,
                "impact" => 6,
                "probability" => 6,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Medio Alto Dos",
                "color" => $color_yellow,
                "value" => 30,
                "impact" => 5,
                "probability" => 6,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Dos",
                "color" => $color_yellow,
                "value" => 24,
                "impact" => 4,
                "probability" => 6,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Dos",
                "color" => $color_green,
                "value" => 18,
                "impact" => 3,
                "probability" => 6,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Medio Alto Dos",
                "color" => $color_green,
                "value" => 12,
                "impact" => 2,
                "probability" => 6,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Medio Alto Dos",
                "color" => $color_green,
                "value" => 6,
                "impact" => 1,
                "probability" => 6,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Alto Uno",
                "color" => $color_red,
                "value" => 70,
                "impact" => 10,
                "probability" => 7,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Alto Uno",
                "color" => $color_red,
                "value" => 63,
                "impact" => 9,
                "probability" => 7,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Alto Uno",
                "color" => $color_orange,
                "value" => 56,
                "impact" => 8,
                "probability" => 7,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Alto Uno",
                "color" => $color_orange,
                "value" => 49,
                "impact" => 7,
                "probability" => 7,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Alto Uno",
                "color" => $color_orange,
                "value" => 42,
                "impact" => 6,
                "probability" => 7,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Alto Uno",
                "color" => $color_yellow,
                "value" => 35,
                "impact" => 5,
                "probability" => 7,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Uno",
                "color" => $color_yellow,
                "value" => 28,
                "impact" => 4,
                "probability" => 7,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Uno",
                "color" => $color_yellow,
                "value" => 21,
                "impact" => 3,
                "probability" => 7,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Uno",
                "color" => $color_green,
                "value" => 14,
                "impact" => 2,
                "probability" => 7,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Alto Uno",
                "color" => $color_green,
                "value" => 7,
                "impact" => 1,
                "probability" => 7,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Alto Dos",
                "color" => $color_red,
                "value" => 80,
                "impact" => 10,
                "probability" => 8,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Alto Dos",
                "color" => $color_red,
                "value" => 72,
                "impact" => 9,
                "probability" => 8,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Alto Dos",
                "color" => $color_red,
                "value" => 64,
                "impact" => 8,
                "probability" => 8,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Alto Dos",
                "color" => $color_orange,
                "value" => 56,
                "impact" => 7,
                "probability" => 8,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Alto Dos",
                "color" => $color_orange,
                "value" => 48,
                "impact" => 6,
                "probability" => 8,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Alto Dos",
                "color" => $color_orange,
                "value" => 40,
                "impact" => 5,
                "probability" => 8,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Dos",
                "color" => $color_yellow,
                "value" => 32,
                "impact" => 4,
                "probability" => 8,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Dos",
                "color" => $color_yellow,
                "value" => 24,
                "impact" => 3,
                "probability" => 8,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Alto Dos",
                "color" => $color_yellow,
                "value" => 16,
                "impact" => 2,
                "probability" => 8,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Alto Dos",
                "color" => $color_green,
                "value" => 8,
                "impact" => 1,
                "probability" => 8,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Es un hecho uno",
                "color" => $color_red,
                "value" => 90,
                "impact" => 10,
                "probability" => 9,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Es un hecho uno",
                "color" => $color_red,
                "value" => 81,
                "impact" => 9,
                "probability" => 9,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Es un hecho uno",
                "color" => $color_red,
                "value" => 72,
                "impact" => 8,
                "probability" => 9,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Es un hecho uno",
                "color" => $color_red,
                "value" => 63,
                "impact" => 7,
                "probability" => 9,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Es un hecho uno",
                "color" => $color_orange,
                "value" => 54,
                "impact" => 6,
                "probability" => 9,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Es un hecho uno",
                "color" => $color_orange,
                "value" => 45,
                "impact" => 5,
                "probability" => 9,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho uno",
                "color" => $color_orange,
                "value" => 36,
                "impact" => 4,
                "probability" => 9,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho uno",
                "color" => $color_yellow,
                "value" => 27,
                "impact" => 3,
                "probability" => 9,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho uno",
                "color" => $color_yellow,
                "value" => 18,
                "impact" => 2,
                "probability" => 9,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Es un hecho uno",
                "color" => $color_yellow,
                "value" => 9,
                "impact" => 1,
                "probability" => 9,
            ],
            [
                "y" => "Falla inminente del proyecto si riesgo sucede",
                "x" => "Es un hecho dos",
                "color" => $color_red,
                "value" => 100,
                "impact" => 10,
                "probability" => 10,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto en 40% o proyecto demora un 40% más",
                "x" => "Es un hecho dos",
                "color" => $color_red,
                "value" => 90,
                "impact" => 9,
                "probability" => 10,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 30-40% o proyecto demora 30-40% más",
                "x" => "Es un hecho dos",
                "color" => $color_red,
                "value" => 80,
                "impact" => 8,
                "probability" => 10,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 20-30% o proyecto demora 20-30% más",
                "x" => "Es un hecho dos",
                "color" => $color_red,
                "value" => 70,
                "impact" => 7,
                "probability" => 10,
            ],
            [
                "y" => "Proyecto con sobre-presupuesto entre 10-20% o proyecto demora 10-20% más",
                "x" => "Es un hecho dos",
                "color" => $color_red,
                "value" => 60,
                "impact" => 6,
                "probability" => 10,
            ],
            [
                "y" => "Proyecto con un márgen bajo-medio de presupuesto",
                "x" => "Es un hecho dos",
                "color" => $color_orange,
                "value" => 50,
                "impact" => 5,
                "probability" => 10,
            ],
            [
                "y" => "Amplia reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho dos",
                "color" => $color_orange,
                "value" => 40,
                "impact" => 4,
                "probability" => 10,
            ],
            [
                "y" => "Media reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho dos",
                "color" => $color_orange,
                "value" => 30,
                "impact" => 3,
                "probability" => 10,
            ],
            [
                "y" => "Pequeña reducción de tiempo o reservas de presupuesto",
                "x" => "Es un hecho dos",
                "color" => $color_yellow,
                "value" => 20,
                "impact" => 2,
                "probability" => 10,
            ],
            [
                "y" => "No existe impacto en el proyecto",
                "x" => "Es un hecho dos",
                "color" => $color_yellow,
                "value" => 10,
                "impact" => 1,
                "probability" => 10,
            ]
        ];


        // Inicio Datos Formulario Uno //
        $json_justification_data_form_one = [
            [
                "code" => "001",
                "description" => "¿Redacta la misión, visión y la experiencia de CRE en la propuesta?",
                "mandatory" => false
            ],
            [
                "code" => "002",
                "description" => "¿Atiende las necesidades sentidas por la Comunidad? (fuente primaria)",
                "mandatory" => true
            ],
            [
                "code" => "003",
                "description" => "¿Identifica la Problemática con datos de fuentes oficiales? (fuente secundaria)",
                "mandatory" => true
            ],
            [
                "code" => "004",
                "description" => "¿Plantea la solución a la problemática?",
                "mandatory" => true
            ],
            [
                "code" => "005",
                "description" => "¿Plantea una alineación estratégica en los 3 niveles ODS,  Plan Nacional de Desarrollo, Objetivos CRE?",
                "mandatory" => false
            ]
        ];

        $json_objectives_data_form_one = [
            [
                "code" => "006",
                "description" => "¿Los objetivos generales y especificos estan enfocados al problema identificado?",
                "mandatory" => true
            ],
            [
                "code" => "007",
                "description" => "¿Las metas establecidas son alcanzables y suficientes conforme a la propuesta y estructura operativa?",
                "mandatory" => true
            ]
        ];

        $json_beneficiaries_data_form_one = [
            [
                "code" => "008",
                "description" => "¿Realiza la identificación de beneficiarios?",
                "mandatory" => true
            ],
            [
                "code" => "009",
                "description" => "¿Describe la metodología o criterios de selección de beneficiarios directos e indirectos?",
                "mandatory" => false
            ],
            [
                "code" => "010",
                "description" => "¿Se especifica claramente el número de beneficiarios directos e indirectos?",
                "mandatory" => true
            ]
        ];

        $json_budget_data_form_one = [
            [
                "code" => "011",
                "description" => "¿Contempla el cálculo total de las actividades a ser financiadas?",
                "mandatory" => true
            ],
            [
                "code" => "012",
                "description" => "¿Contempla el cálculo de las actividades  contraparte de CRE y la comunidad?",
                "mandatory" => false
            ]
        ];

        $json_methodology_data_form_one = [
            [
                "code" => "013",
                "description" => "¿Tiene establecido el Cronograma de Actividades?",
                "mandatory" => true
            ],
            [
                "code" => "014",
                "description" => "¿Contempla la fase de arranque y cierre dentro de la fecha elegible de gasto?",
                "mandatory" => false
            ]
        ];
        // Inicio Datos Formulario Uno //

        // Inicio Datos Formulario Dos //
        $json_justification_data_form_two = [
            [
                "code" => "001",
                "description" => "¿Redacta la misión, visión y la experiencia de CRE en la propuesta ?",
                "mandatory" => false
            ],
            [
                "code" => "002",
                "description" => "¿Atiende las necesidades sentidas por la Comunidad? (fuente primaria)",
                "mandatory" => true
            ],
            [
                "code" => "003",
                "description" => "¿Identifica la Problemática con datos de fuentes oficiales? (fuente secundaria)",
                "mandatory" => true
            ],
            [
                "code" => "004",
                "description" => "¿Existe la identificación de actores claves (acercamiento previo con Gobiernos y actores locales)?",
                "mandatory" => true
            ],
            [
                "code" => "005",
                "description" => "¿Plantea una alineación estratégica en los 3 niveles ODS, Plan Toda una Vida, Objetivos CRE?",
                "mandatory" => false
            ],
            [
                "code" => "006",
                "description" => "¿Plantea la solución a la problemática?",
                "mandatory" => true
            ]
        ];

        $json_beneficiaries_data_form_two = [
            [
                "code" => "007",
                "description" => "¿Realiza la identificación de beneficiarios?",
                "mandatory" => true
            ],
            [
                "code" => "008",
                "description" => "¿Describe la metodología o criterios de selección de beneficiarios directos e indirectos?",
                "mandatory" => true
            ],
            [
                "code" => "009",
                "description" => "¿Se especifica claramente el número de beneficiarios directos e indirectos?",
                "mandatory" => true
            ]
        ];

        $json_logic_frame_data_form_two = [
            [
                "code" => "010",
                "description" => "¿Los objetivos generales y especificos estan enfocados al problema identificado?",
                "mandatory" => true
            ],
            [
                "code" => "011",
                "description" => "¿Los indicadores establecidos contribuyen a medir los objetivos planteados?",
                "mandatory" => true
            ],
            [
                "code" => "012",
                "description" => "¿Las metas establecidas son alcanzables y suficientes conforme a la propuesta y estructura operativa?",
                "mandatory" => true
            ],
            [
                "code" => "013",
                "description" => "¿Establece claramente cuales son las fuentes de verificación y son consecuentes a los productos esperados?",
                "mandatory" => true
            ],
            [
                "code" => "014",
                "description" => "¿Plantea supuestos objetivos que permiten indentificar los riesgos?",
                "mandatory" => false
            ],
            [
                "code" => "015",
                "description" => "¿Plantea las actividades por componente?",
                "mandatory" => true
            ]
        ];

        $json_budget_data_form_two = [
            [
                "code" => "016",
                "description" => "¿Contempla el cálculo de los costos directos? (actividades involucradas en los productos del proyecto)",
                "mandatory" => true
            ],
            [
                "code" => "017",
                "description" => "¿Contempla el cálculo de los costos indirectos? (actividades de soporte del proyeto)",
                "mandatory" => true
            ],
            [
                "code" => "018",
                "description" => "¿Contempla el cálculo de la contraparte de forma valorada?",
                "mandatory" => false
            ],
            [
                "code" => "019",
                "description" => "¿El presupuesto esta detallado de acuerdo a las actividades planteadas?",
                "mandatory" => true
            ]
        ];

        $json_methodology_data_form_two = [
            [
                "code" => "020",
                "description" => "¿Realiza el análisis de Capacidades Operativas de CRE de acuerdo a la cobertura geográfica?   ",
                "mandatory" => false
            ],
            [
                "code" => "021",
                "description" => "¿La operación describe los procesos para alcanzar las metas propuestas?",
                "mandatory" => false
            ],
            [
                "code" => "022",
                "description" => "¿Tiene estudios técnicos previos? (estudios de mercado, permisos ambientales, legalización de predios,etc) si aplica",
                "mandatory" => false
            ],
            [
                "code" => "023",
                "description" => "¿Tiene Documentos Habilitantes? (cartas de compromisos o acuerdos con la comunidad y JP/ GAD entre otros)",
                "mandatory" => false
            ],
            [
                "code" => "024",
                "description" => "¿Tiene establecido el Cronograma de Actividades?",
                "mandatory" => true
            ],
            [
                "code" => "025",
                "description" => "¿Contempla fase de arranque y cierre dentro de la fecha elegible de gasto?",
                "mandatory" => false
            ],
            [
                "code" => "026",
                "description" => "¿Plantea cual sería el Organigrama, flujo de comunicación y distribución de responsabilidades del equipo de proyecto?",
                "mandatory" => false
            ]
        ];
        // Inicio Datos Formulario Dos //

        $json_data_capability1 = [
            [
                "id" => 1,
                "criterio_calificacion" => "Personal técnico acorde a la propuesta",
                "cumple" => false,
            ],
            [
                "id" => 2,
                "criterio_calificacion" => "Disponibilidad de Personal Voluntario",
                "cumple" => false,
            ],
            [
                "id" => 3,
                "criterio_calificacion" => "Equipamiento disponible para la operación",
                "cumple" => false,
            ],
            [
                "id" => 4,
                "criterio_calificacion" => "Logística",
                "cumple" => false,
            ],
        ];

        $json_data_capability2 = [
            [
                "id" => 1,
                "criterio_calificacion" => "Obligaciones tributarias al día",
                "cumple" => false,
            ],
            [
                "id" => 2,
                "criterio_calificacion" => "Presenta estados financiaeros",
                "cumple" => false,
            ],
            [
                "id" => 3,
                "criterio_calificacion" => "Cuenta con responsable contable",
                "cumple" => false,
            ],
            [
                "id" => 4,
                "criterio_calificacion" => "Cuenta con personal administrativo / fianciero",
                "cumple" => false,
            ],
            [
                "id" => 5,
                "criterio_calificacion" => "Obligaciones patronales al día",
                "cumple" => false,
            ],
            [
                "id" => 6,
                "criterio_calificacion" => "Cumple procedimientos y reglamento de compras de CRE",
                "cumple" => false,
            ],
        ];

        $json_data_capability3 = [
            [
                "id" => 1,
                "criterio_calificacion" => "Experiencia en los componentes de la propuesta",
                "cumple" => false,
            ],
            [
                "id" => 2,
                "criterio_calificacion" => "Ha gestionado proyectos en los últimos 3 años",
                "cumple" => false,
            ],
            [
                "id" => 3,
                "criterio_calificacion" => "Cuenta con un referente en la gestión de proyectos",
                "cumple" => false,
            ],
        ];

        //Categorization CatalogSeeder
        $catalog_initial_data = [
            ['name' => 'classifications', 'description' => 'classifications'],
            ['name' => 'social_network_types', 'description' => 'social_network_types'],
            ['name' => 'genders', 'description' => 'genders'],
            ['name' => 'beneficiaries', 'description' => 'beneficiaries'],
            ['name' => 'project_services', 'description' => 'project_services'],
            ['name' => 'project_lines_action', 'description' => 'project_lines_action'],
            ['name' => 'project_priority_zones', 'description' => 'project_priority_zones'],
            ['name' => 'project_beneficiary_types', 'description' => 'project_beneficiary_types'],
            ['name' => 'project_member_place', 'description' => 'project_member_place'],
            ['name' => 'risk_states', 'description' => 'risk_states'],
            ['name' => 'risk_impact_probability_catalog', 'description' => 'risk_impact_probability_catalog'],
            ['name' => 'response_plan_states', 'description' => 'response_plan_states'],
            ['name' => 'measurement_unit', 'description' => 'measurement_unit'],
            ['name' => 'acquisition_type', 'description' => 'acquisition_type'],

            ['name' => 'question_one_form_one', 'description' => 'question_one_form_one'],
            ['name' => 'question_two_form_one', 'description' => 'question_two_form_one'],
            ['name' => 'question_three_form_one', 'description' => 'question_three_form_one'],
            ['name' => 'question_four_form_one', 'description' => 'question_four_form_one'],
            ['name' => 'question_five_form_one', 'description' => 'question_five_form_one'],
            ['name' => 'question_six_form_one', 'description' => 'question_six_form_one'],
            ['name' => 'question_seven_form_one', 'description' => 'question_seven_form_one'],
            ['name' => 'question_eight_form_one', 'description' => 'question_eight_form_one'],
            ['name' => 'question_nine_form_one', 'description' => 'question_nine_form_one'],

            ['name' => 'question_one_form_two', 'description' => 'question_one_form_two'],
            ['name' => 'question_two_form_two', 'description' => 'question_two_form_two'],
            ['name' => 'question_three_form_two', 'description' => 'question_three_form_two'],
            ['name' => 'question_four_form_two', 'description' => 'question_four_form_two'],
            ['name' => 'question_five_form_two', 'description' => 'question_five_form_two'],
            ['name' => 'question_six_form_two', 'description' => 'question_six_form_two'],
            ['name' => 'question_seven_form_two', 'description' => 'question_seven_form_two'],
            ['name' => 'question_eight_form_two', 'description' => 'question_eight_form_two'],
            ['name' => 'question_nine_form_two', 'description' => 'question_nine_form_two'],
            ['name' => 'question_ten_form_two', 'description' => 'question_ten_form_two'],
            ['name' => 'question_eleven_form_two', 'description' => 'question_eleven_form_two'],
            ['name' => 'question_twelve_form_two', 'description' => 'question_twelve_form_two'],
            ['name' => 'question_thirteen_form_two', 'description' => 'question_thirteen_form_two'],
            ['name' => 'question_fourteen_form_two', 'description' => 'question_fourteen_form_two'],
            ['name' => 'types_risks', 'description' => 'types_risks'],
            ['name' => 'team_roles', 'description' => 'team_roles'],
            ['name' => 'help_messages', 'description' => 'help_messages'],
        ];

        foreach ($catalog_initial_data as $initial_datum) {
            Catalog::create($initial_datum);
        }

        $classification_id = Catalog::catalogName('CLASSIFICATIONS')->first()->id;
        $social_network_type_id = Catalog::catalogName('SOCIAL_NETWORK_TYPES')->first()->id;
        $gender_id = Catalog::catalogName('GENDERS')->first()->id;
        $beneficiary_id = Catalog::catalogName('BENEFICIARIES')->first()->id;
        $project_service_id = Catalog::catalogName('PROJECT_SERVICES')->first()->id;
        $project_line_action_id = Catalog::catalogName('PROJECT_LINES_ACTION')->first()->id;
        $project_priority_zone_id = Catalog::catalogName('PROJECT_PRIORITY_ZONES')->first()->id;
        $project_beneficiary_type_id = Catalog::catalogName('PROJECT_BENEFICIARY_TYPES')->first()->id;
        $project_member_place_id = Catalog::catalogName('PROJECT_MEMBER_PLACE')->first()->id;
        $risk_state_id = Catalog::catalogName('RISK_STATES')->first()->id;
        $risk_impact_probability_catalog_id = Catalog::catalogName('RISK_IMPACT_PROBABILITY_CATALOG')->first()->id;
        $response_plan_state_id = Catalog::catalogName('RESPONSE_PLAN_STATES')->first()->id;
        $measurement_unit_id = Catalog::catalogName('MEASUREMENT_UNIT')->first()->id;
        $acquisition_type_id = Catalog::catalogName('ACQUISITION_TYPE')->first()->id;
        $types_risks = Catalog::catalogName('TYPES_RISKS')->first()->id;
        $team_roles = Catalog::catalogName('TEAM_ROLES')->first()->id;
        $help_messages = Catalog::catalogName('HELP_MESSAGES')->first()->id;

        $question_one_form_one_id = Catalog::catalogName('QUESTION_ONE_FORM_ONE')->first()->id;
        $question_two_form_one_id = Catalog::catalogName('QUESTION_TWO_FORM_ONE')->first()->id;
        $question_three_form_one_id = Catalog::catalogName('QUESTION_THREE_FORM_ONE')->first()->id;
        $question_four_form_one_id = Catalog::catalogName('QUESTION_FOUR_FORM_ONE')->first()->id;
        $question_five_form_one_id = Catalog::catalogName('QUESTION_FIVE_FORM_ONE')->first()->id;
        $question_six_form_one_id = Catalog::catalogName('QUESTION_SIX_FORM_ONE')->first()->id;
        $question_seven_form_one_id = Catalog::catalogName('QUESTION_SEVEN_FORM_ONE')->first()->id;
        $question_eight_form_one_id = Catalog::catalogName('QUESTION_EIGHT_FORM_ONE')->first()->id;
        $question_nine_form_one_id = Catalog::catalogName('QUESTION_NINE_FORM_ONE')->first()->id;

        $question_one_form_two_id = Catalog::catalogName('QUESTION_ONE_FORM_TWO')->first()->id;
        $question_two_form_two_id = Catalog::catalogName('QUESTION_TWO_FORM_TWO')->first()->id;
        $question_three_form_two_id = Catalog::catalogName('QUESTION_THREE_FORM_TWO')->first()->id;
        $question_four_form_two_id = Catalog::catalogName('QUESTION_FOUR_FORM_TWO')->first()->id;
        $question_five_form_two_id = Catalog::catalogName('QUESTION_FIVE_FORM_TWO')->first()->id;
        $question_six_form_two_id = Catalog::catalogName('QUESTION_SIX_FORM_TWO')->first()->id;
        $question_seven_form_two_id = Catalog::catalogName('QUESTION_SEVEN_FORM_TWO')->first()->id;
        $question_eight_form_two_id = Catalog::catalogName('QUESTION_EIGHT_FORM_TWO')->first()->id;
        $question_nine_form_two_id = Catalog::catalogName('QUESTION_NINE_FORM_TWO')->first()->id;
        $question_ten_form_two_id = Catalog::catalogName('QUESTION_TEN_FORM_TWO')->first()->id;
        $question_eleven_form_two_id = Catalog::catalogName('QUESTION_ELEVEN_FORM_TWO')->first()->id;
        $question_twelve_form_two_id = Catalog::catalogName('QUESTION_TWELVE_FORM_TWO')->first()->id;
        $question_thirteen_form_two_id = Catalog::catalogName('QUESTION_THIRTEEN_FORM_TWO')->first()->id;
        $question_fourteen_form_two_id = Catalog::catalogName('QUESTION_FOURTEEN_FORM_TWO')->first()->id;

        $catalog_detail_initial_data = [
            ['catalog_id' => $classification_id, 'code' => '001', 'description' => 'Clasificación Uno'],
            ['catalog_id' => $classification_id, 'code' => '002', 'description' => 'Clasificación Dos'],
            ['catalog_id' => $classification_id, 'code' => '003', 'description' => 'Clasificación Tres'],
            ['catalog_id' => $social_network_type_id, 'code' => 'social_n1', 'description' => 'Facebook'],
            ['catalog_id' => $social_network_type_id, 'code' => 'social_n2', 'description' => 'Instagram'],
            ['catalog_id' => $social_network_type_id, 'code' => 'social_n3', 'description' => 'Linkedin'],
            ['catalog_id' => $social_network_type_id, 'code' => 'social_n4', 'description' => 'Youtube'],
            ['catalog_id' => $social_network_type_id, 'code' => 'social_n5', 'description' => 'Twitter'],
            ['catalog_id' => $gender_id, 'code' => 'gender_01', 'description' => 'Masculino'],
            ['catalog_id' => $gender_id, 'code' => 'gender_02', 'description' => 'Femenino'],
            ['catalog_id' => $gender_id, 'code' => 'gender_03', 'description' => 'Otros'],
            ['catalog_id' => $beneficiary_id, 'code' => '1', 'description' => 'Hombres'],
            ['catalog_id' => $beneficiary_id, 'code' => '2', 'description' => 'Mujeres'],
            ['catalog_id' => $beneficiary_id, 'code' => '3', 'description' => 'Nacionalidad o Pueblo indígena'],
            ['catalog_id' => $beneficiary_id, 'code' => '4', 'description' => 'Personas en situación de movilidad humana'],
            ['catalog_id' => $beneficiary_id, 'code' => '5', 'description' => 'Niños, niñas y adolescentes (NNA)'],
            ['catalog_id' => $beneficiary_id, 'code' => '6', 'description' => 'Personas con enfermedades catastróficas'],
            ['catalog_id' => $beneficiary_id, 'code' => '7', 'description' => 'Adultos mayores'],
            ['catalog_id' => $beneficiary_id, 'code' => '8', 'description' => 'Personas que viven con VIH'],
            ['catalog_id' => $beneficiary_id, 'code' => '9', 'description' => 'Personas con discapacidad'],
            ['catalog_id' => $project_service_id, 'code' => '1', 'description' => 'Atención PreHospitalaria'],
            ['catalog_id' => $project_service_id, 'code' => '2', 'description' => 'Capacitación'],
            ['catalog_id' => $project_line_action_id, 'code' => '1', 'description' => 'Salud'],
            ['catalog_id' => $project_line_action_id, 'code' => '2', 'description' => 'Educación'],
            ['catalog_id' => $project_line_action_id, 'code' => '3', 'description' => 'Medio Ambiente'],
            ['catalog_id' => $project_line_action_id, 'code' => '4', 'description' => 'Gestión de Riesgos'],
            ['catalog_id' => $project_priority_zone_id, 'code' => '1', 'description' => 'Zona 1'],
            ['catalog_id' => $project_priority_zone_id, 'code' => '2', 'description' => 'Zona 2'],
            ['catalog_id' => $project_priority_zone_id, 'code' => '3', 'description' => 'Zona 3'],
            ['catalog_id' => $project_priority_zone_id, 'code' => '4', 'description' => 'Zona 4'],
            ['catalog_id' => $project_beneficiary_type_id, 'code' => '1', 'description' => 'Directo'],
            ['catalog_id' => $project_beneficiary_type_id, 'code' => '2', 'description' => 'Indirecto'],
            ['catalog_id' => $project_member_place_id, 'code' => 'headquarters', 'description' => 'Sede Central'],
            ['catalog_id' => $project_member_place_id, 'code' => 'province', 'description' => 'Junta Provincial'],
            ['catalog_id' => $project_member_place_id, 'code' => 'canton', 'description' => 'Junta Cantonal'],
            ['catalog_id' => $risk_state_id, 'code' => '1', 'description' => 'Abierto'],
            ['catalog_id' => $risk_state_id, 'code' => '2', 'description' => 'Cerrado'],
            ['catalog_id' => $risk_impact_probability_catalog_id, 'code' => '1', 'description' => 'risk_impact_probability_catalog', 'properties' => $json_data],
            ['catalog_id' => $response_plan_state_id, 'code' => '1', 'description' => 'No Cumplido'],
            ['catalog_id' => $response_plan_state_id, 'code' => '2', 'description' => 'Cumplido'],
            ['catalog_id' => $measurement_unit_id, 'code' => '1', 'description' => 'Unidades'],
            ['catalog_id' => $measurement_unit_id, 'code' => '2', 'description' => 'Paquetes'],
            ['catalog_id' => $measurement_unit_id, 'code' => '3', 'description' => 'Metros'],
            ['catalog_id' => $measurement_unit_id, 'code' => '4', 'description' => 'Kilos'],
            ['catalog_id' => $measurement_unit_id, 'code' => '5', 'description' => 'Litros'],
            ['catalog_id' => $acquisition_type_id, 'code' => '1', 'description' => 'Comité de Compras'],
            ['catalog_id' => $acquisition_type_id, 'code' => '2', 'description' => 'Compra Directa'],

            ['catalog_id' => $question_one_form_one_id, 'code' => '1', 'description' => '¿Cumple con todos los parámetros del Formato de perfil  de proyecto CRE/ Financiadores?'],
            ['catalog_id' => $question_two_form_one_id, 'code' => '2', 'description' => '¿Se realizó el análisis de viabilidad del proyecto?'],
            ['catalog_id' => $question_three_form_one_id, 'code' => '3', 'description' => 'Antecedentes y Justificación', 'properties' => $json_justification_data_form_one],
            ['catalog_id' => $question_four_form_one_id, 'code' => '4', 'description' => 'Objetivos y Resultados', 'properties' => $json_objectives_data_form_one],
            ['catalog_id' => $question_five_form_one_id, 'code' => '5', 'description' => 'Beneficiarios', 'properties' => $json_beneficiaries_data_form_one],
            ['catalog_id' => $question_six_form_one_id, 'code' => '6', 'description' => 'Presupuesto', 'properties' => $json_budget_data_form_one],
            ['catalog_id' => $question_seven_form_one_id, 'code' => '7', 'description' => 'Metodología de Implementación', 'properties' => $json_methodology_data_form_one],
            ['catalog_id' => $question_eight_form_one_id, 'code' => '8', 'description' => '¿Cuenta con la participación de la Junta provincial y lo sustenta con un medio de verificación (correo, acta de reunión, memo, oficio)?'],
            ['catalog_id' => $question_nine_form_one_id, 'code' => '9', 'description' => '¿La formulación de la propuesta involucró a los actores según el esquema de trabajo?'],

            ['catalog_id' => $question_one_form_two_id, 'code' => '1', 'description' => '¿Se realizó el análisis de viabilidad del proyecto?'],
            ['catalog_id' => $question_two_form_two_id, 'code' => '2', 'description' => '¿Cumple con todos los parámetros del Formato CRE?'],
            ['catalog_id' => $question_three_form_two_id, 'code' => '3', 'description' => '¿Cuenta con la participación de la Junta provincial y lo sustenta con un medio de verificación (correo, acta de reunión, memo, oficio)?'],
            ['catalog_id' => $question_four_form_two_id, 'code' => '4', 'description' => 'Antecedentes y Justificación', 'properties' => $json_justification_data_form_two],
            ['catalog_id' => $question_five_form_two_id, 'code' => '5', 'description' => 'Beneficiarios', 'properties' => $json_beneficiaries_data_form_two],
            ['catalog_id' => $question_six_form_two_id, 'code' => '6', 'description' => 'Marco Lógico', 'properties' => $json_logic_frame_data_form_two],
            ['catalog_id' => $question_seven_form_two_id, 'code' => '7', 'description' => 'Presupuesto', 'properties' => $json_budget_data_form_two],
            ['catalog_id' => $question_eight_form_two_id, 'code' => '8', 'description' => 'Metodología de Implementación', 'properties' => $json_methodology_data_form_two],
            ['catalog_id' => $question_nine_form_two_id, 'code' => '9', 'description' => '¿Plantea la estrategia de salida y la sostenibilidad de la propuesta?'],
            ['catalog_id' => $question_ten_form_two_id, 'code' => '10', 'description' => '¿Establece la metodología de Seguimiento?'],
            ['catalog_id' => $question_eleven_form_two_id, 'code' => '11', 'description' => '¿Establece la actividad de Lecciones Aprendidas?'],
            ['catalog_id' => $question_twelve_form_two_id, 'code' => '12', 'description' => '¿Se contempla Evaluación (inicial y final) para el proyecto? (Proyectos de mas de 1 año)'],
            ['catalog_id' => $question_thirteen_form_two_id, 'code' => '13', 'description' => '¿Contempla un Plan de Comunicación (considerar la rendición de cuentas con actores claves) elaborado en conjunto con la Gerencia de Comunicación?'],
            ['catalog_id' => $question_fourteen_form_two_id, 'code' => '14', 'description' => '¿La formulación de la propuesta involucró a los actores según el esquema de trabajo?'],


            ['catalog_id' => $types_risks, 'code' => '1', 'description' => 'Fuentes Internas - Alcance'],
            ['catalog_id' => $types_risks, 'code' => '2', 'description' => 'Fuentes Internas - Tiempo'],
            ['catalog_id' => $types_risks, 'code' => '3', 'description' => 'Fuentes Internas - Presupuesto'],
            ['catalog_id' => $types_risks, 'code' => '4', 'description' => 'Fuentes Internas - Planificación'],
            ['catalog_id' => $types_risks, 'code' => '5', 'description' => 'Fuentes Internas - Tecnológicos'],
            ['catalog_id' => $types_risks, 'code' => '6', 'description' => 'Fuentes Internas - Operatividad'],
            ['catalog_id' => $types_risks, 'code' => '7', 'description' => 'Fuentes Internas - Logísticos'],
            ['catalog_id' => $types_risks, 'code' => '8', 'description' => 'Fuentes Internas - Talento humano'],
            ['catalog_id' => $types_risks, 'code' => '9', 'description' => 'Fuentes Externas - Localidad'],
            ['catalog_id' => $types_risks, 'code' => '10', 'description' => 'Fuentes Externas - Actores'],
            ['catalog_id' => $types_risks, 'code' => '11', 'description' => 'Fuentes Externas - Financiadores'],
            ['catalog_id' => $types_risks, 'code' => '12', 'description' => 'Fuentes Externas - Legal'],

            ['catalog_id' => $team_roles, 'code' => '1', 'description' => 'Coordinador de Proyecto'],
            ['catalog_id' => $team_roles, 'code' => '2', 'description' => 'Coordinador Local de Proyecto'],
            ['catalog_id' => $team_roles, 'code' => '3', 'description' => 'Técnico Especialista'],
            ['catalog_id' => $team_roles, 'code' => '4', 'description' => 'Técnico Administrativo'],
            ['catalog_id' => $team_roles, 'code' => '5', 'description' => 'Técnico Operativo'],
            ['catalog_id' => $team_roles, 'code' => '6', 'description' => 'Oficial de Presupuestos'],
            ['catalog_id' => $team_roles, 'code' => '7', 'description' => 'Oficial de Presupuestos Local'],
            ['catalog_id' => $team_roles, 'code' => '8', 'description' => 'Oficial de PMER'],
            ['catalog_id' => $team_roles, 'code' => '9', 'description' => 'Oficial de PMER Local'],

            ['catalog_id' => $help_messages, 'code' => 'localidad', 'description' => 'Seleccione la o las provincias, cantones o parroquias priorizadas para el proyecto.'],
            ['catalog_id' => $help_messages, 'code' => 'financiadores', 'description' => 'Seleccione el o los financiadores que contribuyen al proyecto. '],
            ['catalog_id' => $help_messages, 'code' => 'cooperantes', 'description' => 'Seleccione si el financiamiento es en cooperación con FICR, CICR u otra Sociedad Nacional. '],
            ['catalog_id' => $help_messages, 'code' => 'plazo', 'description' => 'Indique el plazo del proyecto expresado en meses.'],
            ['catalog_id' => $help_messages, 'code' => 'area_ejecutora', 'description' => 'Seleccione el área responsable de implementar el proyecto.'],
            ['catalog_id' => $help_messages, 'code' => 'equipo_proyecto', 'description' => 'Seleccione el personal asignado al proyecto y rol que desempeñará.'],
            ['catalog_id' => $help_messages, 'code' => 'identificacion_problema', 'description' => 'Describa el contexto y problema identificado, justifique la intervención planteada. Para ampliar la información añadir adjuntos.'],
            ['catalog_id' => $help_messages, 'code' => 'objetivo_general', 'description' => 'Describa el objetivo con un verbo en infinitivo, intervención planteada, alcance y la localidad a ser intervenida'],
            ['catalog_id' => $help_messages, 'code' => 'objetivo_especifico', 'description' => 'Describa los objetivos identificando el qué, cuánto, el dónde, cuándo y cómo.  Ej. Incrementar en un 20% el acceso a la salud a las poblaciones migrantes y comunidades de acogida mediante atenciones de salud y APS durante 9 meses en la provincia del Carchi'],
            ['catalog_id' => $help_messages, 'code' => 'resultados', 'description' => 'Describir los resultados en participio pasado, convirtiéndose en los productos/servicios de los objetivos específicos. Ej. La población migrante y de acogida tiene acceso a atenciones de salud de manera continua en la provincia del Carchi.'],
            ['catalog_id' => $help_messages, 'code' => 'servicios', 'description' => 'Selecciones los servicios / productos del catálogo desplegado, en caso de no encontrarlo en el catálogo desplegado ingrese un nuevo servicio / producto. '],
            ['catalog_id' => $help_messages, 'code' => 'articulaciones', 'description' => 'Seleccione los objetivos específicos del proyecto y articule con los objetivos del plan estratégico de CRE, plan de desarrollo del país, plan estratégico del movimiento de Cruz Roja y de desarrollo sostenible a los cuales se alinea y contribuye el proyecto.'],
            ['catalog_id' => $help_messages, 'code' => 'beneficiarios', 'description' => 'Describa y detalle la cantidad de beneficiarios directos e indirectos a alcanzar. '],
            ['catalog_id' => $help_messages, 'code' => 'cronograma', 'description' => 'Especifique el cronograma tentativo de implementación. '],
            ['catalog_id' => $help_messages, 'code' => 'marco_logico', 'description' => 'Para desarrollar el marco lógico por favor verificar, si las acciones planteadas son suficientes y factibles para cumplir los objetivos específicos y si los objetivos específicos están alineados al objetivo general del proyecto. '],
            ['catalog_id' => $help_messages, 'code' => 'actores_clave', 'description' => 'Identifique los principales actores clave para la implementación del proyecto.'],
            ['catalog_id' => $help_messages, 'code' => 'riesgos', 'description' => 'Describa los riesgos identificados para el proyecto hasta el momento y clasifique según el catálogo desplegado.'],
            ['catalog_id' => $help_messages, 'code' => 'documento_forumalado', 'description' => 'Añadir la versión final del proyecto formulado en formato PDF.'],
            ['catalog_id' => $help_messages, 'code' => 'presupuesto', 'description' => 'Detalle el presupuesto necesario por resultado esperado, incluir los costos de operación y costos indirectos. '],
            ['catalog_id' => $help_messages, 'code' => 'resumen', 'description' => 'En esta sección se presenta un resumen del proyecto formulado conforme la información ingresada en los acápites anteriores, para ajustes o modificaciones dirigirse a las pestañas respectivas según el campo a editar. '],
            ['catalog_id' => $help_messages, 'code' => 'revision', 'description' => 'Para remitir la propuesta de proyecto a revisión, verificar que las acciones planteadas estén técnicamente validadas, que tengan una alineación lógica para cumplir el objetivo general planteado y se exprese la necesidad presupuestaria. '],
            ['catalog_id' => $help_messages, 'code' => 'formulado', 'description' => 'Este proyecto se encuentra aprobado por las gerencias de áreas esenciales, planificación y financiera. El proyecto cumple con los parámetros necesarios para iniciar la búsqueda de financiamiento. '],
            ['catalog_id' => $help_messages, 'code' => 'financiado', 'description' => 'El proyecto cuenta con financiamiento, si continúa iniciará la fase de planificación y ejecución. Validar los documentos habilitantes: Convenio/acuerdo o aviso de aceptación del financiador, proyecto formulado y presupuesto.'],
        ];

        foreach ($catalog_detail_initial_data as $initial_datum) {
            CatalogDetail::create($initial_datum);
        }

    }
}