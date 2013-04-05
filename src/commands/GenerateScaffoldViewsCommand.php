<?php

namespace Rtablada\DaisGenerator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Way\Generators\Commands;

/**
* Generates a fully stocked controller for a scaffold resource
*/
class GenerateScaffoldViewsCommand extends Generate
{
	/**
	 * The consold command name.
	 * 
	 * @var string
	 */
	protected $name = 'generate:scaffoldViews';
	
	/**
	 * The console command description.
	 * 
	 * @var string
	 */
	protected $description = 'Generate all views for a scaffold resource.';
	
	/**
	 * The type of file generation.
	 * 
	 * @var string
	 */
	protected $type = 'scaffoldViews';
	
	/**
	 * Create a new command instance.
	 *
	 * @return  void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		//Create the layout folder
		if ( ! \File::exists(app_path() . '/views/layouts') )
		{
			\File::makeDirectory(app_path() . '/views/layouts');
		}

		if ( ! \File::exists(app_path() . '/views/layouts/scaffold.blade.php') )
		{
			$this->generateLayout();
		}

		//Create scaffold layout

		$name = ucwords(strtolower($this->argument('fileName')));

		$methods = array('index', 'show', 'create', 'edit');
		foreach($methods as $method)
		{
			$this->call(
				'generate:scaffoldView',
				array(
					'fileName'  => "{$method}",
					'--method'  => $method,
					'--path'    => 'views/' . strtolower($name)
				)
			);
		}
	}

	public function applyDataToStub()
	{
		return null;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
	  return array(
	    array('fileName', InputArgument::REQUIRED, 'Name of the model.'),
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
	    array('path', null, InputOption::VALUE_OPTIONAL, 'Path to save new model.', 'models'),
	  );
	}
}