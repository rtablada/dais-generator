@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>{{SingleName}}</h1>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<button class="btn btn-primary pull-right">Add new {{SingleName}}</button>
	</div>
	
	<div class="row">
	@if (count(${{pluralName}}))
		<table class="table table-striped">
			<thead>
				{{headers}}
			</thead>
			<tbody>
				{{rows}}
			</tbody>
		</table>
	@else
		<p>No {{pluralName}} exisit at this time</p>
	@endif
	</div>
	<div class="row">
		{{ ${{pluralName}}->links() }}
	</div>
	<hr>
@stop