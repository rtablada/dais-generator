<?php

namespace Rtablada\DaisGenerator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Way\Generators\Commands;

/**
* Generates a fully stocked controller for a scaffold resource
*/
class GenerateScaffoldCommand extends Generate
{
	/**
	 * The consold command name.
	 * 
	 * @var string
	 */
	protected $name = 'generate:scaffold';
	
	/**
	 * The console command description.
	 * 
	 * @var string
	 */
	protected $description = 'Generate a controller for a scaffold resource.';
	
	/**
	 * The type of file generation.
	 * 
	 * @var string
	 */
	protected $type = 'scaffold';
	
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
		$name = ucwords(strtolower($this->argument('fileName')));
		$pluralName = Pluralizer::plural($name);

		// Create the model
		$this->call(
			'generate:sModel',
			array(
				'fileName' => $name,
				'--fields' => $this->option('fields')
			)
		);


		// Create the controller
		$this->call(
			'generate:sController',
			array('fileName' => $name)
		);


		// Create a test
		$this->call(
			'generate:test',
			array(
				'fileName' => $pluralName . 'ControllerTest',
				'--path' => 'tests/controllers',
				'--controller' => strtolower($pluralName)
			)
		);


		// Create the migration
		$this->call(
			'generate:migration',
			array(
				'fileName' => 'create_' . strtolower($pluralName) . '_table',
				'--fields' => $this->option('fields')
			)
		);


		// Create the views
		if ( ! \File::exists(app_path() . '/views/' . strtolower($pluralName)) )
		{
			\File::makeDirectory(app_path() . '/views/' . strtolower($pluralName));
		}

		$this->call(
			'generate:sAllViews',
			array(
				'fileName' => strtolower($pluralName),
				'--fields' => $this->option('fields')
			)
		);


		// Create the seed file
		$this->call(
			'generate:seed',
			array(
				'tableName' => $pluralName
			)
		);

		// Update the routes.php file
		\File::append(
			app_path() . '/routes.php',
			"\n\nRoute::resource('" . strtolower($pluralName) . "', '" . $pluralName . "Controller');"
		);
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
			array('fields', null, InputOption::VALUE_OPTIONAL, 'Schema fields', null)
		);
	}
}