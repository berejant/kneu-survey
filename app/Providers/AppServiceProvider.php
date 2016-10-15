<?php namespace Kneu\Survey\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('JournalApiClient', function ($app) {
            return new \GuzzleHttp\Client([
                'verify' => true,
                'connect_timeout' => 5,
                'timeout' => 15,
                'base_uri' => Config::get('journalApi.url'),
                'auth' => [
                    Config::get('journalApi.login'),
                    Config::get('journalApi.password')
                ],
                'form_params' => [
                    'year' => config('academic.year'),
                    'semester' => config('academic.semester'),
                ],
            ]);
        });
	}

}
