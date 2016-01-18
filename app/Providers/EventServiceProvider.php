<?php namespace Kneu\Survey\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Kneu\Survey\Questionnaire;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);


		Questionnaire::created(function (Questionnaire $questionnaire) {
			$questionnaire->student->checkIsCompleted($questionnaire->is_completed);
		});

		Questionnaire::updated(function (Questionnaire $questionnaire) {
			$dirty = $questionnaire->getDirty();

			if(isset($dirty['is_completed'])) {
				$questionnaire->student->checkIsCompleted($questionnaire->is_completed);
			}
		});

	}

}
