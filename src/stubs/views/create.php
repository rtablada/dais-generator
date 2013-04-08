@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>New {{SingleName}}:</h1>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="span12">
		{{ Form::model(${{singleName}}, array('url'=>URL::route('{{pluralName}}.store'))) }}
		@include('{{pluralName}}._form')
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
			<a href="{{ URL::route('{{pluralName}}.index') }}" class="btn">Cancel</a>
		</p>
		{{ Form::close() }}
	</div>
	<hr>
@stop