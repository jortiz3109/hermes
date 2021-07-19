<?php
namespace Hermes\Console\Commands;

use Illuminate\Console\Command;

class ListenCommand extends Command
{
    protected $signature = 'hermes:listen';

    protected $description = 'Listen to the message broker for incoming messages';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}