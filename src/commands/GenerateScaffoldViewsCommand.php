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
	protected $name = 'generate:sAllViews';
	
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
	protected $type = 'sAllViews';
	
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

		//Create scaffold layout
		if ( ! \File::exists(app_path() . '/views/layouts/scaffold.blade.php') )
		{
			$this->generateLayout();
		}
		

		$name = ucwords(strtolower($this->argument('fileName')));

		$methods = array('index', 'show', '_form', 'create', 'edit');
		foreach($methods as $method)
		{
			$this->call(
				'generate:sView',
				array(
					'fileName'  => $name,
					'--method'  => $method,
					'--path'    => 'views/' . strtolower($name),
					'--fields' => $this->option('fields')
				)
			);
		}
	}

	public function applyDataToStub()
	{
		return null;
	}

	public function generateLayout()
	{
		// Get stub for layout
		$layoutFile = $this->getStub('views/layout');
		// Save layout file
		$layoutPath = app_path() . '/views/layouts/scaffold.blade.php';
		\File::put($layoutPath, $layoutFile);
		$this->info('File created at: ' . $layoutPath);
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
	    array('path', null, InputOption::VALUE_OPTIONAL, 'Path to save new views.', 'views'),
	    array('fields', null, InputOption::VALUE_OPTIONAL, 'Table fields', null)
	  );
	}
}