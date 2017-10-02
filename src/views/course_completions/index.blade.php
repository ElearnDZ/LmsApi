
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Emp No.</th>
      <th>course</th>
      <th>course code</th>
      <th>status</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Score</th>
      <th>Issued Certificate</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($course_completions as $course_completion)
    <tr>
      <td>{{$course_completion->user->firstname}} {{$course_completion->user->lastname}}</td>
      <td>{{\Library\StringLibrary::removeLoginPrefix($course_completion->user->login)}}</td>
      <td>{{$course_completion->course->course_name}}</td>
      <td>{{$course_completion->course->course_code}}</td>
      <td>{{$course_completion->status}}</td>
      <td>{{$course_completion->from_timestamp->toDateString()}}</td>
      @if($course_completion->to_timestamp)
      <td>{{$course_completion->to_timestamp->toDateString()}}</td>
      @else
      <td>-</td>
      @endif
      <td>{{$course_completion->score}}</td>
      <td>{{$course_completion->issued_certificate}}</td>
      <td>
        <a href="{{url('lms/course/completions/view/'.$course_completion->id)}}"> View </a>
        <a href="{{url('lms/course/completions/edit/'.$course_completion->id)}}"> Edit </a>
        <a href="{{url('lms/course/completions/delete/'.$course_completion->id)}}"> Delete </a>

      </td>
    </tr>
    @endforeach
  </tbody>
</table>
