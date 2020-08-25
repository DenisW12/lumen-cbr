<?php

namespace App\Console\Commands;

use App\Services\Currency\ICurrenciesService;
use Illuminate\Console\Command;

class CurrenciesUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ICurrenciesService $service
     * @return int
     */
    public function handle(ICurrenciesService $service)
    {
        try {
            $service->updateRates();
            $this->info('Successfully updated');
        } catch (\Exception $e) {
            $this->error('Internal server error');
        }

        return 0;
    }
}
