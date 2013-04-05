<?php

namespace Rtablada\DaisGenerator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Way\Generators\Commands;

/**
* Generates a fully stocked model for a scaffold resource
*/
class GenerateScaffoldModelCommand extends Generate
{
	/**
	 * The consold command name.
	 * 
	 * @var string
	 */
	protected $name = 'generate:scaffoldModel';
	
	/**
	 * The console command description.
	 * 
	 * @var string
	 */
	protected $description = 'Generate a model for a scaffold resource.';
	
	/**
	 * The type of file generation.
	 * 
	 * @var string
	 */
	protected $type = 'scaffoldModel';

	/**
	 * Render template from stub file
	 * 
	 * @return string template to be saved to new file path
	 */
	public function applyDataToStub()
	{
		$name = ucwords(strtolower($this->argument('fileName')));

		$stub = $this->getStub();
		$stub = str_replace('{{name}}', $name, $stub);
		
		$fields = $this->setFields();
		$stub = str_replace('{{fields}}', $fields, $stub);

		return $stub;
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
			array('path', null, InputOption::VALUE_OPTIONAL, 'The path to the migrations folder', 'database/migrations'),
			array('fields', null, InputOption::VALUE_OPTIONAL, 'Table fields', null)
		);
  	}

	protected function setFields()
	{
		if ($fields = $this->option('fields')) {
			return $fieldsString;
		} else return '';
	}
}