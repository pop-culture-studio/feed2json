<?php

namespace App\Commands;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class MakeJsonCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'feed:json';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->note();

        return 0;
    }

    protected function note()
    {
        $items = collect();

        $xml = simplexml_load_file('https://note.com/pcs_miraizu/rss');

        if (! $xml) {
            return;
        }

        foreach ($xml->channel->item as $item) {
            $items->push([
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'date' => Carbon::parse($item->pubDate)->toDateString(),
            ]);
        }

        $this->info($items->toJson(JSON_PRETTY_PRINT));

        Storage::put('note_pcs_miraizu.json', $items->toJson(JSON_PRETTY_PRINT));
    }

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
