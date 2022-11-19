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
        $url = 'https://note.com/pcs_miraizu/rss';
        $items = collect();

        $xml = simplexml_load_file($url);

        if ($xml === false) {
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

        Storage::put(
            'note_pcs_miraizu.json',
            $json = $items->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        $this->info($json);
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
