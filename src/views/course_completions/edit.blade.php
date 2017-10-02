<form action="{{Request::url()}}" method="post">
	<input type="hidden" name="_token" value="{{csrf_token()}}">

	<select class="" name="user_id">
		<option value="">--Select User--</option>
		@foreach($users as $user)
		<option value="{{$user->id}}"
			@if($user->id === $course_completion->user_id)
			selected
			@endif
			>{{$user->login}}</option>
			@endforeach
	</select>

	<select class="" name="course_id">
		<option value="">--Select Course--</option>
		@foreach($courses as $course)
		<option value="{{$course->id}}"
			@if($course->id === $course_completion->course_id)
			selected
			@endif
			>{{$course->course_name}}</option>
			@endforeach
	</select>

  	<input type="number" name="score" value="{{$course_completion->score}}" min="0" max="100" placeholder="Score">

  	<select class="" name="status">
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

  	<input type="text" name="issued_certificate" value="{{$course_completion->issued_certificate}}">

	<input type="datetime" name="from_timestamp" value="{{$course_completion->from_timestamp}}">
	<input type="datetime" name="to_timestamp" value="{{$course_completion->to_timestamp}}">

    <input type="submit" name="" class="btn" value="Submit">

</form>