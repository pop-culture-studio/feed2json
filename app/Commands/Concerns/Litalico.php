<?php

namespace App\Commands\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

trait Litalico
{
    /**
     * @return int
     */
    public function snabi(): int
    {
        $response = Http::get($this->url);

        if ($response->failed()) {
            return 1;
        }

        $crawler = new Crawler($response->body());

        $articles = json_decode($crawler->filter('#BlogArticleIndexPage')->attr('data-blog-articles'), true);

        $items = collect($articles)->map(function ($item) {
            $content_state = json_decode($item['content_state'], true);

            $date = $item['formatted_open_at'];

            return [
                'title' => $item['title'],
                'link' => $this->url.'/'.$item['id'],
                'description' => $this->description($content_state['blocks']),
                'thumbnail' => $this->thumbnail($content_state['entityMap']),
                'date' => Carbon::parse($date)->toDateString(),
                'time' => '00:00:00',
                'diff' => Carbon::parse($date)->locale('ja')->diffForHumans(),
            ];
        });

        $json = $items->toJson($this->json_options);

        Storage::put($this->file, $json);

        $this->info($json);

        return 0;
    }

    /**
     * @param  array  $blocks
     * @return string
     */
    private function description(array $blocks): string
    {
        $description = collect($blocks)
            ->pluck('text')
            ->reject(fn ($item) => blank($item))
            ->join('');

        return Str::of($description)->replace("\n", '<br>')->value();
    }

    /**
     * @param  array  $entityMap
     * @return string
     */
    private function thumbnail(array $entityMap): string
    {
        return Arr::get(collect($entityMap)->firstWhere('type', 'IMAGE'), 'data.src');
    }
}
