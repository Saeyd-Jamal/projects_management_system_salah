<?php

namespace App\Imports;

use App\Models\Executive;
use Maatwebsite\Excel\Concerns\ToModel;

class ExecutivesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Executive([
            //
        ]);
    }
}
