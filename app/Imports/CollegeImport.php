<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CollegeImport implements ToModel, WithStartRow, WithMultipleSheets {

    private $rows = 0;
    private $results = [];

    public function model(array $row) {
        try {
            array_push($this->results, $row);
        } catch (\Throwable $th) {}
    }

    public function startRow(): int {
        return 2;
    }

    public function getRows(): array {
        return $this->results;
    }

    public function getRowCount(): int {
        return $this->rows;
    }

    public function sheets(): array {
        return [
            0 => $this,
        ];
    }
}
