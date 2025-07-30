<?php

namespace App\Http\Controllers\admin;

use App\DataTables\TPSDataTable;
use App\Exports\TPSExport;
use App\Http\Controllers\Controller;
use App\Imports\TPSImport;
use App\Models\Dapil;
use App\Models\Desa;
use App\Models\TPS;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TPSController extends Controller
{
    public function index(TPSDataTable $dataTable)
    {
        $dapil = Dapil::orderBy('name', 'ASC')->get();
        $desa = Desa::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.tps.index', compact([
            'dapil',
            'desa',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'dapil_id' => 'numeric|required',
            'desa_id' => 'numeric|required',
            'address' => 'string|nullable',
        ]);

        TPS::updateOrCreate($data, $data);

        return redirect()->route('tps.index')->withNotify('Data berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'dapil_id' => 'required|numeric|exists:dapil,id',
            'file' => 'required|file|mimes:xlsx',
        ]);

        $import = new TPSImport($request->dapil_id);
        Excel::import($import, $request->file('file'));

        if (!empty($import->errors)) {
            $errorText = collect($import->errors)->map(function ($fail) {
                $row = 'Baris ' . $fail['row'];
                $messages = implode(', ', $fail['messages']);
                return $row . ': ' . $messages;
            })->implode('<br>'); // langsung pakai <br>
            return redirect()->route('tps.index')->withNotifyerror($errorText);
        }

        return redirect()->route('tps.index')->withNotify('Data berhasil diimpor.');
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new TPSExport, 'data_tps.xlsx');
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
        $data = TPS::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'dapil_id' => 'numeric|required',
            'desa_id' => 'numeric|required',
            'address' => 'string|nullable',
        ]);

        $data->update($rawData);
        return redirect()->route('tps.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = TPS::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('tps.index')->withNotify('Data berhasil dihapus');
    }
}
