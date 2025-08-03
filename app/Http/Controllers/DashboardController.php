<?php

namespace App\Http\Controllers;

use App\Models\Dapil;
use App\Models\Desa;
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

        $kabupaten_dapil = null;
        $kabupaten = null;
        $kecamatan = null;
        $kecamatan_detail = null;
        $desa = null;
        $desa_detail = null;
        $tps = null;

        $project = Project::all();

        if ($project_id) {
            $relasi_dapil = Dapil::where('project_id', $project_id)->firstOrFail()->relasi_dapil;

            $all_kabupaten = $relasi_dapil->mapWithKeys(function ($item) {
                return [
                    $item->kabupaten->id => (object) [
                        'kabupaten_id' => $item->kabupaten->id,
                        'kabupaten_name' => $item->kabupaten->name,
                        'kabupaten_type' => $item->kabupaten->type,
                        'vote' => 0,
                        'vote_party' => 0,
                        'total' => 0,
                    ],
                ];
            });

            // Ambil semua election yang berkaitan dengan project_id, filter nanti di Collection
            $elections = Election::whereRelation('tps.dapil.project', 'id', $project_id)
                ->with(['tps.desa.kecamatan.kabupaten'])
                ->get();

            // === Grouping Kabupaten ===
            $kabupaten_summary = $elections->groupBy(fn($item) => $item->tps->desa->kecamatan->kabupaten->id)->map(function ($group, $kabupaten_id) {
                $first = $group->first();
                $kabupaten = $first->tps->desa->kecamatan->kabupaten;
                $vote = $group->sum('vote');
                $vote_party = $group->sum('vote_party');
                return (object) [
                    'kabupaten_id' => $kabupaten_id,
                    'kabupaten_name' => $kabupaten->name,
                    'kabupaten_type' => $kabupaten->type,
                    'vote' => $vote,
                    'vote_party' => $vote_party,
                    'total' => $vote + $vote_party,
                ];
            });

            // Merge all_kabupaten (biar kabupaten kosong tetap muncul)
            $kabupaten_dapil = $all_kabupaten
                ->map(function ($item, $kabupaten_id) use ($kabupaten_summary) {
                    if ($kabupaten_summary->has($kabupaten_id)) {
                        $summary = $kabupaten_summary->get($kabupaten_id);
                        $item->vote = $summary->vote;
                        $item->vote_party = $summary->vote_party;
                        $item->total = $summary->total;
                    }

                    $item->vote = number_format($item->vote, 0, ',', '.');
                    $item->vote_party = number_format($item->vote_party, 0, ',', '.');
                    $item->total = number_format($item->total, 0, ',', '.');

                    return $item;
                })
                ->sortByDesc(fn($item) => (int) str_replace('.', '', $item->vote))
                ->values();

            // === Filter based on Kabupaten ID ===
            if ($kabupaten_id) {
                $kabupaten = Kabupaten::findOrFail($kabupaten_id);

                $filtered_elections = $elections->filter(function ($item) use ($kabupaten_id) {
                    return $item->tps->desa->kecamatan->kabupaten->id == $kabupaten_id;
                });

                // === Grouping Kecamatan ===
                $kecamatan = $filtered_elections
                    ->groupBy(fn($item) => $item->tps->desa->kecamatan->id)
                    ->map(function ($group, $kecamatan_id) {
                        $first = $group->first();
                        $kecamatan = $first->tps->desa->kecamatan;
                        $vote = $group->sum('vote');
                        $vote_party = $group->sum('vote_party');
                        return (object) [
                            'kecamatan_id' => $kecamatan_id,
                            'kecamatan_name' => $kecamatan->name,
                            'vote' => $vote,
                            'vote_party' => $vote_party,
                            'total' => $vote + $vote_party,
                        ];
                    })
                    ->sortByDesc('vote')
                    ->values();

                if ($kecamatan_id) {
                    $kecamatan_detail = Kecamatan::findOrFail($kecamatan_id);

                    $filtered_elections = $filtered_elections->filter(function ($item) use ($kecamatan_id) {
                        return $item->tps->desa->kecamatan->id == $kecamatan_id;
                    });

                    // === Grouping Desa ===
                    $desa = $filtered_elections
                        ->groupBy(fn($item) => $item->tps->desa->id)
                        ->map(function ($group, $desa_id) {
                            $first = $group->first();
                            $desa = $first->tps->desa;
                            $vote = $group->sum('vote');
                            $vote_party = $group->sum('vote_party');
                            return (object) [
                                'desa_id' => $desa_id,
                                'desa_name' => $desa->name,
                                'vote' => $vote,
                                'vote_party' => $vote_party,
                                'total' => $vote + $vote_party,
                            ];
                        })
                        ->sortByDesc('vote')
                        ->values();

                    if ($desa_id) {
                        $desa_detail = Desa::findOrFail($desa_id);

                        $filtered_elections = $filtered_elections->filter(function ($item) use ($desa_id) {
                            return $item->tps->desa->id == $desa_id;
                        });

                        // === Grouping TPS ===
                        $tps = $filtered_elections
                            ->groupBy(fn($item) => $item->tps->id)
                            ->map(function ($group, $tps_id) {
                                $first = $group->first();
                                $tps = $first->tps;
                                $vote = $group->sum('vote');
                                $vote_party = $group->sum('vote_party');
                                return (object) [
                                    'tps_id' => $tps_id,
                                    'tps_name' => $tps->name,
                                    'vote' => $vote,
                                    'vote_party' => $vote_party,
                                    'total' => $vote + $vote_party,
                                ];
                            })
                            ->sortByDesc('vote')
                            ->values();
                    }
                }
            }
        }

        return view('pages.dashboard', compact('project', 'project_id', 'kabupaten', 'kabupaten_id', 'kabupaten_dapil', 'kecamatan', 'kecamatan_id', 'kecamatan_detail', 'desa', 'desa_id', 'desa_detail', 'tps'));
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
