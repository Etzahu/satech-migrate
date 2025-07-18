<?php

namespace App\Livewire;


use Livewire\Component;


class HomeMenu extends Component
{

    public $menu = [];

    public function render()
    {
        $this->menu = [
            ['area' => 'Servicios Generales', 'modulo' => 'Mantenimiento a la Infrestructura', 'link' => 'https://it.satechenergy.com/mantenimiento/mis-tickets'],
            ['area' => 'TI', 'modulo' => 'Requisición tecnologias de la información', 'link' => 'https://it.satechenergy.com/mis-tickets'],
            ['area' => 'TI', 'modulo' => 'Sitio web corporativo', 'link' => 'gptservices.com'],
            ['area' => 'TI', 'modulo' => 'Calendario de cumpleaños', 'link' => 'gptservices.com/birthday/home'],
            ['area' => 'RRHH', 'modulo' => 'Evaluación de competencias', 'link' => 'https://ec.satechenergy.com'],
            ['area' => 'RRHH', 'modulo' => 'Actualización de datos personales', 'link' => 'https://rrhh.satechenergy.com/perfil/informacion-personal'],
            ['area' => 'RRHH', 'modulo' => 'Solicitud de capacitación', 'link' => 'https://rrhh.satechenergy.com/requisiciones-curso'],
            ['area' => 'RRHH', 'modulo' => 'Solicitud de personal', 'link' => 'https://rrhh.satechenergy.com/perfil/requisiciones-personal'],
            ['area' => 'Compras', 'modulo' => 'Requisición de compra', 'link' => 'https://app.gptsatech.com/compras'],
            ['area' => 'Compras', 'modulo' => 'Órdenes de compra', 'link' => 'https://app.gptsatech.com/compras'],
            ['area' => 'QHSE', 'modulo' => 'Creación o actualización de información documentada', 'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSf9D9SJddgqg0VPv8IREK6Eb94OULdp12X9Mvfmk5Ivp4Ozng/viewform'],
            ['area' => 'QHSE', 'modulo' => 'Gestión de KPIs', 'link' => 'https://it.satechenergy.com/kpis'],

        ];
        return view('livewire.home-menu')
            ->with('munu', $this->menu);
    }
}
