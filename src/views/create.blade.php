@extends('base')
@section('content')
@if (count($errors) > 0)
  <div class="alert alert-success">    
    <?php $stats = $errors->toArray(); ?>
    <ul>
       <li>Inserted Course Completions ::{{$stats['course_completions_created'][0]}}</li>
       @foreach($stats['errors'] as $error)
       <li>{{$error}}</li>
       @endforeach
    </ul>
  </div>
@endif
<form class="" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  Select Course Completions Csv to upload:
  <input type="file" name="csv" id="fileToUpload">
  <input type="submit" value="Upload Completions">
</form>
@endsection
