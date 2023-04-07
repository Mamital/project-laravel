<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Interfaces\MessageInterface;
use Illuminate\Support\Facades\Config;

class SmsService implements MessageInterface
{
    private $from;
    private $to;
    private $text;
    private $isFlash = true;

    public function fire()
    {
        $sms = new MeliPayamakService();
        $result = $sms->SendSimpleSMS($this->from, $this->to, $this->text);
        return $result;
    }

    public function getFrom()
    {
        return $this->from;
    }
    public function setFrom($from)
    {
         $this->from = $from;
    }
    public function getTo()
    {
        return $this->to;
    }
    public function setTo($to)
    {
         $this->to = $to;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
         $this->text = $text;
    }


}