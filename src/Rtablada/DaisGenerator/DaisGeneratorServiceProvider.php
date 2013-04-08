<?php namespace Rtablada\DaisGenerator;

use Illuminate\Support\ServiceProvider;

class DaisGeneratorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('rtablada/dais-generator');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['generate.sController'] = $this->app->share(function($app)
		{
			return new Commands\GenerateScaffoldControllerCommand($app);
		});

		$this->app['generate.sModel'] = $this->app->share(function($app)
		{
			return new Commands\GenerateScaffoldModelCommand($app);
		});

		$this->app['generate.sView'] = $this->app->share(function($app)
		{
			return new Commands\GenerateScaffoldViewCommand($app);
		});

		$this->app['generate.sAllViews'] = $this->app->share(function($app)
		{
			return new Commands\GenerateScaffoldViewsCommand($app);
		});

		$this->app['generate.scaffold'] = $this->app->share(function($app)
		{
			return new Commands\GenerateScaffoldCommand($app);
		});

		$this->commands(
			'generate.sController',
			'generate.sModel',
			'generate.sView',
			'generate.sViews',
			'generate.scaffold'
		);
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