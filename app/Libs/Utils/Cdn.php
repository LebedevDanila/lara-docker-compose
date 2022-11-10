<?php

namespace App\Libs\Utils;

use Aws\S3\S3Client;

class Cdn
{
    public function __construct()
    {
        $this->client = new S3Client(
            [
                'version'                 => 'latest',
                'region'                  => config('constants.cdn.region'),
                'use_path_style_endpoint' => true,
                'credentials'             => [
                    'key'    => config('constants.cdn.key'),
                    'secret' => config('constants.cdn.secret'),
                ],
                'endpoint'                => config('constants.cdn.endpoint'),
            ]
        );
    }

    public function put($name = '', $data = '')
    {
        return $this->client->putObject([
            'Bucket' => config('constants.cdn.bucket'),
            'Key'    => $name,
            'Body'   => $data
        ]);
    }

}
