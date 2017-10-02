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
			dirname(__DIR__).'/templates' => public_path('uploads/LMS/')
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
	}


}
