@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>Editing {{SingleName}} {{ ${{singleName}}->id }}:</h1>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="span12">
		{{ Form::model(${{singleName}}, array('method'=>'put', 'url'=>URL::route('{{pluralName}}.update', ${{singleName}}->id))) }}
		@include('{{pluralName}}._form')
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
			{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
			<a href="{{ URL::route('{{pluralName}}.show', ${{singleName}}->id) }}" class="btn">Cancel</a>
		</p>
		{{ Form::close() }}
	</div>
	<hr>
@stop