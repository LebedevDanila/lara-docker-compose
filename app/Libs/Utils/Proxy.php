<?php

namespace App\Libs\Utils;

class Proxy
{
    public static function get($type = 'foreign')
    {
        $data = self::getList();

        $resp = $data[$type];
        shuffle($resp);

        return $resp[0];
    }

    private static function getList(): array
    {
        $data = [
          'foreign'  => [
              ['ip' => '95.78.126.103:17074', 'login' => '26nzapca', 'password' => '59m2zz2y'],
              ['ip' => '95.78.126.103:13413', 'login' => '26nzapca', 'password' => '59m2zz2y'],
          ],
        ];
        return $data;
    }

}
