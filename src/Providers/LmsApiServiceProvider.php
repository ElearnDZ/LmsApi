<?php namespace LmsApi\Providers;

use Illuminate\Support\ServiceProvider;

class LmsApiServiceProvider extends ServiceProvider
{
  /**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			dirname(__DIR__).'/Config/lmsapi.php' => config_path('lmsapi.php'),
			dirname(__DIR__).'/views' => base_path('resources/views/vendor/LmsApi'),
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		include dirname(__DIR__).'/routes.php';
		$this->app->bind
		(
			'LmsApi\Repositories\UserApi\UserApiInterface',
			'LmsApi\Repositories\UserApi\UserApiRepository'
		);

		$this->app->bind
		(
			'LmsApi\Repositories\CourseApi\CourseApiInterface',
			'LmsApi\Repositories\CourseApi\CourseApiRepository'
		);

		$this->app->bind
		(
			'LmsApi\Repositories\CourseCompletionsApi\CourseCompletionsApiInterface',
			'LmsApi\Repositories\CourseCompletionsApi\CourseCompletionsApiRepository'
		);

		$this->app->bind
		(
			'LmsApi\Repositories\CourseCompletionsCsv\CourseCompletionsCsvInterface',
			'LmsApi\Repositories\CourseCompletionsCsv\CourseCompletionsCsvRepository'
		);

		$this->app->bind
		(
			'LmsApi\Repositories\CourseCompletions\CourseCompletionsInterface',
			'LmsApi\Repositories\CourseCompletions\CourseCompletionsRepository'
		);
	}


}
