@extends('base')
@section('content')
<form class="" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  Select Course Completions Csv to upload:
  <input type="file" name="csv" id="fileToUpload">
  <input type="submit" value="Upload Completions">
</form>
@endsection
