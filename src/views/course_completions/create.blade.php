<form class="" action="{{Request::url()}}" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">

  <select class="" name="user_id">
    <option value="">--select User--</option>
    @foreach($users as $user)
    <option value="{{$user->id}}">{{$user->login}}</option>
    @endforeach
  </select>

  <select class="" name="course_id">
    <option value="">--select course--</option>
    @foreach($courses as $course)
    <option value="{{$course->id}}">{{$course->course_name}}</option>
    @endforeach
  </select>

  <input type="number" name="score" value="" min="0" max="100" placeholder="Score">

  <select class="" name="status">
    <option value="">--select status--</option>
    <option value="completed">Completed</option>
    <option value="incomplete">InComplete</option>
  </select>

  <input type="text" name="issued_certificate" value="" placeholder="Issued Certificate">

  <input type="datetime" name="from_timestamp" value="" placeholder="Course Start Date Time">
  <input type="datetime" name="to_timestamp" value="" placeholder="Course End Date Time">

  <input type="submit" name="" class="btn" value="Submit">
</form>
