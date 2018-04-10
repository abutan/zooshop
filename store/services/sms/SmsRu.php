<?php

namespace store\services\sms;


class SmsRu implements SmsSender
{
    private $appId;
    private $url;

    public function __construct($appId, $url = 'http://sms.ru/sms/send')
    {
        if (empty($appId)){
            throw new \InvalidArgumentException('Параметр appId должен быть заполнен.');
        }
        $this->appId = $appId;
        $this->url = $url;
    }

    public function send($number, $text): void
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'api_id' => $this->appId,
            'to' => '+' . trim($number, '+'),
            'text' => $text,
        ]);
        curl_exec($ch);

        if (curl_errno($ch)){
            throw new \RuntimeException('Не получается отправить запрос: ' . curl_error($ch));
        }

        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus !== 200){
            throw new \RuntimeException('Запрос отклонен: код статуса ответа: ' . $resultStatus);
        }

        curl_close($ch);
    }
}