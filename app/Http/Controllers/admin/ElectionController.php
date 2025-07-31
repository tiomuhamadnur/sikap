<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ElectionDataTable;
use App\Exports\ElectionExport;
use App\Http\Controllers\Controller;
use App\Imports\ElectionImport;
use App\Models\Election;
use App\Models\TPS;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ElectionController extends Controller
{
    public function index(ElectionDataTable $dataTable)
    {
        $tps = TPS::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.election.index', compact([
            'tps',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tps_id' => 'numeric|required',
            'vote' => 'numeric|required',
            'vote_party' => 'numeric|required',
        ]);

        Election::updateOrCreate($data, $data);

        return redirect()->route('election.index')->withNotify('Data berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        $import = new ElectionImport;
        Excel::import($import, $request->file('file'));

        if (!empty($import->errors)) {
            $errorText = collect($import->errors)->map(function ($fail) {
                $row = 'Baris ' . $fail['row'];
                $messages = implode(', ', $fail['messages']);
                return $row . ': ' . $messages;
            })->implode('<br>'); // langsung pakai <br>
            return redirect()->route('election.index')->withNotifyerror($errorText);
        }

        return redirect()->route('election.index')->withNotify('Data berhasil diimpor.');
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new ElectionExport, 'data_hasil_pemilu.xlsx');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        $data = Election::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'tps_id' => 'numeric|required',
            'vote' => 'numeric|required',
            'vote_party' => 'numeric|required',
        ]);

        $data->update($rawData);
        return redirect()->route('election.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Election::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('election.index')->withNotify('Data berhasil dihapus');
    }
}
