<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Parser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse {type=add} {debug=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse articles from env(PARSE_DOMAIN). parse [add/refresh] [1/0]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ParserNews $parserNews
     * @return int
     */
    public function handle(ParserNews $parserNews): int
    {
        $parserNews->index($this->arguments());

        return 0;
    }
}
