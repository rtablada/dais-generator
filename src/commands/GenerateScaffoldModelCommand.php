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
	protected $name = 'generate:sModel';
	
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
	 * Create a string representing an array of terms.
	 */
	protected function setFields()
	{
		if ($this->option('fields')) {
			$seperator = ",\n\t\t";
			$fieldsString = '';
			$fields = $this->convertFieldsToArray();
			foreach ($fields as $count => $field) {
				if ($count >= 1) {
					$fieldsString .= $seperator . "'$field->name'";
				} else {
					$fieldsString .= "'$field->name'";
				}
			}
			
			return $fieldsString;
		} else return '';
	}

	/**
	 * If Schema fields are specified, parse
	 * them into an array of objects.
	 *
	 * So: name:string, age:integer
	 * Becomes: [ ((object)['name' => 'string'], (object)['age' => 'integer'] ]
	 *
	 * @returns mixed
	 */
	protected function convertFieldsToArray()
	{
		$fields = $this->option('fields');

		if ( !$fields ) return;

		$fields = preg_split('/, ?/', $fields);

		foreach($fields as &$bit) {
		  $columnInfo = preg_split('/ ?: ?/', $bit);

		  $bit = new \StdClass;
		  $bit->name = $columnInfo[0];
		  $bit->type = $columnInfo[1];

		  // If there is a third key, then
		  // the user is setting an index/option.
		  if ( isset($columnInfo[2]) ) {
		    $bit->index = $columnInfo[2];
		  }
		}

		return $fields;
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
			array('path', null, InputOption::VALUE_OPTIONAL, 'The path to the models folder', 'models'),
			array('fields', null, InputOption::VALUE_OPTIONAL, 'Table fields', null)
		);
  	}
}