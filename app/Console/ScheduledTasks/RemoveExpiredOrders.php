<?php
namespace App\Console\ScheduledTasks;

use App\Models\Order;

class RemoveExpiredOrders
{
    public function __invoke()
    {
        Order::where('status', 'Cancelled')->delete();
    }
}