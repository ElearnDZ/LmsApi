<?php namespace LmsApi\Repositories\CourseApi;
use LmsApi\Requests\CourseApi;

interface CourseApiInterface
{
  public function getAll();
  public function update(CourseApi\UpdateRequest $request);
}
