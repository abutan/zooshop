<?php

namespace store\services\sms;


interface SmsSender
{
    public function send($number, $text): void;
}