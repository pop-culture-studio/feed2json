<?php

namespace App\Commands;

use App\Commands\Concerns\JsonOptions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class NoteCommand extends Command
{
    use JsonOptions;

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

    private string $rss_url = 'https://note.com/pcs_miraizu/rss';

    private string $embed_url = 'https://note.com/embed/notes/';

    private string $file = 'note_pcs_miraizu.json';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $xml = simplexml_load_file($this->rss_url);

        $items = collect();

        foreach ($xml->channel?->item as $item) {
            $items->push([
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'embed' => $this->embed((string) $item->link),
                'description' => $this->description((string) $item->description ?? ''),
                'thumbnail' => (string) $item->children('media', true)->thumbnail,
                'creator_image' => (string) $item->children('note', true)->creatorImage,
                'date' => Carbon::parse($item->pubDate)->toDateString(),
                'time' => Carbon::parse($item->pubDate)->toTimeString(),
                'diff' => Carbon::parse($item->pubDate)->locale('ja')->diffForHumans(),
            ]);
        }

        $json = $items->take(10)->toJson($this->json_options);

        Storage::put($this->file, $json);

        $this->info($json);

        return 0;
    }

    /**
     * @param  string  $description
     * @return string
     */
    private function description(string $description): string
    {
        return Str::of($description)
                  ->replace('<br/>', '')
                  ->replace('>続きをみる<', ' target="_blank">続きをみる<')
                  ->replaceMatches('/<iframe(.*)<\/iframe>/', '')
                  ->value();
    }

    /**
     * @param  string  $url
     * @return string
     */
    private function embed(string $url): string
    {
        return Str::of($url)
                  ->basename()
                  ->prepend($this->embed_url)
                  ->value();
    }
}
