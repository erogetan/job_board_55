@extends ('layout')

@section('title')

Edit Job

@stop


@section ('content')

<form action="{{ url('/update') }}" method="POST">

{!! csrf_field() !!}

	<input type="hidden" name="job_id" value="{{ $job->id }}{{ old('job_id') }}">



	<div class = "form-group">
		<input required= "required"  placeholder="Enter title here " type = "text" name="title" class="form-control" 
		value= "@if(!old('title')) {{ $job->title }} @endif {{ old('title') }}">
	</div>

	<div class="form-group">

		<textarea name="body" class="form-control"> {{ old('body') }}
		@if(!old('body'))
		{{ $job->body }}
		@endif
		{{ old('body') }}</textarea>

	</div>

	@if($job->active == 1)

	<input type="submit" name="publish" class="btn btn-success" value="Update">

	@else
	<input type="submit" name="publish" class="btn btn-success" value="Publish">
	@endif

	<input type="submit" name="save" class="btn btn-default" value="Save Draft">
	<a href="{{ url('delete/' . $job->id .'?_token='.csrf_token()) }}" class = "btn btn-danger"> DELETE </a>


</form>

@stop