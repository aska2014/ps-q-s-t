<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BackupDatabaseCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'backup:db';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
        $this->dropAll();
        $this->call('migrate', array('--package' => 'kareem3d/membership'));
        $this->call('migrate', array('--package' => 'kareem3d/images'));
        $this->call('migrate', array('--package' => 'kareem3d/freak'));
        $this->call('migrate');

        $tables = DB::connection('remote')->select('SHOW TABLES');

        foreach($tables as $table)
        {
            $table = (array) $table;
            $table = array_pop($table);

            $tableData = $this->convertToArray(DB::connection('remote')->select('SELECT * FROM '.$table));

            DB::table(str_replace('krq_', '',$table))->insert($tableData);

            $this->info('Table '.$table.' has been filled');
        }
	}

    /**
     *
     */
    protected function dropAll()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $queries = DB::select("SELECT concat('DROP TABLE IF EXISTS `', table_name, '`;')
                FROM information_schema.tables
                WHERE table_schema = '". DB::getDatabaseName() ."'");

        foreach($queries as $query)
        {
            $query = get_object_vars($query);
            $query = array_shift($query);

            DB::statement($query);
        }

        $this->comment('All tables dropped.');
    }

    /**
     * @param $objects
     * @return array
     */
    protected function convertToArray($objects)
    {
        $array = array();

        foreach($objects as $object)
        {
            $array[] = (array) $object;
        }

        return $array;
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
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
