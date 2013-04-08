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
	protected $name = 'generate:sView';
	
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
				case '_form':
					$this->buildForm();
					break;
				case 'create':
					$this->buildCreate();
					break;
				case 'edit':
					$this->buildEdit();
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
		$thead .= "\n\t\t\t\t\t<th></th>";
		return $thead;
	}

	public function buildIndexTableBody()
	{
		$name = strtolower($this->argument('fileName'));
		$singleName = Pluralizer::singular($name);
		$fields = $this->getFields();
		$tbody = '';

		foreach ($fields as $key => $field) {
			$td = 
				'<td>{{ substr($' .
				$singleName . '->' .
				$field->name .
				', 0, 100) }}</td>';

			if ($key == 0) {
				$tbody .= $td;
			} else {
				$tbody .= "\n\t\t\t\t\t" . $td;
			}
		}
		$tbody .=
			"\n\t\t\t\t\t<td>\n\t\t\t\t\t\t" .
			'<a href="{{ URL::route(\'{{pluralName}}.edit\', ${{singleName}}->id) }}"><i class="icon-edit"></i></a>' .
			"\n\t\t\t\t\t\t" .
			'<a href="{{ URL::route(\'{{pluralName}}.destroy\', ${{singleName}}->id) }}" data-method="DELETE">' .
			"\n\t\t\t\t\t\t\t<i class=\"icon-trash\"></i>" .
			"\n\t\t\t\t\t\t</a>" .
			"\n\t\t\t\t\t\t</td>";
		return $tbody;
	}

	public function buildShow()
	{
		$properties = $this->getShowProperties();
		$stub = $this->getStub('views/show');
		$stub = str_replace('{{properties}}', $properties, $stub);
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());
	}

	public function getShowProperties()
	{
		$name = strtolower($this->argument('fileName'));
		$singleName = Pluralizer::singular($name);
		$fields = $this->getFields();
		$properties = '';

		foreach ($fields as $key => $field) {
			$property = 
				'<p>' .
				ucwords($field->name) .
				': {{ $' .
				$singleName .
				'->' .
				$field->name .
				' }}</p>';
			if ($key == 0) {
				$properties .= $property;
			} else {
				$properties .= "\n\t\t" . $property;
			}
		}
		return $properties;
	}

	public function buildForm()
	{
		$fields = $this->getFormFields();
		$stub = $this->getStub('views/_form');
		$stub = str_replace('{{fields}}', $fields, $stub);
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());		

	}

	public function getFormFields()
	{
		$name = strtolower($this->argument('fileName'));
		$singleName = Pluralizer::singular($name);
		$fields = $this->getFields();
		$formFields = '';

		foreach ($fields as $key => $field) {
			switch ($field->type) {
				case 'string':
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::text('" .
						$field->name .
						"', $" .
						$singleName .
						"->" .
						$field->name .
						") }}";
					break;
				case 'text':
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::textarea('" .
						$field->name .
						"', $" .
						$singleName .
						"->" .
						$field->name .
						") }}";
					break;
				case 'integer':
				case 'tinyInteger':
				case 'unsignedInteger':
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::input('number', '" .
						$field->name .
						"', $" .
						$singleName .
						"->" .
						$field->name .
						", array('step'=>'1')) }}";
					break;
				case 'float':
				case 'decimal':
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::input('number', '" .
						$field->name .
						"', $" .
						$singleName .
						"->" .
						$field->name .
						", array('step'=>'any')) }}";
					break;
				case 'boolean':
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::checkbox('" .
						$field->name .
						"') }}";
						break;
				
				default:
					$formField =
						"{{ Form::label('$field->name', '" .
						ucwords($field->name) .
						"') }}" .
						"\n\t\t{{ Form::text('" .
						$field->name .
						"', $" .
						$singleName .
						"->" .
						$field->name .
						") }}";
					break;
			}

			if ($key == 0) {
				$formFields .= $formField;
			} else {
				$formFields .= "\n\t\t" .$formField;
			}
		}
		return $formFields;
	}

	public function buildCreate()
	{
		$stub = $this->getStub('views/create');
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());
	}

	public function buildEdit()
	{
		$stub = $this->getStub('views/edit');
		$this->replaceNames($stub);

		\File::put($this->getNewFilePath(), $stub);
		$this->info('File created at: ' . $this->getNewFilePath());
	}


	public function replaceNames(&$stub)
	{
		$name = strtolower($this->argument('fileName'));

		$singleName = Pluralizer::singular($name);
		$controllerName = ucwords($name) . 'Controller';

		$stub = str_replace('{{ControllerName}}', $controllerName, $stub);
		$stub = str_replace('{{pluralName}}', $name, $stub);
		$stub = str_replace('{{PluralName}}', ucwords($name), $stub);
		$stub = str_replace('{{singleName}}', $singleName, $stub);
		$stub = str_replace('{{SingleName}}', ucwords($singleName), $stub);
	}

	/**
	 * Get the path to the file that should be generated.
	 * 
	 * @return string
	 */
	protected function getNewFilePath()
	{
		return app_path() . '/' . $this->option('path') . '/' . strtolower($this->option('method')) . '.blade.php';
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