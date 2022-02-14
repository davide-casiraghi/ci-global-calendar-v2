<?php

namespace App\Console\Commands;

use App\Services\EventService;
use Illuminate\Console\Command;

class SendEmailsExpiringRepetitiveEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:sendEmailToExpiringEventsOrganizers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to the organizers of repetitive events that expire in one week from today.';

    private EventService $eventService;

    /**
     * Create a new command instance.
     *
     * @param  EventService  $eventService
     */
    public function __construct(EventService $eventService)
    {
        parent::__construct();
        $this->eventService = $eventService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiringEvents = $this->eventService->getRepetitiveEventsExpiringInOneWeek(true);

        $output = $this->eventService->sendEmailToExpiringEventsOrganizers($expiringEvents);
        $this->info($output); // Write output to console.

        return 0;
    }
}
