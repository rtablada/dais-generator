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

	public function fire()
	{
		switch ($this->option('method')) {
			case 'index':
				$this->buildIndex();
				break;
			
			default:
				echo 'null';
				break;
		}
		die();
	}

	/**
	 * Generates Index View for scaffold
	 * @return void
	 */
	public function buildIndex()
	{
		$thead = $this->buildTableHead();
		// $tbody = $this->buildTableBody();
		
		$stub = $this->getStub('views/index');
		$stub = str_replace('{{thead}}', $thead, $stub);
		// $stub = str_replace('{{tbody}}', $tbody, $stub);

		\File::put($this->getNewFilePath(), $stub);
	}

	public function buildTableHead()
	{
		$fields = $this->getFields();
		$thead = '';
		foreach ($fields as $key => $field) {
			$th = '<th>' . ucwords($field->name) . '</th>';
			if ($key == 0) {
				$thead .= $th;
			} else {
				$thead .= "\n\t\t\t\t" . $th;
			}
		}
		return $thead;
	}

	/**
	 * Get the path to the file that should be generated.
	 * 
	 * @return string
	 */
	protected function getNewFilePath()
	{
		return app_path() . '/' . $this->option('path') . '/' . strtolower($this->argument('fileName')) . '.php';
	}

	public function applyDataToStub()
	{
		return null;
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
	protected function getFields()
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
			array('fileName', InputArgument::REQUIRED, 'Name of the view.'),
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
			array('fields', null, InputOption::VALUE_OPTIONAL, 'Schema fields', null),
			array('method', null, InputOption::VALUE_OPTIONAL, 'Method for a view.', null),
		);
	}
}