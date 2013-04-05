@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>New {{SingleName}}</h1>
		</div>
	</div>
	<hr>
	<div class="row">
		{{ Form::model(${{singleName}}, array('url'=>URL::route('{{controllerName}}.store'))) }}
		<fieldset>
		@include('{{pluralName}}._form')
		</fieldset>
	</div>
	<div class="row">
		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
			{{ HTML::link( URL::edit_user($user->id), 'Cancel', array('class' => 'btn')) }}
		</p>
	</div>
	<hr>
@stop