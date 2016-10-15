<?php

try {
    ($immutable = Dotenv::isImmutable()) && Dotenv::makeMutable(); // разрешаем перезапись ENV
    Dotenv::load($app->basePath(), '.academic.env');
    $immutable && Dotenv::makeImmutable();
} catch (\InvalidArgumentException $e) {
    // если файла нет - то это не проблема.
}

return [
    'year' => (int)env('ACADEMIC_YEAR'),
    'semester' => (int)env('ACADEMIC_SEMESTER'),
];
