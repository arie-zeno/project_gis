<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where("role", "!=", "admin")->select("nim", "name", "email", "role")->get();
    }

    public function headings(): array
    {
        return ["NIM", "Name", "Email", "Role"];
    }
}
