<?php

namespace App\Imports;

use App\Models\Election;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ElectionImport implements ToCollection, WithHeadingRow
{
    public $errors = [];
    public function collection(Collection $rows)
    {
        $validData = [];
        $this->errors = [];

        foreach ($rows as $index => $row) {
            $validator = Validator::make($row->toArray(), [
                'vote' => 'required|numeric|min:0',
                'vote_party' => 'required|numeric|min:0',
                'tps_id' => 'required|numeric|exists:tps,id',
            ]);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'messages' => $validator->errors()->all()
                ];
            } else {
                $validData[] = [
                    'vote'     => $row['vote'],
                    'vote_party'  => $row['vote_party'],
                    'tps_id'  => $row['tps_id'],
                ];
            }
        }

        // Hanya insert jika tidak ada error
        if (empty($this->errors)) {
            foreach ($validData as $data) {
                Election::updateOrCreate(['tps_id' => $data['tps_id']],$data);
            };
        }
    }
}
