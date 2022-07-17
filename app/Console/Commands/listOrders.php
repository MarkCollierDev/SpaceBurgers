<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class listOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:listOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get full view of orders, crew and fillings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        print_r(Order::with(['fillings','crew','bun'])->get()->toArray());
        return 1;
    }
}
