<?php
namespace App\Services;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\Statistic;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\OrganizerRepositoryInterface;
use App\Repositories\StatisticRepository;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Collection;

class StatisticService
{
    private StatisticRepository $statisticRepository;
    private UserRepositoryInterface $userRepository;
    private OrganizerRepositoryInterface $organizerRepository;
    private TeacherRepositoryInterface $teacherRepository;
    private EventRepositoryInterface $eventRepository;
    private EventService $eventService;

    /**
     * StatisticService constructor.
     *
     * @param  StatisticRepository  $statisticRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        StatisticRepository $statisticRepository,
        OrganizerRepositoryInterface $organizerRepository,
        TeacherRepositoryInterface $teacherRepository,
        EventRepositoryInterface $eventRepository,
        EventService $eventService,
    ) {
        $this->userRepository = $userRepository;
        $this->statisticRepository = $statisticRepository;
        $this->organizerRepository = $organizerRepository;
        $this->teacherRepository = $teacherRepository;
        $this->eventRepository = $eventRepository;
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request)
    {
        $lastUpdateStatistic = Statistic::find(\DB::table('statistics')->max('id'));

        $registeredUsersChart = $this->createLinesChart(12);

        $usersByCountryChart = $this->createUsersByCountryChart();
        $teachersByCountriesChart = $this->createTeachersByCountriesChart();
        $eventsByCountriesChart = $this->createEventsByCountriesChart();
        //$organizersByCountriesChart = $this->createOrganizersByCountriesChart();

        return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('registeredUsersChart', $registeredUsersChart)
            ->with('usersByCountryChart', $usersByCountryChart)
            ->with('teachersByCountriesChart', $teachersByCountriesChart)
            ->with('eventsByCountriesChart', $eventsByCountriesChart);
        //->with('organizersByCountriesChart', $organizersByCountriesChart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    /*public function store()
    {
        Statistic::updateStatistics();
    }*/

    /**
     * Create a LINE chart showing the number of users in the last x days.
     *
     * @param  int  $daysRange
     * @return LatestUsers
     */
    /*public function createLinesChart(int $daysRange): LatestUsers
    {
        $lastIDUpdatedStats = Statistic::max('id');

        // Registered users
        $dataRegisteredUsers = collect([]);
        $dataOrganizerProfiles = collect([]);
        $dataTeacherProfiles = collect([]);
        $dataActiveEvents = collect([]);

        $labels = [];
        //for ($days_backwards = $daysRange; $days_backwards >= 0; $days_backwards--) {
        for ($days_backwards = 0; $days_backwards >= 0; $days_backwards--) {
            $dayStat = Statistic::find($lastIDUpdatedStats - $days_backwards);
            //dd($days_backwards);
            $dataRegisteredUsers->push($dayStat->registered_users_number);
            $dataOrganizerProfiles->push($dayStat->organizers_number);
            $dataTeacherProfiles->push($dayStat->teachers_number);
            $dataActiveEvents->push($dayStat->active_events_number);
            $labels[] = Carbon::parse($dayStat->created_at)->format('d/m');
        }

        $ret = new LatestUsers;

        $ret->labels($labels);
        $dataset = $ret->dataset('Registered Users', 'line', $dataRegisteredUsers)
            ->options([
                'borderColor' => '#2669A0',
                'backgroundColor' => '#2669A0',
                'fill' => false,
            ]);

        $ret->dataset('Organizer Profiles', 'line', $dataOrganizerProfiles)
            ->options([
                'borderColor' => '#a12d97',
                'backgroundColor' => '#a12d97',
                'fill' => false,
            ]);

        $ret->dataset('Teacher Profiles', 'line', $dataTeacherProfiles)
            ->options([
                'borderColor' => '#e8af17',
                'backgroundColor' => '#e8af17',
                'fill' => false,
            ]);

        $ret->dataset('Active Events', 'line', $dataActiveEvents)
            ->options([
                'borderColor' => '#297446',
                'backgroundColor' => '#297446',
                'fill' => false,
            ]);

        //$chart->labels(['One', 'Two', 'Three', 'Four']);
        //$chart->dataset('My dataset', 'line', [1, 2, 3, 7]);
        //$chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);

        //https://www.chartjs.org/docs/latest/charts/line.html

        return $ret;
    }
    */

    /**
     * Create a BAR chart showing the number of Users by country.
     *
     * @return LatestUsers
     */
    /*public function createUsersByCountryChart()
    {
        $usersByCountry = User::leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->leftJoin('countries', 'countries.id', '=', 'user_profiles.country_id')
            ->select(DB::raw('count(*) as user_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();

        $data = collect([]);
        $labels = [];
        foreach ($usersByCountry as $key => $userByCountry) {
            $data->push($userByCountry->user_count);
            $labels[] = $userByCountry->country_name;
        }

        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Users by Country', 'bar', $data);

        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);

        return $ret;
    }
    */

    /**
     * Create a BAR chart showing the number of Teachers by country.
     *
     * @return LatestUsers
     */
    /*public function createTeachersByCountriesChart()
    {
        $teachersByCountries = Teacher::leftJoin('countries', 'teachers.country_id', '=', 'countries.id')
            ->select(DB::raw('count(*) as teacher_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();

        $data = collect([]);
        $labels = [];
        foreach ($teachersByCountries as $key => $teachersByCountry) {
            $data->push($teachersByCountry->teacher_count);
            $labels[] = $teachersByCountry->country_name;
        }

        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Teachers by Country', 'bar', $data);

        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);

        return $ret;
    }*/


    /**
     * Create a BAR chart showing the number of Organizers by country.
     *
     * @return LatestUsers
     */
    /*public function createOrganizersByCountriesChart()
    {
        $organizersByCountries = Organizer::leftJoin('countries', 'organizers.country_id', '=', 'countries.id')
            ->select(DB::raw('count(*) as organizer_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();
        //dd($organizersByCountries);
        $data = collect([]);
        $labels = [];
        foreach ($teachersByCountries as $key => $teachersByCountry) {
            $data->push($teachersByCountry->teacher_count);
            $labels[] = $teachersByCountry->country_name;
        }

        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Teachers by Country', 'bar', $data);

        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);

        return $ret;
    }*/

    /**
     * Create a BAR chart showing the number of Events by country.
     *
     * @return LatestUsers
     */
    /*public function createEventsByCountriesChart()
    {
        // Get active events
        $activeEventsByCountriesNumber = $this->eventService->activeEventsCountByCountry();

        $data = collect([]);
        $labels = [];
        foreach ($activeEventsByCountriesNumber as $key => $eventsByCountryNumber) {
            $data->push($eventsByCountryNumber);
            $labels[] = $key;
        }

        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Events by Country', 'bar', $data);

        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);

        return $ret;
    }*/

    /**
     * Updates the statistics writing a new line in the statistics table.
     *
     * @return void
     */
    public function updateStatistics():void
    {
        $data = [];
        $data['registered_users_number'] = $this->userRepository->usersCount();
        $data['organizers_number'] = $this->organizerRepository->organizersCount();
        $data['teachers_number'] = $this->teacherRepository->teachersCount();
        $data['active_events_number'] = $this->eventRepository->activeEventsCount();

        $this->statisticRepository->updateStatistics($data);
    }

    /**
     * Return the users number by country.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserNumberByCountries(): \Illuminate\Support\Collection
    {
        return $this->userRepository->usersNumberByCountry();
    }

    /**
     * Return the teachers number by country.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTeachersNumberByCountries(): \Illuminate\Support\Collection
    {
        return $this->teacherRepository->teachersNumberByCountry();
    }
}
