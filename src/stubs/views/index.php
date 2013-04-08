@extends('layouts.scaffold')

@section('content')
	<div class="row">
		<div class="span12">
			<h1>{{SingleName}}</h1>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<a href="{{URL::route('{{pluralName}}.create')}}" class="btn btn-primary pull-right">Add new {{SingleName}}</a>
	</div>
	
	<div class="row">
	@if (count(${{pluralName}}))
		<table class="table table-striped span12">
			<thead>
				<tr>
					{{thead}}
				</tr>
			</thead>
			<tbody>
				@foreach (${{pluralName}} as ${{singleName}})
				<tr>
					{{tbody}}
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="span12">
			<h3>No {{pluralName}} exisit at this time</h3>
		</div>
	@endif
	</div>

	<div class="row">
		<div class="span12">
		{{ ${{pluralName}}->links() }}
		</div>
	</div>
	<hr>
@stop
