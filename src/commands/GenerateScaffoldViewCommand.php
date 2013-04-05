<?php

namespace Rtablada\DaisGenerator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Way\Generators\Commands;

/**
* Generates a fully stocked model for a scaffold resource
*/
class GenerateScaffoldViewCommand extends Generate
{
	/**
	 * The consold command name.
	 * 
	 * @var string
	 */
	protected $name = 'generate:scaffoldView';
	
	/**
	 * The console command description.
	 * 
	 * @var string
	 */
	protected $description = 'Generate a view for a scaffold resource.';
	
	/**
	 * The type of file generation.
	 * 
	 * @var string
	 */
	protected $type = 'scaffoldView';

	/**
	 * Render template from stub file
	 * 
	 * @return string template to be saved to new file path
	 */
	public function applyDataToStub()
	{
		$stub = $this->getStub($this->argument('method'));

		$name = ucwords(strtolower($this->argument('fileName')));

		$stub = str_replace('{{name}}', $name, $stub);
		$fields = $this->getFields();
		$stub = str_replace('{{fields}}', $fields, $stub);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
	  return array(
	    array('fileName', InputArgument::REQUIRED, 'Name of the view.'),
	    array('method', InputArgument::REQUIRED, 'Method for view.'),
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