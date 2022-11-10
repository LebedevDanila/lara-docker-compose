<?php
namespace App\Libs\Utils;

use \App\Libs\Utils\Curl;

class Email
{

    public function __construct()
    {
        $this->token = 'zy9expo5a042snr6fc7iq38kjhmbwqfmy2tcdw6gebgw4b4k6pqrhcxw8vo5f3sc';
    }

    public function send($data = [])
    {
        $to_array = [];
        foreach ($data['to'] as $row) {
            $to_array[]['email'] = $row;
        }

        $data = [
            'from'         => [
                'email' => (empty($data['from']['email']) ? 'support@znarium.com' : $data['from']['email']),
                'name'  => (empty($data['from']['name']) ? 'ZNARIUM.COM' : $data['from']['name']),
            ],
            'to'           => $to_array,
            'subject'      => $data['subject'],
            'body'         => (array)$data['body'],
            'headers'      => ['reply_to' => (empty($data['reply_to']) ? '' : $data['reply_to'])],
            'attachments'  => (empty($data['attachments']) ? [] : $data['attachments']),
            'access_token' => $this->token,
        ];

        $resp = (new Curl)->send('https://api.kibers.com/email.send.json', $data, [], '', '');

        return $resp;
    }
}
