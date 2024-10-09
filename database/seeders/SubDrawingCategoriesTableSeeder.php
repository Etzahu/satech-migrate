<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubDrawingCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_drawing_categories')->delete();
        
        \DB::table('sub_drawing_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'FES 1',
                'code' => '100',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'FES 2',
                'code' => '200',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'HT SIN BRIDA',
                'code' => '300',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'HT CON BRIDA',
                'code' => '400',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'HT 3WT ESF',
                'code' => '500',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'HT 3WT RECTA',
                'code' => '600',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'DOUBLE HUB',
                'code' => '700',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'PLANOS ESPECIALES',
                'code' => '800',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'WOL+BRIDA',
                'code' => '900',
                'drawing_category_id' => 1,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'BY PASS CON SILLETAS',
                'code' => '110',
                'drawing_category_id' => 2,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'BY PASS POR HOUSING',
                'code' => '210',
                'drawing_category_id' => 2,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'SENCILLO',
                'code' => '410',
                'drawing_category_id' => 2,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'TWT ESFERICA',
                'code' => '310',
                'drawing_category_id' => 2,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'TWT RECTA',
                'code' => '510',
                'drawing_category_id' => 2,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'MAPEO DE FITTING',
                'code' => '130',
                'drawing_category_id' => 4,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'MAPEO DE ALCANCE',
                'code' => '230',
                'drawing_category_id' => 4,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'AS BUILT',
                'code' => '330',
                'drawing_category_id' => 4,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'SOLDADURA DE DT Y CENTRADOR',
                'code' => '430',
                'drawing_category_id' => 4,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'MAPEO DE UNIONES BRIDADAS',
                'code' => '530',
                'drawing_category_id' => 4,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'UNIDADES DE PODER',
                'code' => '040',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'TMS',
                'code' => '140',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'VALVULAS',
                'code' => '240',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'HOUSING',
                'code' => '340',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'ADAPTADOR',
                'code' => '440',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'SPOOL',
                'code' => '540',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'CABEZAS OBTURADORAS',
                'code' => '640',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'CILINDROS OBTURADORES',
                'code' => '740',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'CORTADORES',
                'code' => '840',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'SOSTENEDORES, BROCAS, CENTRADORES Y DTs',
                'code' => '940',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'SHORTSTOPP',
                'code' => '1040',
                'drawing_category_id' => 5,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'CARRETES',
                'code' => '150',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'MODIFICACION A ACCESORIOS',
                'code' => '250',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'BANCOS DE PRUEBAS',
                'code' => '350',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'ESTRUCTURA ESPECIALES',
                'code' => '450',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'EQUIPOS MANUFACTURA',
                'code' => '550',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'ACCESORIOS',
                'code' => '650',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'PLANOS PARA COTIZACIÓN E INFORMACIÓN',
                'code' => '750',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'TRABAJOS A MANUFACTURAR',
                'code' => '850',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'SELLOS Y CIERRES',
                'code' => '950',
                'drawing_category_id' => 6,
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'MAPEO DE DRILLING',
                'code' => '120',
                'drawing_category_id' => 3,
                'created_at' => '2024-10-05 21:25:21',
                'updated_at' => '2024-10-05 21:25:21',
            ),
        ));
        
        
    }
}