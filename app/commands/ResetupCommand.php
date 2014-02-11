<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Resetup the application database and seed it.';

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
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $tasks = array(
            'cd /d/Projects/QBrando/new_www',
            'php artisan migrate:reset',
            'php artisan migrate --package="kareem3d/membership"',
            'php artisan migrate --package="kareem3d/images"',
            'php artisan migrate --package="kareem3d/freak"',
            'php artisan migrate',
            'php artisan db:seed --class="ImageSeeder"'
        );

        foreach($tasks as $task) print(exec($task)) . "\n";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
