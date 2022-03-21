<?php

namespace App\Console\Commands;

use App\Services\StatisticService;
use App\Services\VenueService;
use Illuminate\Console\Command;

class UpdateAllVenueGpsCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'venues:updateGpsCoordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the GPS coordinates of all the venues';


    private VenueService $venueService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        VenueService $venueService,
    )
    {
        parent::__construct();
        $this->venueService = $venueService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $venues = $this->venueService->getVenues();
        $venuesNumber = count($venues);

        foreach ($venues as $key => $venue) {

            $this->venueService->updateGpsCoordinates($venue);

            // Print info in console
            // if there are problems the geocode system assign this coordinates 39.78373 -100.445882
            if ($venue->lng != '-100.445882') {
                $this->info($key.' of '.$venuesNumber.' - '.$venue->name.' - '.$venue->country->name);
                $this->info($venue->lat.' '.$venue->lng);
            } else {
                $this->error($key.' of '.$venuesNumber.' - '.$venue->name.' - '.$venue->country->name);
                $this->error($venue->lat.' '.$venue->lng);
            }
        }

        return 0;
    }
}
