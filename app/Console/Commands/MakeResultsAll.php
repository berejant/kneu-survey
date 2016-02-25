<?php namespace Kneu\Survey\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Kneu\Survey\Commands\MakeResults;
use Kneu\Survey\Teacher;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeResultsAll extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:results:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерирует результаты опроса для текущего семестра.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $startTime = microtime(true);

        $academicYear = config('academic.year');
        $academicSemester = config('academic.semester');

        $teachers = Teacher::all();
        $teachersCount = count($teachers);

        /** @var Teacher $teacher */
        foreach ($teachers as $index => $teacher) {
            $this->info(sprintf(
                'Make result for %s %s (%d/%d)',
                $teacher->first_name, $teacher->last_name,
                $index + 1, $teachersCount
            ));

            Bus::dispatch(new MakeResults($academicYear, $academicSemester, $teacher));
        }

        $totalTime = microtime(true) - $startTime;
        $this->info(sprintf('Done. %f secs.', $totalTime));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
