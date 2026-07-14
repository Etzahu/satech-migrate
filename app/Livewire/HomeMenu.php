<?php

namespace App\Livewire;


use Livewire\Component;


class HomeMenu extends Component
{

    public $menu = [];

    public function render()
    {
        $this->menu = [
            ['area' => 'Servicios Generales', 'desc' => 'Solicitudes y soporte de servicios generales.', 'icon' => 'wrench',  'link' => 'https://it.satechenergy.com'],
            ['area' => 'TI',                  'desc' => 'Soporte técnico, equipos y sistemas.',           'icon' => 'desktop', 'link' => 'https://ti.gptsatech.com'],
            ['area' => 'RRHH',                'desc' => 'Gestión de personal.',      'icon' => 'users',   'link' => 'https://rrhh.satechenergy.com'],
            ['area' => 'Compras',             'desc' => 'Requisiciones y órdenes de compra.',             'icon' => 'cart',    'link' => 'https://app.gptsatech.com/compras'],
            ['area' => 'QHSE',                'desc' => 'Calidad, seguridad y medio ambiente.',           'icon' => 'shield',  'link' => 'https://qhse.gptsatech.com'],
            ['area' => 'Proyectos',           'desc' => 'Reportes y avance de proyectos.',                'icon' => 'chart',   'link' => 'https://reportesgpt.satechenergy.com'],
            ['area' => 'Evaluación de competencia', 'desc' => 'Evaluaciones y competencias del personal.', 'icon' => 'cap',    'link' => 'https://ec.satechenergy.com'],
        ];

        return view('livewire.home-menu');
    }
}
