<?php
namespace App\Console\ScheduledTasks;

class TestTask
{
    public function __invoke()
    {
        echo "Do something";
    }
}
