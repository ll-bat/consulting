<?php

namespace App\Imports;



use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class ProcessesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $data = [];
        foreach ($rows as $row) 
        {
            $data[] = $row;
        }

    }
}
