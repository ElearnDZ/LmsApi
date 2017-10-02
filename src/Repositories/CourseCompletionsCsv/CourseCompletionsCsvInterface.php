<?php namespace LmsApi\Repositories\CourseCompletionsCsv;
use LmsApi\Requests\CourseCompletionsCsv;

interface CourseCompletionsCsvInterface
{
  public function create();
  public function store(CourseCompletionsCsv\StoreRequest $request);
  public function download();
}
