<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\JsonOptions;
use App\Console\Commands\Concerns\Litalico;
use Illuminate\Console\Command;

class LitalicoHakataCommand extends Command
{
    use JsonOptions;
    use Litalico;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'feed:hakata';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    private string $url = 'https://snabi.jp/facility/19496/blog_articles';

    private string $file = 'snabi_hakata.json';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return $this->snabi();
    }
}
