@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>{{SingleName}}</h1>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="span12">
			{{properties}}
		</div>
	</div>

	<div class="row">
		<div class="span12">
			<a href="{{URL::route('{{pluralName}}.edit', ${{singleName}}->id)}}" class="btn btn-primary">Edit</a>
			<a href="{{URL::route('{{pluralName}}.index')}}" class="btn">Cancel</a>
		</div>
	</div>
	<hr>
@stop
