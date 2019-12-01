<?php


namespace App\Services\Sms;

use Nexmo\Laravel\Facade\Nexmo;


class SmsRu implements SmsSender
{

    public function send($number, $text): void
    {
        Nexmo::message()->send([
            'to'   => '3'.$number,
            'from' => 'Laravel_Project',
            'text' => $text
        ]);
    }
}