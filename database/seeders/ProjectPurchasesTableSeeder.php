<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_purchases')->delete();
        
        \DB::table('project_purchases')->insert(array (
            0 => 
            array (
                'id' => 2,
                'code' => 'NP-006/24',
                'name' => 'NP-006/24-Mantenimiento Mensual Junio 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            1 => 
            array (
                'id' => 3,
                'code' => 'NP-031/24',
                'name' => 'NP-031/24-Servicio de Maquinado en Válvula 6"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            2 => 
            array (
                'id' => 4,
                'code' => 'NP-038/24',
            'name' => 'NP-038/24-HTF Weldolet + brida 24" x 8" 300# RF (2 PZA)',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            3 => 
            array (
                'id' => 5,
                'code' => 'NP-047/24',
                'name' => 'NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            4 => 
            array (
                'id' => 6,
                'code' => 'NP-048/24',
                'name' => 'NP-048/24-Adicionales-DLS 24" con By Pass ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            5 => 
            array (
                'id' => 7,
                'code' => 'NP-040/24',
                'name' => 'NP-040/24-Adicionales MAQUIALSA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            6 => 
            array (
                'id' => 8,
                'code' => 'NP-039/24',
                'name' => 'NP-039/24-Adicionales EIGSA-DN 078/24',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            7 => 
            array (
                'id' => 9,
                'code' => 'NP-035/24',
                'name' => 'NP-035/24-Herramienta-Área de Manufactura',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            8 => 
            array (
                'id' => 10,
                'code' => 'NP-034/24',
                'name' => 'NP-034/24-Herramienta-Área de Calidad',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            9 => 
            array (
                'id' => 11,
                'code' => 'NP-011/24',
                'name' => 'NP-011/24-Mantenimiento Mensual Noviembre 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            10 => 
            array (
                'id' => 12,
                'code' => 'NP-033/24',
                'name' => 'NP-033/24-Equipo para pruebas TM-416',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            11 => 
            array (
                'id' => 13,
                'code' => 'NP-041/24',
                'name' => 'NP-041/24-Servicio a Banco de Pruebas 24"-PEMEX LOG',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            12 => 
            array (
                'id' => 14,
                'code' => 'NP-042/24',
                'name' => 'NP-042/24-Renta de VS 30 600 WELDFIT',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            13 => 
            array (
                'id' => 15,
                'code' => 'NP-007/23',
                'name' => 'Mantenimiento a válvulas 36" 600# - Cliente PEMEX',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            14 => 
            array (
                'id' => 16,
                'code' => 'NP-043/24',
                'name' => 'NP-043/24-HTF 8" x 8" 600# RTJ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            15 => 
            array (
                'id' => 17,
                'code' => 'NP-044/24',
                'name' => 'NP-044/24-Equipo oficinas ingeniería',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            16 => 
            array (
                'id' => 18,
                'code' => 'NP-029/2022',
                'name' => 'NP-029/2022 – Fabricación de TM-101',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            17 => 
            array (
                'id' => 19,
                'code' => 'NP-042/2023',
                'name' => 'NP-042/2023 – Fabricación equipo - FRISA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            18 => 
            array (
                'id' => 20,
                'code' => 'NP-047/2023',
                'name' => 'NP-047/2023 – Fabricación de TM 416/1500',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            19 => 
            array (
                'id' => 21,
                'code' => 'NP-037/2023',
                'name' => 'NP-037/2023 - Fabricación de  unidad de poder John Deere',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            20 => 
            array (
                'id' => 22,
                'code' => 'STCKALM',
                'name' => 'NP-Stock Almacén ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            21 => 
            array (
                'id' => 23,
                'code' => 'NP-010/24',
                'name' => 'NP-010/24-Mantenimiento Mensual Octubre 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            22 => 
            array (
                'id' => 24,
                'code' => 'NP-008/24',
                'name' => 'NP-008/24-Mantenimiento Mensual Agosto 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            23 => 
            array (
                'id' => 25,
                'code' => 'NP-045/24',
                'name' => 'NP-045/24-Modificación de Accesorio 16" X 16" 600#- COMURSA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            24 => 
            array (
                'id' => 26,
                'code' => 'NP-GPT-COT-GPT',
                'name' => 'COTIZACIONES INGENIERIA Y MANUFACTURA ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            25 => 
            array (
                'id' => 27,
                'code' => 'NP-046/24',
                'name' => 'NP-046/24-Adicionales LS 36" con bypass de 24"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            26 => 
            array (
                'id' => 28,
                'code' => 'NP-014/24',
                'name' => 'NP-014/24 - Fabricación de Solapas 36x16" y 48x16" - Monoboyas DIAVAZ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            27 => 
            array (
                'id' => 29,
                'code' => 'NP-015/24',
                'name' => 'NP-015/24 Servicio de Obturación 24"600# RF - DLS Mendoza',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            28 => 
            array (
                'id' => 30,
                'code' => 'NP-016/24',
                'name' => 'NP-016/24 Fabricación de Paddle Blanks 12" 300#',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            29 => 
            array (
                'id' => 31,
                'code' => 'NP-001/24',
                'name' => 'NP-001/24 Mantenimiento Mensual Enero 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            30 => 
            array (
                'id' => 32,
                'code' => 'NP-017/24',
                'name' => 'NP-017/24-Mantenimiento anual de maquinaría ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            31 => 
            array (
                'id' => 33,
                'code' => 'NP-002/24',
                'name' => 'NP-002/24-Mantenimiento Mensual Febrero 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            32 => 
            array (
                'id' => 34,
                'code' => 'NP-013/24-PNDs 2024',
                'name' => 'NP-013/24-PNDs 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            33 => 
            array (
                'id' => 35,
                'code' => 'NP-019/24',
                'name' => 'NP-019/24-Fabricación de Broca y Plato Adaptador-1500#',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            34 => 
            array (
                'id' => 36,
                'code' => 'NP-020/24',
                'name' => 'NP-020/24-Fabricación Cabeza Obturadora 22"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            35 => 
            array (
                'id' => 37,
                'code' => 'NP-003/24-MATTO Marzo 2024',
                'name' => 'NP-003/24-Mantenimiento Mensual Marzo 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            36 => 
            array (
                'id' => 38,
                'code' => 'NP-021/24',
                'name' => 'NP-021/24-Modificación de bridas a LSF 16" X 16"  -Ixachi',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            37 => 
            array (
                'id' => 39,
                'code' => 'NP-004/24',
                'name' => 'NP-004/24-Mantenimiento Mensual Abril 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            38 => 
            array (
                'id' => 40,
                'code' => 'NP-027/24',
                'name' => 'NP-027/24-Desarrollo de nuevas tecnología TM-TIPO COSASCO',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            39 => 
            array (
                'id' => 41,
                'code' => 'NP-026/24',
                'name' => 'NP-026/24-Desarrollo de nuevas tecnologías-TM-1248 L',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            40 => 
            array (
                'id' => 42,
                'code' => 'NP-023/24 Fabricación Brocas ',
                'name' => 'NP-023/24 Fabricación ATM 8", Brocas 900#- GCI',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            41 => 
            array (
                'id' => 43,
                'code' => 'NP-022/24 Fab Weldolets',
                'name' => 'NP-022/24 Fabricación Weldolets 48"x 4" y 36"x4" 300# RF-Monoboyas - DIAVAZ //CANCELADO',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            42 => 
            array (
                'id' => 44,
                'code' => 'NP-025/24',
                'name' => 'NP-025/24-Desarrollo de nuevas tecnologías-Brocas',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            43 => 
            array (
                'id' => 45,
                'code' => 'NP-024/24',
                'name' => 'NP-024/24-Desarrollo de nuevas tecnologías-Cortadores',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            44 => 
            array (
                'id' => 46,
                'code' => 'NP-065/23 ',
                'name' => 'NP-065/23 Fabricación de válvula sándwich de 24" y 36"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            45 => 
            array (
                'id' => 47,
                'code' => 'NP-005/24-MATTO MAYO 2024',
                'name' => 'NP-005/24-Mantenimiento Mensual Mayo 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            46 => 
            array (
                'id' => 48,
                'code' => 'NP-028/24',
            'name' => 'NP-028/24-HTF 48" X 6" 600# RF (Weldolet + Brida)',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            47 => 
            array (
                'id' => 49,
                'code' => 'NP-031/22',
                'name' => 'NP-031/22-Fabricacion de Maquina Afiladora de Cortadores',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            48 => 
            array (
                'id' => 50,
                'code' => 'NP-030/24',
                'name' => 'NP-030/24-Desarrollo de nuevas tecnologías TM-101 Alta Presión.',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            49 => 
            array (
                'id' => 51,
                'code' => 'NP-029/24',
                'name' => 'NP-029/24-Accesorios para máquina Metal Samples',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            50 => 
            array (
                'id' => 52,
                'code' => 'NP-007/24',
                'name' => 'NP-007/24-Mantenimiento Mensual Julio 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            51 => 
            array (
                'id' => 53,
                'code' => 'NP-032/24',
                'name' => 'NP-032/24-Fabricación para stock de Injertos-6"y 8"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            52 => 
            array (
                'id' => 54,
                'code' => 'NP-049/24',
                'name' => 'NP-049/24-Fabricación Broca Especial-LSF 24"',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            53 => 
            array (
                'id' => 55,
                'code' => 'NP-012/24',
                'name' => 'NP-012/24-Mantenimiento Mensual Diciembre 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            54 => 
            array (
                'id' => 56,
                'code' => 'NP-009/24',
                'name' => 'NP-009/24-Mantenimiento Mensual Septiembre 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            55 => 
            array (
                'id' => 57,
                'code' => 'NP-050/24',
                'name' => 'NP-050/24-Estudio Transferencia de Calor en Línea de 24"-DN-083/24',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            56 => 
            array (
                'id' => 58,
                'code' => 'NP-052/24',
                'name' => 'NP-052/24-Fabricación de Brocas para TM-101',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            57 => 
            array (
                'id' => 59,
                'code' => 'NP-036/24',
            'name' => 'NP-036/24-HTF 48" X 6" 600# RF( Weldolet + Niple + Brida)',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            58 => 
            array (
                'id' => 60,
                'code' => 'NP-051/24',
                'name' => 'NP-051/24-Estudio Transferencia de Calor en Línea de 48"-DN-083/24_x000D_
',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            59 => 
            array (
                'id' => 61,
                'code' => 'NP-053/24',
                'name' => 'NP-053/24-2°Modificación de Accesorio 16" X 16" 600#- COMURSA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            60 => 
            array (
                'id' => 62,
                'code' => 'NP-037/24',
                'name' => 'NP-037/24-HT TEE 36\'\' X 30\'\' 900# RTJ',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2025-01-08 17:22:59',
                'updated_at' => '2025-01-08 17:22:59',
            ),
            61 => 
            array (
                'id' => 63,
                'code' => 'PGRM ANL CALIB',
                'name' => 'DN-Programa Anual de Calibración ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            62 => 
            array (
                'id' => 64,
                'code' => 'Software ',
                'name' => 'Software TECH ENERGY',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            63 => 
            array (
                'id' => 65,
                'code' => 'DN-081/24',
                'name' => 'DN-081/24 PTI: OS18',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            64 => 
            array (
                'id' => 66,
                'code' => 'Consumibles IT',
                'name' => 'Consumibles IT',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            65 => 
            array (
                'id' => 67,
                'code' => 'DN-064/24',
                'name' => 'DN-064/24 PTI OS15',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            66 => 
            array (
                'id' => 68,
                'code' => 'DN-097/24 ',
                'name' => 'DN-097/24 IGMX: HT 24x4',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            67 => 
            array (
                'id' => 69,
                'code' => 'DN-099/24 ',
                'name' => 'DN-099/24 SRS: Reactor',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            68 => 
            array (
                'id' => 70,
                'code' => 'DN-103/24',
                'name' => 'DN-103/24 PTI: Válvulas TMDB OS20',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            69 => 
            array (
                'id' => 71,
                'code' => 'Calibración 2024',
                'name' => 'NP-Programa anual de calibración ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            70 => 
            array (
                'id' => 72,
                'code' => 'DN-078/24',
                'name' => 'DN-078/24 EGS: HTP 24in y 14in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            71 => 
            array (
                'id' => 73,
                'code' => 'DN-079/24',
                'name' => 'DN-079/24 INV: VC 8in 900#',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            72 => 
            array (
                'id' => 74,
                'code' => 'DN-079/23 ',
                'name' => 'DN-079/23 PJP4: HT 2in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            73 => 
            array (
                'id' => 75,
                'code' => 'DN-101/24',
                'name' => 'DN-101/24 WF: EQR VS 30in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            74 => 
            array (
                'id' => 76,
                'code' => 'DN-001/24',
                'name' => 'DN-001/24 Diavaz Monoboyas F1',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            75 => 
            array (
                'id' => 77,
                'code' => 'MTTOMTACARGS',
                'name' => 'Mantenimiento a Montacargas',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            76 => 
            array (
                'id' => 78,
                'code' => 'DN-080/24',
                'name' => 'DN-080/24 PJP4: Abrazaderas 18in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            77 => 
            array (
                'id' => 79,
                'code' => 'DN 105/24',
                'name' => 'DN 105/24 - EM Ramones – Accesorio',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            78 => 
            array (
                'id' => 80,
                'code' => 'STCK ALM',
                'name' => 'DN-Stock Almacén ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            79 => 
            array (
                'id' => 81,
                'code' => 'ACTFIJO',
                'name' => 'Activo Fijo',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            80 => 
            array (
                'id' => 82,
                'code' => 'DN-108/24 ',
                'name' => 'DN-108/24 IGMX: Prime Park HTP 24x4',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            81 => 
            array (
                'id' => 83,
                'code' => 'DN-107/24',
                'name' => 'DN-107/24 FJN: Drillings 10x2',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            82 => 
            array (
                'id' => 84,
                'code' => 'DN-095/23',
                'name' => 'DN-095/23 Patines',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            83 => 
            array (
                'id' => 85,
                'code' => 'DN-066/24 ',
                'name' => 'DN-066/24 IGMX: Inst. Pups VBT 6" 300#',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            84 => 
            array (
                'id' => 86,
                'code' => 'DN-083/24 ',
                'name' => 'DN-083/24 DVZ: ETC',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            85 => 
            array (
                'id' => 87,
                'code' => 'PROGCALIFANUALSOLDRS',
                'name' => 'Programa de calificación anual de soldadores //Calif sold, emisión docmtos: WPS, PQR, WPQR, por CWI',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            86 => 
            array (
                'id' => 88,
                'code' => 'DN-053/24 ',
                'name' => 'DN-053/24 Suministro Valvulas OS 13',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            87 => 
            array (
                'id' => 89,
                'code' => 'DN-055/24',
                'name' => 'DN-055/24 Sicim: Válvulas Sealweld VSA',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            88 => 
            array (
                'id' => 90,
                'code' => 'DN-028/23 ',
                'name' => 'DN-028/23 FRS: DDLS 22in-24in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            89 => 
            array (
                'id' => 91,
                'code' => 'DN-019/23',
                'name' => 'DN-019/23 Naturgy: Cierres y anillos',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            90 => 
            array (
                'id' => 92,
                'code' => 'AUDTRIAS',
                'name' => 'Auditorias',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            91 => 
            array (
                'id' => 93,
                'code' => 'DN-067/24',
                'name' => 'DN-067/24 MYS: Trampas 8in y 20in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            92 => 
            array (
                'id' => 94,
                'code' => 'DN-014/23',
                'name' => 'DN-014/23 MP: Patines',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            93 => 
            array (
                'id' => 95,
                'code' => 'DN-060/24',
                'name' => 'DN-060/24 Igmx: HTP 1in Baños',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            94 => 
            array (
                'id' => 96,
                'code' => 'DN-031/24 ',
                'name' => 'DN-031/24 GAES: Válvulas 1er. Lote Salamanca',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            95 => 
            array (
                'id' => 97,
                'code' => 'DN-030/24',
                'name' => 'DN-030/24 TC Energy: VBT 8" 600# SuKarne',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            96 => 
            array (
                'id' => 98,
                'code' => 'DN-070/24',
                'name' => 'DN-070/24 IGMX: PH VC 4in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            97 => 
            array (
                'id' => 99,
                'code' => 'DN-084/24',
                'name' => 'DN-084/24 WF: VS 30in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            98 => 
            array (
                'id' => 100,
                'code' => 'EPP',
                'name' => 'Equipo de Protección Personal ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            99 => 
            array (
                'id' => 101,
                'code' => 'DN-071/24',
                'name' => 'DN-071/24 PTI: OS16',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            100 => 
            array (
                'id' => 102,
                'code' => 'UNFMVTAS',
                'name' => 'Uniformes',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            101 => 
            array (
                'id' => 103,
                'code' => 'DN-088/24 ',
                'name' => 'DN-088/24 CSMS: HT 16in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            102 => 
            array (
                'id' => 104,
                'code' => 'DN-089/24',
                'name' => 'DN-089/24 MYS: HT 16in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            103 => 
            array (
                'id' => 105,
                'code' => 'DN-090/24 ',
                'name' => 'DN-090/24 MYS: HT 6X3',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            104 => 
            array (
                'id' => 106,
                'code' => 'DN-059/24',
                'name' => 'DN-059/24 Inova VC 6”',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            105 => 
            array (
                'id' => 107,
                'code' => 'DN-099/23',
                'name' => 'DN-099/23 Andrey DLS Omitlán ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            106 => 
            array (
                'id' => 108,
                'code' => 'DN-003/24 ',
                'name' => 'DN-003/24 Diavaz Monoboyas F2',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            107 => 
            array (
                'id' => 109,
                'code' => 'DN- 072/24',
                'name' => 'DN- 072/24 Mys: Trampas',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            108 => 
            array (
                'id' => 110,
                'code' => 'DN-091/24',
                'name' => 'DN-091/24 INV: Tubería 20in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            109 => 
            array (
                'id' => 111,
                'code' => 'DN-092/24',
                'name' => 'DN-092/24 PMX: DLS 24in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            110 => 
            array (
                'id' => 112,
                'code' => 'DN-086/24',
                'name' => 'DN-086/24 GAES: Actuadores REX',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            111 => 
            array (
                'id' => 113,
                'code' => 'DN-098/23',
                'name' => 'DN-098/23 -Suministro de Válvulas Varias',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            112 => 
            array (
                'id' => 114,
                'code' => 'DN-097/23',
                'name' => 'DN-097/23-Suministro de Válvulas Compuerta',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            113 => 
            array (
                'id' => 115,
                'code' => 'DN-012/24',
                'name' => 'DN-012/24 Diavaz soldadura Línea Viva 6x6 1500#',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            114 => 
            array (
                'id' => 116,
                'code' => 'DN-003/24',
                'name' => 'DN-003/24  -  Diavaz Monoboyas F3 ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            115 => 
            array (
                'id' => 117,
                'code' => 'DN-038/22',
                'name' => 'DN-038/22 Engie TGNH',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            116 => 
            array (
                'id' => 118,
                'code' => 'DN-094/23',
                'name' => 'DN-094/23 GAES LS 16” OMA MTY',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            117 => 
            array (
                'id' => 119,
                'code' => 'DN-010/24 ',
                'name' => 'DN-010/24 Mayurse HTP 16x16 Olmeca',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            118 => 
            array (
                'id' => 120,
                'code' => 'DN-017/24 ',
                'name' => 'DN-017/24 Sarreal HTP 16x16  Ixachi',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            119 => 
            array (
                'id' => 121,
                'code' => 'DN-021/23 ',
                'name' => 'DN-021/23 Sicim Válvulas y actuadores TMDB',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            120 => 
            array (
                'id' => 122,
                'code' => 'DN-075/24',
                'name' => 'DN-075/24 TCE: Heaters',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            121 => 
            array (
                'id' => 123,
                'code' => 'DN-034/24',
                'name' => 'DN-034/24 GAES: HT 48x6 Chinameca',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            122 => 
            array (
                'id' => 124,
                'code' => 'Matto Instalaciones ',
                'name' => 'Mantenimiento a Instalaciones ',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            123 => 
            array (
                'id' => 125,
                'code' => 'DN-076/24',
                'name' => 'DN-076/24 MYS: Trampas 20"',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            124 => 
            array (
                'id' => 126,
                'code' => 'DN-077/24',
                'name' => 'DN-077/24 PTI: VC TMDB',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            125 => 
            array (
                'id' => 127,
                'code' => 'DN -094/24',
                'name' => 'DN -094/24 PTI: OS19 Válvulas',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            126 => 
            array (
                'id' => 128,
                'code' => 'DN-058/24 ',
                'name' => 'DN-058/24 Mys: Trampas 12x8',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            127 => 
            array (
                'id' => 129,
                'code' => 'DN-106/24 ',
                'name' => 'DN-106/24 AMI: Tubería EM Los Ramones',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            128 => 
            array (
                'id' => 130,
                'code' => 'DN-110/24 ',
                'name' => 'DN-110/24 MQSA: HT varios diámetros',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            129 => 
            array (
                'id' => 131,
                'code' => 'DN-111/24',
                'name' => 'DN-111/24 IGMX: PUPS VBT 6” 300#',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            130 => 
            array (
                'id' => 132,
                'code' => 'DN-040/24',
                'name' => 'DN-040/24 Igmx: HTP 6x6 Baños',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            131 => 
            array (
                'id' => 133,
                'code' => 'MTTO-FLOTILLA',
                'name' => 'Mantenimiento a Flotilla GPT',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            132 => 
            array (
                'id' => 134,
                'code' => 'DN-065/24',
                'name' => 'DN-065/24 INV: VC 8in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            133 => 
            array (
                'id' => 135,
                'code' => 'DN-096/24',
                'name' => 'DN-096/24 CMS: HT 36x16',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            134 => 
            array (
                'id' => 136,
                'code' => 'DN-061/24 ',
                'name' => 'DN-061/24 PTI: OS14 Válvulas Manuales',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            135 => 
            array (
                'id' => 137,
                'code' => 'DN-040/23 ',
                'name' => 'DN-040/23 CNG: TLX',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            136 => 
            array (
                'id' => 138,
                'code' => 'DN-095/24 ',
                'name' => 'DN-095/24 DVZ: Estudio Transferencia de Calor 48in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            137 => 
            array (
                'id' => 139,
                'code' => 'MAMPTRANSL',
                'name' => 'Mampara Translúcida',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            138 => 
            array (
                'id' => 140,
                'code' => 'DN-047/24',
                'name' => 'DN-047/24 NTG: DLS 22- ReCap',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
            139 => 
            array (
                'id' => 141,
                'code' => 'DN-100/24 ',
                'name' => 'DN-100/24 IGMX: PH VC 6in',
                'status' => 1,
                'company_id' => 2,
                'created_at' => '2025-01-08 17:23:08',
                'updated_at' => '2025-01-08 17:23:08',
            ),
        ));
        
        
    }
}