@extends ('layout')

@section('title')

Add New JOB

@stop


@section ('content')

<form action="/new-job" method="POST">

{!! csrf_field() !!}

	<div class = "form-group">
		<input required= "required" value = "{{old('title') }}" placeholder="Enter title here " type = "text" name="title" class="form-control">
	</div>

	<div class="form-group">

		<textarea name="body" class="form-control"> {{ old('body') }}</textarea>

	</div>


	<input type="submit" name="publish" class="btn btn-success" value="Publish">

	<input type="submit" name="save" class="btn btn-default" value="Save Draft">


</form>

@stop