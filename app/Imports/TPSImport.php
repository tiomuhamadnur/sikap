<?php

namespace App\Imports;

use App\Models\TPS;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TPSImport implements ToCollection, WithHeadingRow
{
    public $dapil_id;
    public $errors = [];

    public function __construct($dapil_id)
    {
        $this->dapil_id = $dapil_id;
    }

    public function collection(Collection $rows)
    {
        $validData = [];
        $this->errors = [];

        foreach ($rows as $index => $row) {
            $validator = Validator::make($row->toArray(), [
                'name' => 'required|string',
                'address' => 'nullable|string',
                'desa_id' => 'required|numeric|exists:desa,id',
            ]);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'messages' => $validator->errors()->all()
                ];
            } else {
                $validData[] = [
                    'name'     => $row['name'],
                    'address'  => $row['address'],
                    'desa_id'  => $row['desa_id'],
                    'dapil_id' => $this->dapil_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Hanya insert jika tidak ada error
        if (empty($this->errors)) {
            foreach ($validData as $data) {
                TPS::updateOrCreate($data, $data);
            };
        }
    }
}
