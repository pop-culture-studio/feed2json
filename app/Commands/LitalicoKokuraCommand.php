<?php

namespace App\Commands;

use App\Commands\Concerns\JsonOptions;
use App\Commands\Concerns\Litalico;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class LitalicoKokuraCommand extends Command
{
    use JsonOptions;
    use Litalico;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'feed:kokura';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    private string $url = 'https://snabi.jp/facility/22928/blog_articles';

    private string $file = 'snabi_kokura.json';

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
