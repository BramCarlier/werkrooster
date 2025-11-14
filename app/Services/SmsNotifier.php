<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsNotifier
{
    protected Client $client;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        $this->client = new Client($sid, $token);
    }

    public function send(string $to, string $message): void
    {
        $from = config('services.twilio.from');
        if (!$from) {
            return;
        }

        $this->client->messages->create($to, [
            'from' => $from,
            'body' => $message,
        ]);
    }
}
