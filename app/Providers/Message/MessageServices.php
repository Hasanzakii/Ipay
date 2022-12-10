<?php

namespace App\Providers\Message;

use App\Http\Interfaces\Messageinterface;

class MessageService
{
    private $message;
    public function __construct(Messageinterface $message)
    {
        $this->message = $message;
    }

    public function send()
    {
        return $this->message->fire();
    }
}
