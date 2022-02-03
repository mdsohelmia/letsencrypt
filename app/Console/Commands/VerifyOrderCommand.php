<?php

namespace App\Console\Commands;

use App\actions\LetsEncryptCreate;
use Illuminate\Console\Command;

class VerifyOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $data = (new LetsEncryptCreate())->verify();
        dd($data);
        return 0;
    }
}
