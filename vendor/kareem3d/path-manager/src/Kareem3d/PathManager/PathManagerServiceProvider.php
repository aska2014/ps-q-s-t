<?php namespace Kareem3d\PathManager;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class PathManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        \Kareem3d\PathManager\Path::init(URL::to(''), public_path());
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}