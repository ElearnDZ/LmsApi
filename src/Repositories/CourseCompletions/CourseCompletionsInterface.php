<?php namespace LmsApi\Repositories\CourseCompletions;

use LmsApi\Requests\CourseCompletions;

interface CourseCompletionsInterface
{
  public function index();
  public function create();
  public function show($id);
  public function store(CourseCompletions\StoreRequest $request);
  public function edit($id);
  public function update(CourseCompletions\UpdateRequest $request,$id);
  public function destroy($id);
}
