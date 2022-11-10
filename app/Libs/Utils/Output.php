<?php

namespace App\Libs\Utils;

use Illuminate\Support\Facades\Response;

class Output
{
    /**
     * @var string[]
     */
    private static $errors = [
        10  => 'Такого метода api не существует.',
        11  => 'Один из необходимых параметров был не передан или неверен.',
        12  => 'Ошибка выполнения кода.',
        13  => 'Ошибка записи в базу данных.',
        14  => 'Не удалось загрузить изображение',
        21  => 'Такого email не существует.',
        22  => 'Не валидный номер телефона.',
        23  => 'Не допустимое значение поля. Возможно строка большая или маленькая для записи в Базу данных',
        24  => 'Нельзя обновить данные.',
        25  => 'Короткий пароль.',
        31  => 'Такой пользователь уже существует.',
        400 => 'Неверный запрос.',
        401 => 'Неавторизованный запрос.',
        402 => 'Ошибка авторизации.',
        403 => 'Не хватает прав доступа.',
        404 => 'Ответ пуст.',
        405 => 'Ошибка проверки CSRF.',
        406 => 'Срок сессии истек.',
        407 => 'Пользователя не существует.',
        408 => 'Запрос уже был выполнен.',
        409 => 'Дубликация записей. Такая запись уже существует.',
        500 => 'Внутренняя ошибка сервера.',
        601 => 'Пользователь не может поставить лайк на свою запись.',
        602 => 'Нельзя сделать подписку на себя.',
        603 => 'Вы уже подписались на данного пользователя.',
        604 => 'Слишком мало символов для краткого описания, введите больше 20 символов',
        605 => 'Слишком мало символов для основного текста, введите больше 50 символов',
        606 => 'Слишком много символов для краткого описания, введите меньше 255 символов',
        701 => 'Произошла ошибка при парсинге, возможно ошибка прокси',
    ];

    public static function error($error_id = 1, $params = [])
    {
        $resp = [
            'status' => false,
            'error'  => [
                'code'    => $error_id,
                'message' => (empty(self::$errors[$error_id]) ? null : self::$errors[$error_id]),
                'params'  => $params
            ],
        ];

        return self::out($resp);
    }

    public static function responseError($error_id = 1)
    {
        $resp = [
            'status' => false,
            'error'  => [
                'code'    => $error_id,
                'message' => (empty(self::$errors[$error_id]) ? null : self::$errors[$error_id]),
            ],
        ];

        return self::out($resp, true);
    }

    public static function response($data = [])
    {
        $time = microtime(true);
        $resp = [
            'status'   => true,
            'response' => [
                'data'      => $data,
                'microtime' => $time,
            ],
        ];

        return self::out($resp);
    }

    public static function responseSuccess($data = [])
    {
        $time = microtime(true);
        $resp = [
            'status'   => true,
            'response' => [
                'data'      => $data,
                'microtime' => $time,
            ],
        ];

        return self::out($resp, true);
    }

    public static function collection($data = [])
    {
        return self::out($data);
    }

    private static function out($resp = [], $is_json = false)
    {
        $resp = json_encode($resp);
        if ( ! $is_json) {
            $resp = json_decode($resp, true);
        }

        return $resp;
    }

}
