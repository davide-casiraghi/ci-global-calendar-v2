<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Teacher;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersByCountryChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $teachersNumberByCountries = Teacher::leftJoin('countries', 'teachers.country_id', '=', 'countries.id')
            ->select(DB::raw('count(*) as teacher_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();

        $data = [];
        $labels = [];
        foreach ($teachersNumberByCountries as $key => $teachersNumberByCountry) {
            $data[] = $teachersNumberByCountry->teacher_count;
            $labels[] = $teachersNumberByCountry->country_name;
        }

        $ret = Chartisan::build();
        $ret->labels($labels);

        $ret->dataset('Teachers by country', $data);

        return $ret;
    }
}