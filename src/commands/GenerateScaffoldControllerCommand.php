<?php

namespace Rtablada\DaisGenerator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Way\Generators\Commands;

/**
* Generates a fully stocked controller for a scaffold resource
*/
class GenerateScaffoldControllerCommand extends Generate
{
	/**
	 * The consold command name.
	 * 
	 * @var string
	 */
	protected $name = 'generate:scaffoldController';
	
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
	protected $type = 'scaffoldController';
	
	/**
	 * Create a new command instance.
	 *
	 * @return  void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function applyDataToStub()
	{
		$stub = $this->getStub();

		$name = strtolower($this->argument('fileName'));
		$pluralName = Pluralizer::plural($name);
		$controllerName = ucwords($pluralName) . 'Controller';

		$stub = str_replace('{{ControllerName}}', $controllerName, $stub);
		$stub = str_replace('{{pluralName}}', $pluralName, $stub);
		$stub = str_replace('{{PluralName}}', ucwords($pluralName), $stub);
		$stub = str_replace('{{singleName}}', $name, $stub);
		$stub = str_replace('{{singleName}}', ucwords($name), $stub);

		return str_replace('{{name}}', ucwords($this->argument('fileName')), $this->getStub());
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