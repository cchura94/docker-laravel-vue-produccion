<?php

namespace App\Exports;

use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ProductoExport implements FromView /*FromCollection*/ 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Producto::all();
    // }

    public function view(): View
    {
        return view('exports.productos', [
            'productos' => Producto::all()
        ]);
    }
}
