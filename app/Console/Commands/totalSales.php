<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class totalSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:totalSales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'displays total income made from order';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        print_r(Order::sum('price'));
        return 0;
    }
}
