<?php

use App\HTTP\Interfaces\MessageInterface;
use PhpParser\Builder\Class_;

class SmsService implements MessageInterface
{

    private $from;
    private $text;
    private $to;
    private $isFlash;

    public function fire()
    {
    }
    public function  getFrom()
    {
        return $this->from;
    }
    public function setFrom($from)
    {
        $this->from = $from;
    }
    public function  getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function  getTo()
    {
        return $this->to;
    }
    public function setTo($to)
    {
        $this->to = $to;
    }
}
