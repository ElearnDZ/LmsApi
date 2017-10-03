@extends('base')
@section('title')
 Edit Course Completion
@stop
@section('content')
   <div class="content-header">
    <div class="title">
      <h1>Edit Course Completion</h1>
    </div>
    <a href="/lms/course/completions"><button type="button" class="primary">Back</button></a>
   </div>

<form action="{{Request::url()}}" method="post">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

<div class="select">
	<label>User Id</label>
	<select class="cstm-select" name="user_id">
		<option value="">--Select User--</option>
		@foreach($users as $user)
		<option value="{{$user->id}}"
			@if($user->id === $course_completion->user_id)
			selected
			@endif
			>{{$user->login}}</option>
			@endforeach
	</select>
</div>

<div class="select">
	<label>Course Id</label>
	<select class="cstm-select" name="course_id">
		<option value="">--Select Course--</option>
		@foreach($courses as $course)
		<option value="{{$course->id}}"
			@if($course->id === $course_completion->course_id)
			selected
			@endif
			>{{$course->course_name}}</option>
			@endforeach
	</select>
</div>

<div>
	<label>Score</label>
  	<input type="number" name="score" value="{{$course_completion->score}}" min="0" max="100" placeholder="Score">
</div>

<div class="select">
	<label>Status</label>
  	<select class="cstm-select" name="status">
    <option value="incomplete">InComplete</option>
  		<option value="">--select status--</option>
	    <option value="completed"
	    @if($course_completion->status === 'completed')
	    selected
	    @endif
	    >Completed</option>
	    <option value="incomplete"
	    @if($course_completion->status === 'incomplete')
	    selected
	    @endif
	    >InComplete</option>
  	</select>
</div>

<div>
	<label>Issued Certificate</label>
  	<input type="text" name="issued_certificate" value="{{$course_completion->issued_certificate}}">
</div>

<div>
	<label>Start Date</label>
	<input type="datetime" name="from_timestamp" value="{{$course_completion->from_timestamp}}">
</div>

<div>
	<label>End Date</label>
	<input type="datetime" name="to_timestamp" value="{{$course_completion->to_timestamp}}">
</div>

    <!-- <input type="submit" name="" class="btn" value="Submit"> -->
<div> 
    <button type="submit" class="primary">Save</button>
</div>

</form>
@stop

@section('customScripts')
<script src="/js/vendor/datepicker.min.js"></script>
<script src="/js/vendor/Audit/level.js"></script>

<script type="text/javascript">
$(function(){
  $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide:true
    });
})
</script>
@stop