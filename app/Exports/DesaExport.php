<?php

namespace App\Exports;

use App\Models\Desa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DesaExport implements FromView
{
    public function view(): View
    {
        return view('pages.admin.desa.excel', [
            'desa' => Desa::with(['kecamatan', 'kecamatan.kabupaten', 'kecamatan.kabupaten.provinsi'])->get()
        ]);
    }
}
