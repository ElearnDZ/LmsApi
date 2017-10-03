@extends('base')
@section('title')
	View Course Completion
@stop
@section('content')
	<div class="content-header">
	    <div class="title">
	      <h1>View Course Completion</h1>
	    </div>
	    <a href="/lms/course/completions">
	    	<button type="button" class="primary">Back</button>
	    </a>
	</div>
	<table class="striped two-col bordered">
		<tr>
			<td>Username</td>
			<td>
				{{$course_completion->user->firstname}} {{$course_completion->user->lastname}}
			</td>
		</tr>
		<tr>
			<td>Course Name</td>
			<td>{{$course_completion->course->course_name}}</td>
		</tr>
		<tr>
			<td>Score</td>
			<td>{{$course_completion->score}}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>{{$course_completion->status}}</td>
		</tr>
		<tr>
			<td>Issued Certificate</td>
			<td>{{$course_completion->issued_certificate}}</td>
		</tr>
		<tr>
			<td>Start Date</td>
			<td>{{$course_completion->from_timestamp}}</td>
		</tr>
		<tr>
			<td>End Date</td>
			<td>{{$course_completion->to_timestamp}}</td>
		</tr>
	</table>
@endsection
