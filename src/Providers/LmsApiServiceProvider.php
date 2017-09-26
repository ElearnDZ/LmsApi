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
	}


}
