<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        return 0;
    }
}
