<?php namespace LmsApi\Repositories\CourseCompletionsApi;
use LmsApi\Requests\CourseCompletionsApi;

interface CourseCompletionsApiInterface
{
  public function getAll();
  public function update(CourseCompletionsApi\UpdateRequest $request);
}
