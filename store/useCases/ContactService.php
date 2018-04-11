<?php

namespace store\useCases;


use store\forms\ContactForm;
use yii\mail\MailerInterface;

class ContactService
{
    private $adminEmail;
    private $mailer;

    public function __construct($adminEmail, MailerInterface $mailer)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function sendMail(ContactForm $form): void
    {
        $sent = $this->mailer->compose()
            ->setSubject($form->subject)
            ->setTo($this->adminEmail)
            ->setTextBody($form->body)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Ошибка отправки. Попробуйте повторить позже.');
        }
    }
}