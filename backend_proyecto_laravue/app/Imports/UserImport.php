<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => bcrypt($row[2]),
            ]);
        }
    }
}
