<?php

namespace App\Exports;

use App\Models\Election;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ElectionExport implements FromView
{
    public function view(): View
    {
        return view('pages.user.election.excel', [
            'election' => Election::with([
                'tps',
                'tps.desa',
                'tps.desa.kecamatan',
                'tps.desa.kecamatan.kabupaten',
                'tps.desa.kecamatan.kabupaten.provinsi',
                'tps.dapil',
                'tps.dapil.project',
                'tps.dapil.project.profile',
                'tps.dapil.project.periode',
                'tps.dapil.project.election_type',
                'tps.dapil.project.party',
            ])->get()
        ]);
    }
}
