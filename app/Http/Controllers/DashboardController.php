<?php

namespace App\Http\Controllers;

use App\Models\Dapil;
use App\Models\Election;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Project;
use App\Models\TPS;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|numeric',
            'kabupaten_id' => 'nullable|numeric',
            'kecamatan_id' => 'nullable|numeric',
            'desa_id' => 'nullable|numeric',
        ]);

        $project_id = $request->project_id;
        $kabupaten_id = $request->kabupaten_id;
        $kecamatan_id = $request->kecamatan_id;
        $desa_id = $request->desa_id;
        $kabupaten_dapil= null;
        $kabupaten = null;
        $kecamatan = null;
        $kecamatan_detail = null;
        $desa = null;

        if ($project_id) {
            $kabupaten_dapil = Dapil::where('project_id', $project_id)->firstOrFail()->relasi_dapil;
        }

        if ($project_id && $kabupaten_id) {
            $elections = Election::whereRelation('tps.desa.kecamatan.kabupaten', 'id', '=', $kabupaten_id)
                ->whereRelation('tps.dapil.project', 'id', '=', $project_id)
                ->with(['tps.desa.kecamatan'])
                ->get();

            // Mapping manual agar kecamatan_name jadi property flat di awal
            $elections = $elections->map(function ($item) {
                $item->kecamatan_id = $item->tps->desa->kecamatan->id ?? null;
                $item->kecamatan_name = $item->tps->desa->kecamatan->name ?? '-';
                return $item;
            });

            // Group & Sum by kecamatan_id
            $kecamatan = $elections
                ->groupBy('kecamatan_id')
                ->map(function ($group, $kecamatan_id) {
                    $kecamatan_name = $group->first()->kecamatan_name;
                    $vote = $group->sum('vote');
                    $vote_party = $group->sum('vote_party');
                    return (object) [
                        'kecamatan_id' => $kecamatan_id,
                        'kecamatan_name' => $kecamatan_name,
                        'vote' => $vote,
                        'vote_party' => $vote_party,
                        'total' => $vote + $vote_party,
                    ];
                })
                ->sortByDesc('vote')
                ->values();

            $kabupaten = Kabupaten::findOrFail($kabupaten_id);
        }

        if ($project_id && $kabupaten_id && $kecamatan_id) {
            $elections = Election::whereRelation('tps.desa.kecamatan.kabupaten', 'id', '=', $kabupaten_id)
                ->whereRelation('tps.desa.kecamatan', 'id', '=', $kecamatan_id)
                ->whereRelation('tps.dapil.project', 'id', '=', $project_id)
                ->with(['tps.desa'])
                ->get();

            // Mapping manual agar kecamatan_name jadi property flat di awal
            $elections = $elections->map(function ($item) {
                $item->kecamatan_id = $item->tps->desa->kecamatan->id ?? null;
                $item->kecamatan_name = $item->tps->desa->kecamatan->name ?? '-';
                $item->desa_id = $item->tps->desa->id ?? null;
                $item->desa_name = $item->tps->desa->name ?? '-';
                return $item;
            });

            // Group & Sum by kecamatan_id
            $desa = $elections
                ->groupBy('desa_id')
                ->map(function ($group, $desa_id) {
                    $desa_name = $group->first()->desa_name;
                    $vote = $group->sum('vote');
                    $vote_party = $group->sum('vote_party');
                    return (object) [
                        'desa_id' => $desa_id,
                        'desa_name' => $desa_name,
                        'vote' => $vote,
                        'vote_party' => $vote_party,
                        'total' => $vote + $vote_party,
                    ];
                })
                ->sortByDesc('vote')
                ->values();

            $kecamatan_detail = Kecamatan::findOrFail($kecamatan_id);
        }

        $project = Project::all();

        return view('pages.dashboard', [
            'project' => $project,
            'project_id' => $project_id,
            'kabupaten' => $kabupaten,
            'kabupaten_id' => $kabupaten_id,
            'kabupaten_dapil' => $kabupaten_dapil,
            'kecamatan' => $kecamatan,
            'kecamatan_id' => $kecamatan_id,
            'kecamatan_detail' => $kecamatan_detail,
            'desa' => $desa,
            'desa_id' => $desa_id,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
