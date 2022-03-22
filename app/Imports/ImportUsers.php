<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportUsers implements ToModel, WithHeadingRow, WithProgressBar, WithBatchInserts
{
    use Importable;

    public function startRow(): int
    {
        return 3;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'expected_attending' => (int)1,
            'party_name' => $row['party_name'],
            'greeting_name' => $row['greeting_name'],
            'meal_choice' => json_encode([]),
            'password' => Hash::make($row['password']),
        ]);
    }

}
