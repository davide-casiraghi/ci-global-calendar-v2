<?php

namespace App\Console\Commands;

use App\Services\StatisticService;
use Illuminate\Console\Command;

class UpdateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the statistics creating a row in the statistics table.';

    private StatisticService $statisticService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        StatisticService $statisticService,
    )
    {
        parent::__construct();
        $this->statisticService = $statisticService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->statisticService->updateStatistics();

        return Command::SUCCESS;
    }
}
