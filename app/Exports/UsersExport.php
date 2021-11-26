<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
         return User::join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                    ->join('countries','user_profiles.country_id', '=', 'countries.id')
                    ->select('users.id', 'user_profiles.name as userName', 'user_profiles.surname as userSurname', 'countries.name as countryName', 'users.email', DB::raw("DATE_FORMAT(users.created_at, '%d-%b-%Y') as createdOn"), 'user_profiles.description')->get();
    }
}


