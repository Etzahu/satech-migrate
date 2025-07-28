<?php

namespace App\Livewire;


use Livewire\Component;


class HomeMenu extends Component
{

    public $menu = [];

    public function render()
    {
        $this->menu = [
            ['area' => 'Servicios Generales', 'link' => 'https://it.satechenergy.com'],
            ['area' => 'TI', 'link' => 'https://it.satechenergy.com'],
            ['area' => 'RRHH', 'link' => 'https://rrhh.satechenergy.com'],
            ['area' => 'Compras',  'link' => 'https://app.gptsatech.com/compras'],
            ['area' => 'QHSE',  'link' => 'https://qhse.gptsatech.com'],
            ['area' => 'Proyectos',  'link' => 'https://reportesgpt.satechenergy.com'],
        ];
        return view('livewire.home-menu')
            ->with('munu', $this->menu);
    }
}
