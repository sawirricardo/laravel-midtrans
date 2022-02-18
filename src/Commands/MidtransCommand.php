<?php

namespace Sawirricardo\MidtransClient\Commands;

use Illuminate\Console\Command;

class MidtransCommand extends Command
{
    public $signature = 'laravel-midtrans';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
