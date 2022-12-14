<?php

namespace App\Commands;

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
     * @return int
     */
    public function handle(): int
    {
        $this->call(NoteCommand::class);
        $this->call(LitalicoHakataCommand::class);
        $this->call(LitalicoKokuraCommand::class);

        return 0;
    }
}
