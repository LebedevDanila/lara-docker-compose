<?php

namespace App\Helpers;


class GeneralHelper
{
    public static function generateHash($count = 50, $separator = '-'): string
    {
        $k = sha1(microtime());
        for ($i = 0; $i < 40; $i++) {
            $f[] = substr($k, $i, $i + 1);
        }
        shuffle($f);
        $t = '';
        foreach ($f as $k => $row) {
            if ($k < 11) {
                $t .= $row . $separator;
            }
        }
        $result = substr($t, 0, $count);
        if (substr($result, -1) === $separator) {
            $result = substr($result, 0, -1) . '7';
        }

        return $result;
    }

    public static function generateHashLink($count = 6): string
    {
        $arr = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            'A',
            'B',
            'C',
            'D',
            'E',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'F',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '0',
        ];
        $url = '';
        for ($i = 0; $i < $count; $i++) {
            $random = rand(0, count($arr) - 1);
            $url    .= $arr[$random];
        }

        return $url;
    }

    public static function getTranslitLink($s)
    {
        $s = (string) $s;
        $s = strip_tags($s);
        $s = str_replace(["\n", "\r"], ' ', $s);
        $s = preg_replace('/\s+/', ' ', $s);
        $s = trim($s);
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
        $s = strtr($s, ['??' => 'a', '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'e', '??' => 'j', '??' => 'z', '??' => 'i', '??' => 'y', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c', '??' => 'ch', '??' => 'sh', '??' => 'shch', '??' => 'y', '??' => 'e', '??' => 'yu', '??' => 'ya', '??' => '', '??' => '']);
        $s = preg_replace('/[^0-9a-z-_ ]/i', '', $s);
        $s = str_replace(' ', '-', $s);
        $s = str_replace('----', '-', $s);
        $s = str_replace('---', '-', $s);
        $s = str_replace('--', '-', $s);
        return $s;
    }

    public static function getTranslit($s, $separator = '_'): string
    {
        $s = (string)$s;
        $s = strip_tags($s);
        $s = str_replace(["\n", "\r"], $separator, $s);
        $s = preg_replace('/\s+/', $separator, $s);
        $s = trim($s);
        $s = strtr($s,
                   [
                       '??' => 'a',
                       '??' => 'b',
                       '??' => 'v',
                       '??' => 'g',
                       '??' => 'd',
                       '??' => 'e',
                       '??' => 'e',
                       '??' => 'j',
                       '??' => 'z',
                       '??' => 'i',
                       '??' => 'y',
                       '??' => 'k',
                       '??' => 'l',
                       '??' => 'm',
                       '??' => 'n',
                       '??' => 'o',
                       '??' => 'p',
                       '??' => 'r',
                       '??' => 's',
                       '??' => 't',
                       '??' => 'u',
                       '??' => 'f',
                       '??' => 'h',
                       '??' => 'c',
                       '??' => 'ch',
                       '??' => 'sh',
                       '??' => 'shch',
                       '??' => 'y',
                       '??' => 'e',
                       '??' => 'yu',
                       '??' => 'ya',
                       '??' => '',
                       '??' => '',
                       '??' => 'A',
                       '??' => 'B',
                       '??' => 'V',
                       '??' => 'G',
                       '??' => 'D',
                       '??' => 'E',
                       '??' => 'E',
                       '??' => 'J',
                       '??' => 'Z',
                       '??' => 'I',
                       '??' => 'Y',
                       '??' => 'K',
                       '??' => 'L',
                       '??' => 'M',
                       '??' => 'N',
                       '??' => 'O',
                       '??' => 'P',
                       '??' => 'R',
                       '??' => 'S',
                       '??' => 'T',
                       '??' => 'U',
                       '??' => 'F',
                       '??' => 'H',
                       '??' => 'C',
                       '??' => 'Ch',
                       '??' => 'Sh',
                       '??' => 'Shch',
                       '??' => 'Y',
                       '??' => 'E',
                       '??' => 'Yu',
                       '??' => 'Ya',
                   ]
        );
        $s = preg_replace('/[^0-9a-z-_ ]/i', '', $s);
        $s = str_replace(' ', '-', $s);
        $s = str_replace('----', '-', $s);
        $s = str_replace('---', '-', $s);
        $s = str_replace('--', '-', $s);

        return $s;
    }

    public static function createPassword(): string
    {
        $array_1 = [
            'a',
            'e',
            'o',
            'u',
            'i',
        ];
        $array_2 = [
            'b',
            'c',
            'd',
            'f',
            'g',
            'h',
            'j',
            'k',
            'l',
            'm',
            'n',
            'p',
            'q',
            'r',
            's',
            't',
            'v',
            'w',
            'x',
            'y',
            'z',
        ];

        $text = '';
        for ($i = 0; $i < 6; $i++) {
            shuffle($array_1);
            shuffle($array_2);
            if ($i % 2 === 0) {
                $text .= $array_2[0];
            } else {
                $text .= $array_1[0];
            }
        }
        $text .= mt_rand(10, 99);

        return ucfirst($text);
    }

    public static function ucfirst($string, $encoding = 'UTF-8'): string
    {
        $first = mb_substr($string, 0, 1, $encoding);
        $then  = mb_substr($string, 1, mb_strlen($string, $encoding) - 1, $encoding);

        return mb_strtoupper($first, $encoding) . $then;
    }

}
