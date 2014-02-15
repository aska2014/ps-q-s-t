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
        $array = DB::select('SHOW TABLES LIKE "krq_migrations"');

        if(count($array) > 0)
        {
            $this->call('migrate:reset');
        }
        $this->call('migrate', array('--package' => 'kareem3d/membership'));
        $this->call('migrate', array('--package' => 'kareem3d/images'));
        $this->call('migrate', array('--package' => 'kareem3d/freak'));
        $this->call('migrate');
        $this->call('db:seed', array('--class' => "ImageSeeder"));
        $this->call('db:seed', array('--class' => "CountrySeeder"));
        $this->call('db:seed', array('--class' => "MassOfferSeeder"));
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
