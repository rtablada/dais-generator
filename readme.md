##Dais Generator
This Laravel 4 package provides a generator for creating scaffolding styled with some very pretty bootstrap.

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `way/generators`.

    "require": {
		"laravel/framework": "4.0.*",
		"rtablada/dais-generator": "dev-master"
	}

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add these new items to the providers array.

	'Rtablada\DaisGenerator\DaisGeneratorServiceProvider',
	'Way\Generators\GeneratorsServiceProvider'

That's all folks! We also installed Jeffrey Way's awesome generators which lie at the core of this provider!

## Usage

Once all is up and running, you will be able to create a full scaffold with a simple command:

	`php artisan generate:scaffold post --fields="title:string, body:text"

With that little bash command, you will have created the following:
	Eloquent ORM Model (with fillable properties)
	Controller (with all of the work done for your prototype needs)
	Controller Test Shell (for when your prototype needs to get bigger)
	Migration file (so you can just run `php artisan migrate`)
	Views
		Layout (Based on the HTML 5 Boilerplate with Twitter Bootstrap)
		Index (Table of all fields paginated to 20 entries)
		Show (Detail view of an element)
		Create (Form for creating)
		Edit (Form for Editing)
		_form (Form Parital for easier editing)
