<?php

namespace CrCms\Repository\Console\Commands;

use CrCms\Repository\Console\Commands\Creator\RepositoryCreator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Repository
 * @package CrCms\Repository\Console\Commands
 */
class Repository extends Command
{
    /**
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * @var string
     */
    protected $signature = 'make:repository {repository} {--model=}';

    /**
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * @var RepositoryCreator|null
     */
    protected $creator = null;

    /**
     * Repository constructor.
     * @param RepositoryCreator $creator
     */
    public function __construct(RepositoryCreator $creator)
    {
        parent::__construct();
        $this->creator = $creator;
    }

    /**
     *
     */
    public function handle()
    {
        //
        $arguments = $this->arguments();
        $options = $this->options();

        if (empty($options['model'])) {
            $this->error('You must enter an existing model');
            exit();
        }

        $this->creator->create($arguments['repository'], $options['model']);

        //update composer autoload
        app('composer')->dumpAutoloads();

        $this->info("Successfully created the repository class");
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['repository', InputArgument::REQUIRED, 'The repository name.'],
            ['model', InputArgument::REQUIRED, 'The model name.']
        ];
    }
}
