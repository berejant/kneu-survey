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

        DB::statement('ALTER TABLE `answers`   AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE `questions` AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE `question_choice_options` AUTO_INCREMENT = 1;');

        Question::create([
            'text' => 'Ваша оцінка рівня якості організації та проведення занять викладачем',
            'type' => 'choice',

        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Висока' ]),
            new QuestionChoiceOption([ 'text' => 'Задовільна' ]),
            new QuestionChoiceOption([ 'text' => 'Погана' ]),
            new QuestionChoiceOption([ 'text' => 'Утримуюсь від відповіді' ]),
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
            'text' => 'Чи оголошував викладач критерії отримання балів за картою СРС на початку курсу?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Так' ]),
            new QuestionChoiceOption([ 'text' => 'Ні' ]),
            new QuestionChoiceOption([ 'text' => 'Я не знаю, що таке карта СРС' ]),
        ]);


        Question::create([
            'text' => 'Наскільки зміст занять відповідав навчально-методичним матеріалам курсу?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Повністю відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'У цілому відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Частково відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Не відповідав' ]),
            new QuestionChoiceOption([ 'text' => 'Не можу відповісти' ]),
        ]);


        Question::create([
            'text' => 'Кількість скасованих занять, не відпрацьованих в інший час.',
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
            new QuestionChoiceOption([ 'text' => 'Завжди вчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Зазвичай вчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Зазвичай невчасно' ]),
            new QuestionChoiceOption([ 'text' => 'Завджи невчасно' ]),
        ]);

        Question::create([
            'text' => 'Чи проводив викладач консультації в позааудиторний час?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Проводив' ]),
            new QuestionChoiceOption([ 'text' => 'Не проводив' ]),
            new QuestionChoiceOption([ 'text' => 'Не знаю або не було потреби в консультаціях' ]),
        ]);

        Question::create([
            'text' => 'До якої частини занять, на Вашу думку, викладач не був підготовлений?',
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
            'text' => 'Як часто викладач оголошував план заняття та підбивав підсумки?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Майже завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Інколи' ]),
            new QuestionChoiceOption([ 'text' => 'Ніколи' ]),
            new QuestionChoiceOption([ 'text' => 'Мені нецікава тема і план заняття' ]),
        ]);

        Question::create([
            'text' => 'Як часто роз\'яснення викладача змісту матеріалу були зрозумілими?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Майже завжди' ]),
            new QuestionChoiceOption([ 'text' => 'Інколи' ]),
            new QuestionChoiceOption([ 'text' => 'Ні, ніколи' ]),
            new QuestionChoiceOption([ 'text' => 'Я не потребую додаткових пояснень викладача' ]),
        ]);


        Question::create([
            'text' => 'На Ваш погляд, кількість самостійних завдань курсу є достатньою?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Ні, недостаньою' ]),
            new QuestionChoiceOption([ 'text' => 'Так, цілком достатньою' ]),
            new QuestionChoiceOption([ 'text' => 'Є надмірною' ]),
            new QuestionChoiceOption([ 'text' => 'Як на мене - краще взагалі без них' ]),
        ]);

        Question::create([
            'text' => 'Яку кількість занять ви пропустили з цього предмету?',
            'type' => 'choice',
        ])->choiceOptions()->saveMany([
            new QuestionChoiceOption([ 'text' => 'Жодного' ]),
            new QuestionChoiceOption([ 'text' => 'Одне або два заняття' ]),
            new QuestionChoiceOption([ 'text' => 'Від трьох до п\'яти занять' ]),
            new QuestionChoiceOption([ 'text' => 'П\'ять та більше занять' ]),
        ]);

        Question::create([
            'text' => 'Ваш коментар',
            'type' => 'text',
        ]);

    }

}
