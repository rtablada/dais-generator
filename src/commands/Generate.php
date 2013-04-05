<?php namespace Rtablada\DaisGenerator\Commands;

/**
* Generates a fully stocked controller for a scaffold resource
*/
abstract class Generate extends \Way\Generators\Commands\Generate
{
	protected function getStub($fileName = null)
	{
		$fileName = $fileName ? $fileName : $this->type;

		return \File::get(__DIR__ . "/../stubs/{$fileName}.php");
	}
}