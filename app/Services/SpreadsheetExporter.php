<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use OpenSpout\Writer\Common\AbstractOptions;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class SpreadsheetExporter
{
    /**
     * FastExcel que arma el archivo en una carpeta temporal dentro de storage.
     *
     * Sin esto OpenSpout usa la carpeta temporal del sistema, que no siempre
     * es escribible para PHP (en Laragon resuelve a C:\Windows\Temp) y la
     * descarga falla con "... is not a writable folder".
     *
     * @param  SheetCollection|iterable<int|string, mixed>  $data
     */
    public static function make(SheetCollection|iterable $data): FastExcel
    {
        $tempFolder = storage_path('app/temp');

        File::ensureDirectoryExists($tempFolder);

        return fastexcel($data)->configureOptionsUsing(
            fn (AbstractOptions $options) => $options->setTempFolder($tempFolder)
        );
    }
}
