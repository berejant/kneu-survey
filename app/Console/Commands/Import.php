<?php namespace Kneu\Survey\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\Student;
use Kneu\Survey\Teacher;

class Import extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импортировать данные из приложения "Електронный журнал КНЭУ.';

    /**
     * @var \GuzzleHttp\Client
     */

    protected $client;

    /**
     * @var \Carbon\Carbon
     */
    protected $startDatetime;

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        $this->client = new \GuzzleHttp\Client([
            'verify' => true,
            'connect_timeout' => 5,
            'timeout' => 15,
            'base_uri' => Config::get('journalApi.url'),
            'auth' => [
                Config::get('journalApi.login'),
                Config::get('journalApi.password')
            ],
        ]);

        $this->startDatetime = Carbon::now();

        DB::transaction(function () {
            $this->importTeachers();
            $this->importStudents();
        });

    }

    protected function importTeachers()
    {
        $this->info('Import teachers start...');

        $response = $this->client->get('teachers.json');

        foreach (json_decode($response->getBody(), true) as $item) {
            /** @var Teacher $teacher */
            $teacher = Teacher::withTrashed()->find($item['id']);
            if (!$teacher) {
                $teacher = new Teacher;
            }

            $teacher->fill($item);
            if (starts_with($teacher->photo, 'http://')) {
                $teacher->photo = substr($teacher->photo, 5);
            }
            $teacher->trashed() ? $teacher->restore() : $teacher->touch();
        }

        Teacher::where('updated_at', '<', $this->startDatetime)->delete();

        $this->info('Import teachers complete.');
    }

    protected function importStudents()
    {
        $this->info('Import students start...');

        $response = $this->client->get('students.json');

        $answer = json_decode($response->getBody(), true);

        $academicYear = $answer['academic_year'];
        $semester = $answer['semester'];

        foreach ($answer['students'] as $item) {
            /** @var Student $student */
            $student = Student::findOrNew($item['id']);
            $student->id = $item['id'];
            $student->save();

            foreach ($item['teachers'] as $teacherId) {
                Questionnaire::firstOrCreate([
                    'academic_year' => $academicYear,
                    'semester' => $semester,
                    'student_id' => $student->id,
                    'teacher_id' => $teacherId,
                ]);
            }
        }

        $this->info('Import students complete.');
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
