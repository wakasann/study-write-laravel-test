<?php

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Database\DatabaseManager;


class CustomSeedCommand extends SeedCommand
{
    /**
     * CustomSeedCommand constructor.
     * @link https://stackoverflow.com/a/50680492
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        parent::__construct($databaseManager);
    }

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->resolver->setDefaultConnection($this->getDatabase());

        Model::unguarded(function () {
            $this->getSeeder()->run($this->getTables());
        });
    }

    protected function getTables()
    {
        $tables = $this->input->getOption('tables');

        return $tables ? explode(',', $tables) : [];
    }

    protected function getOptions()
    {
        $options   = parent::getOptions();
        $options[] = ['tables', null, InputOption::VALUE_OPTIONAL, 'A comma-separated list of tables to seed, all if left empty'];

        return $options;
    }
}
