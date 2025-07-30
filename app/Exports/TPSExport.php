<?php

namespace App\Exports;

use App\Models\TPS;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TPSExport implements FromView
{
    public function view(): View
    {
        return view('pages.user.tps.excel', [
            'tps' => TPS::with([
                'desa',
                'desa.kecamatan',
                'desa.kecamatan.kabupaten',
                'desa.kecamatan.kabupaten.provinsi',
                'dapil',
                'dapil.project',
                'dapil.project.profile',
                'dapil.project.periode',
                'dapil.project.election_type',
            ])->get()
        ]);
    }
}
