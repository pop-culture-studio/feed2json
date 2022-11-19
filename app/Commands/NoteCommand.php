<?php

namespace App\Commands;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class NoteCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'feed:note';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    private string $url = 'https://note.com/pcs_miraizu/rss';

    private string $file = 'note_pcs_miraizu.json';

    private int $json_options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $xml = simplexml_load_file($this->url);

        $items = collect();

        foreach ($xml->channel?->item as $item) {
            $items->push([
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'thumbnail' => (string) $item->children('media', true)->thumbnail,
                'creatorImage' => (string) $item->children('note', true)->creatorImage,
                'date' => Carbon::parse($item->pubDate)->toDateString(),
                'time' => Carbon::parse($item->pubDate)->toTimeString(),
                'diff' => Carbon::parse($item->pubDate)->locale('ja')->diffForHumans(),
            ]);
        }

        $json = $items->toJson($this->json_options);

        Storage::put($this->file, $json);

        $this->info($json);

        return 0;
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
