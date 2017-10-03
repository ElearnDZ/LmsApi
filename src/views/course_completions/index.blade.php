@extends('base')
@section('title')
  LmsApi - Index
@stop
@section('content')
<div class="content-header">
  <div class="title">
    <h1>List Of Course Completions</h1>
  </div>
  <a href="/lms/course/completions/create">
    <button type="button" class="primary">Create Course</button>
  </a>
</div> 
@if(count($course_completions) > 0) 
<table class="table striped bordered datatable">
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
      <td class="actions icons">
        @if(Auth::user()->hasUrlAccess('lms/course/completions/view/*'))
        <a href="{{url('lms/course/completions/view/'.$course_completion->id)}}"> 
          <button type="button" class="dark"><i class="fa fa-eye"></i></button> 
        </a>
        @else
          <a href="#">
          <button type="button" disabled="disabled">
            <i class="fa fa-eye"></i>
          </button>
          </a>
        @endif

        @if(Auth::user()->hasUrlAccess('lms/course/completions/edit/*'))
        <a href="{{url('lms/course/completions/edit/'.$course_completion->id)}}"> 
          <button type="button" class="dull"><i class="fa fa-pencil"></i></button> 
        </a>
        @else
          <a href="#">
          <button type="button" disabled="disabled">
            <i class="fa fa-pencil"></i>
          </button>
          </a>
        @endif

        @if(Auth::user()->hasUrlAccess('lms/course/completions/delete/*'))
        <a href="{{url('lms/course/completions/delete/'.$course_completion->id)}}"> 
          <button type="button" class="dark"><i class="fa fa-trash"></i></button> 
        </a>
        @else
          <a href="#">
          <button type="button" disabled="disabled">
            <i class="fa fa-trash"></i>
          </button>
          </a>
        @endif

      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
  <h4>No Course Completions Found</h4>
@endif
@stop

@section('customScripts')
<!-- Datatable Export Buttons -->
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<script type="text/javascript">
 $(function(){
    $('.datatable').dataTable({
    //  "paging":false,
    //  "info" : false
    dom: "<'top-row'<'length'l><'buttons'B><'filter'f>><'middle-row'<'col-sm-12'tr>><'bottom-row'<'info'i><'pagination'p>>",
    order: [],
    columnDefs: [
      { orderable: false, targets: ['no-sort']},
      // { visible:false,targets:[6,8]},
      // { orderData:[6],targets:[5]},
      // { orderData:[8],targets:[7]},
    ],
    buttons: [
              {
                extend : 'excelHtml5',
                exportOptions: {
                      columns: [ 0,1,2,3,4,5,6,7,8]
                }
              },
              {
                extend : 'csvHtml5',
                exportOptions: {
                      columns: [ 0,1,2,3,4,5,6,7,8]
                }
              }

          ]

    });
 });
 </script>
@stop

