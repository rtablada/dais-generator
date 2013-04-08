<?php

class {{ControllerName}} extends BaseController {

	/**
	 * Display a listing of the {{pluralName}}.
	 * 
	 * @return Response
	 */
	public function index()
	{
		${{pluralName}} = {{SingleName}}::paginate();
		return View::make('{{pluralName}}.index', compact('{{pluralName}}'));
	}

	/**
	 * Show the for for creating a new {{singleName}}.
	 * 
	 * @return Response
	 */
	public function create()
	{
		${{singleName}} = new {{SingleName}}();
		return View::make('{{pluralName}}.create', compact('{{singleName}}'));
	}

	/**
	 * Store a newly created {{singleName}} in storage.
	 * 
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		if (${{singleName}} = {{SingleName}}::create($input)) {
			Session::flash('success', '{{SingleName}} created successfully!');
			return Redirect::route('{{pluralName}}.index');
		} else {
			Session::flash('error', 'Something went wrong...');
			return Redirect::route('{{pluralName}}.create')->withInput();
		}
	}

	/**
	 * Display the specified {{singleName}}.
	 * 
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		if (!${{singleName}} = {{SingleName}}::find($id)) {
			Session::flash('error', 'Could not find {{singleName}} - ' . $id);
			return Redirect::route('{{pluralName}}.index');
		}

		return View::make('{{pluralName}}.show', compact('{{singleName}}'));
	}

	/**
	 * Show the form for editing the specified {{singleName}}.
	 * 
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (!${{singleName}} = {{SingleName}}::find($id)) {
			Session::flash('error', 'Could not find {{singleName}} - ' . $id);
			return Redirect::route('{{pluralName}}.index');
		}

		return View::make('{{pluralName}}.edit', compact('{{singleName}}'));
	}

	/**
	 * Update the specified {{singleName}} in storage.
	 * 
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{
		if (!${{singleName}} = {{SingleName}}::find($id)) {
			Session::flash('error', 'Could not find {{singleName}} - ' . $id);
			return Redirect::route('{{pluralName}}.index');
		}

		$input = Input::all();
		${{singleName}}->fill($input);

		if (${{singleName}}->save()) {
			Session::flash('success', '{{SingleName}} updated successfully!');
			return Redirect::route('{{pluralName}}.index');
		} else {
			Session::flash('error', 'Something went wrong...');
			return Redirect::route('{{pluralName}}.edit', $id)->withInput();
		}
	}

	/**
	 * Remove the specified {{singleName}} from storage.
	 * 
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (!${{singleName}} = {{SingleName}}::find($id)) {
			Session::flash('error', 'Could not find {{singleName}} - ' . $id);
			return Redirect::route('{{pluralName}}.index');
		}

		{{SingleName}}::destroy($id);
		Session::flash('success', '{{SingleName}} deleted!');
		return Redirect::route('{{pluralName}}.index');
	}
}