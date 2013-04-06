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
		if ( ! \File::exists($this->getNewFilePath()) ) {
			switch ($this->option('method')) {
				case 'index':
					$this->buildIndex();
					break;
				case 'show':
					$this->buildShow();
					break;
				
				default:
					echo 'null';
					die();
					break;
			}
		} else {
			return $this->error('The ' . $this->option('method') . ' view already exists!');
		}
	}

	/**
	 * Generates Index View for scaffold
	 * 
	 * @return void
	 */
	public function buildIndex()
	{

		$thead = $this->buildIndexTableHead();
		$tbody = $this->buildIndexTableBody();
		
		$stub = $this->getStub('views/index');
		$stub = str_replace('{{thead}}', $thead, $stub);
		$stub = str_replace('{{tbody}}', $tbody, $stub);
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());
	}

	/**
	 * Creates stub for table head of index view
	 * 
	 * @return string
	 */
	public function buildIndexTableHead()
	{
		$fields = $this->getFields();
		$thead = '';
		foreach ($fields as $key => $field) {
			$th = '<th>' . ucwords($field->name) . '</th>';
			if ($key == 0) {
				$thead .= $th;
			} else {
				$thead .= "\n\t\t\t\t\t" . $th;
			}
		}
		return $thead;
	}

	public function buildIndexTableBody()
	{
		$name = strtolower($this->argument('fileName'));
		$fields = $this->getFields();
		$tbody = '';

		foreach ($fields as $key => $field) {
			$td = 
				'<td>{{ substr(0, 100, ' .
				$name . '->' .
				$field->name .
				') }}</td>';

			if ($key == 0) {
				$tbody .= $td;
			} else {
				$tbody .= "\n\t\t\t\t\t" . $td;
			}
		}
		return $tbody;
	}

	public function buildShow()
	{
		$arguments = $this->getArguments();
		$stub = $this->getStub('views/show');
		$stub = str_replace('{{arguments}}', $arguments, $stub);
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());
	}

	public function replaceNames(&$stub)
	{
		$name = strtolower($this->argument('fileName'));
		$pluralName = Pluralizer::plural($name);
		$controllerName = ucwords($pluralName) . 'Controller';

		$stub = str_replace('{{ControllerName}}', $controllerName, $stub);
		$stub = str_replace('{{pluralName}}', $pluralName, $stub);
		$stub = str_replace('{{PluralName}}', ucwords($pluralName), $stub);
		$stub = str_replace('{{singleName}}', $name, $stub);
		$stub = str_replace('{{SingleName}}', ucwords($name), $stub);
	}

	/**
	 * Get the path to the file that should be generated.
	 * 
	 * @return string
	 */
	protected function getNewFilePath()
	{
		return app_path() . '/' . $this->option('path') . '/' . strtolower($this->option('method')) . '.php';
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