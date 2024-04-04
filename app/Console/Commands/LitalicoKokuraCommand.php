<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\JsonOptions;
use App\Console\Commands\Concerns\Litalico;
use Illuminate\Console\Command;

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return $this->snabi();
    }
}
