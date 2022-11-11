<?php

namespace App\Libs\Utils;

use Illuminate\Support\Facades\Response;

class Output
{

    private static $errors = [
        101 => 'Не верное тело запроса.',
        102 => 'Запись уже существует.',
        400 => 'Плохой запрос.',
        404 => 'Ответ пуст.',
        409 => 'Ошибка загрузки контента.',
    ];

    public static function error($error_id = 1)
    {
        $return = [
            'error'  => [
                'code' => $error_id,
                'text' => (empty(self::$errors[$error_id]) ? null : self::$errors[$error_id]),
            ],
        ];

        return self::out($return);
    }

    public static function responseError($error_id = 1)
    {
        $return = [
            'error'  => [
                'code' => $error_id,
                'text' => (empty(self::$errors[$error_id]) ? null : self::$errors[$error_id]),
            ],
        ];

        return self::out($return, true);
    }

    public static function response($data = [])
    {
        $return = [
            'data' => $data,
        ];

        return self::out($return);
    }

    public static function responseSuccess($data = [])
    {
        $return = [
            'data' => $data,
        ];

        return self::out($return, true);
    }

    public static function collection($data = [])
    {
        return self::out($data);
    }

    private static function out($data = [], $is_json = false)
    {
        $data = json_encode($data);
        if ( ! $is_json) {
            $data = json_decode($data, true);
        }

        return $data;
    }

}
