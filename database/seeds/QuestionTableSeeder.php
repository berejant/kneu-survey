<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Kneu\Survey\Question;
use Kneu\Survey\QuestionChoiceOption;
use Illuminate\Support\Facades\DB;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('question_choice_options')->delete();
        DB::table('questions')->delete();

        Question::create([
            'text' => 'Оцініть рівень якості організації та проведення занять викладачем',
            'type' => 'choice',

        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Високий' ]),
            new QuestionChoiceOption([ 'text' => 'Задовільний' ]),
            new QuestionChoiceOption([ 'text' => 'Поганий' ]),
            new QuestionChoiceOption([ 'text' => 'Мені байдуже' ]),
        ]);


        Question::create([
            'text' => 'Як ставився викладач до студентів?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'З повагою' ]),
            new QuestionChoiceOption([ 'text' => 'З байдужістю' ]),
            new QuestionChoiceOption([ 'text' => 'Зверхньо' ]),
            new QuestionChoiceOption([ 'text' => 'Для мене ставлення викладача не має значення' ]),
        ]);


        Question::create([
            'text' => 'Чи критерії отримання балів за картою СРС були доведені на початку занять?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Так' ]),
            new QuestionChoiceOption([ 'text' => 'Ні' ]),
            new QuestionChoiceOption([ 'text' => 'Я не знаю, що таке карта СРС' ]),
        ]);


        Question::create([
            'text' => 'Наскільки зміст занять відповідав навчально-методичним матеріалам з даного курсу?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Повністю відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'У цілому відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Частково відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Не відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Не можу відповісти' ]),
        ]);


        Question::create([
            'text' => 'Кількість відмінених занять, не відпрацьованих в інший час.',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Жодного' ]),
            new QuestionChoiceOption([ 'text' => 'Одне заняття' ]),
            new QuestionChoiceOption([ 'text' => '2-3 заняття' ]),
            new QuestionChoiceOption([ 'text' => '4 та більше' ]),
        ]);


        Question::create([
            'text' => 'Пунктуальність початку і закінчення занять викладачем.',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Вчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Зазвичай вчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Невчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Чим менше тривалість пари, тим для мене краще' ]),
        ]);

        Question::create([
            'text' => 'Чи проводив викладач консультації в поза аудиторний час?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Проводив' ]),
            new QuestionChoiceOption([ 'text' => 'Не проводив' ]),
            new QuestionChoiceOption([ 'text' => 'Не знаю або не було потреби в консультаціях' ]),
        ]);

        Question::create([
            'text' => 'До якої частини занять, на вашу думку, викладач не був підготовлений?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Завжди був підготовлений' ]),
            new QuestionChoiceOption([ 'text' => 'Майже завжди був підготовлений' ]),
            new QuestionChoiceOption([ 'text' => 'Приблизно у половині занять' ]),
            new QuestionChoiceOption([ 'text' => 'Менше ніж у половині занять' ]),
            new QuestionChoiceOption([ 'text' => 'Ніколи' ]),
            new QuestionChoiceOption([ 'text' => 'Для мене неважливий ступінь підготовки викладача' ]),
        ]);

        Question::create([
            'text' => 'Чи повідомляв викладач на заняттях тему, план заняття, види робіт до виконання та чи підбивав він підсумки роботи?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Майже завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Інколи' ]),
            new QuestionChoiceOption([ 'text' => 'Ніколи' ]),
            new QuestionChoiceOption([ 'text' => 'Мені нецікава тема і план заняття' ]),
        ]);

        Question::create([
            'text' => 'Чи були пояснення викладачем щодо змісту матеріалу зрозумілими?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Майже завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Інколи' ]),
            new QuestionChoiceOption([ 'text' => 'Ні, ніколи' ]),
            new QuestionChoiceOption([ 'text' => 'Я не потребую додаткових пояснень викладача' ]),
        ]);


        Question::create([
            'text' => 'Кількість завдань для самостійного виконання під час вивчення дисципліни',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Дуже мало' ]),
            new QuestionChoiceOption([ 'text' => 'Оптимальна' ]),
            new QuestionChoiceOption([ 'text' => 'Надмірна' ]),
            new QuestionChoiceOption([ 'text' => 'Мені краще взагалі без завдань для самостійного виконання' ]),
        ]);

    }

}
