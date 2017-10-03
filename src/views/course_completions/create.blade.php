@extends('base')
@section('title')
 Create Course Completion
@stop
@section('styleSheets')
  <link rel="stylesheet" type="text/css" href="/css/vendor/ProjectManagement/datepicker.min.css">
@stop
@section('content')
   <div class="content-header">
    <div class="title">
      <h1>Add Course Completion</h1>
    </div>
    <a href="/lms/course/completions"><button type="button" class="primary">Back</button></a>
   </div>

<form class="" action="{{Request::url()}}" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">

<div class="select">
  <label>User Id</label>
  <select class="cstm-select" name="user_id" required="required">
    <option value="">--select User--</option>
    @foreach($users as $user)
    <option value="{{$user->id}}">{{$user->login}}</option>
    @endforeach
  </select>
</div>

<div class="select">
  <label>Course Id</label>
  <select class="cstm-select" name="course_id" required="required">
    <option value="">--select course--</option>
    @foreach($courses as $course)
    <option value="{{$course->id}}">{{$course->course_name}}</option>
    @endforeach
  </select>
</div>

<div>
  <label>Score</label>
  <input type="number" name="score" value="" min="0" max="100" placeholder="Score" required="required">
</div>

<div class="select">
  <label>Status</label>
  <select class="cstm-select" name="status" required="required">
    <option value="">--select status--</option>
    <option value="completed">Completed</option>
    <option value="incomplete">InComplete</option>
  </select>
</div>

<div>
  <label>Issued Certificate</label>
  <input type="text" name="issued_certificate" value="" placeholder="Issued Certificate" required="required">
</div>

<div>
  <label>Start Date</label>
  <input type="datetime" name="from_timestamp" value="" placeholder="Course Start Date Time" required="required">
</div>

<div class="date">
  <label>End Date</label>
  <input type="datetime" name="to_timestamp" value="" placeholder="Course End Date Time" required="required">
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