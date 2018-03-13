<?php

namespace store\services\manage\site;


use store\entities\site\Call;
use store\forms\manage\site\CallForm;
use store\repositories\manage\site\CallRepository;
use yii\mail\MailerInterface;

class CallManageService
{
    private $calls;
    private $adminEmail;
    private $mailer;

    public function __construct($adminEmail, CallRepository $calls,  MailerInterface $mailer) {
        $this->calls = $calls;
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function create(CallForm $form)
    {
        $call = Call::create(
            $form->name,
            $form->phone
        );
        $this->calls->save($call);

        $subject = 'ОБРАТИТЕ ВНИМАНИЕ! '.$form->name.' просит перезвонить ему.';
        $body = '<p>Подробности: <br>';
        $body .= 'ФИО: '.$form->name.'<br>';
        $body .= 'Телефон: '.$form->phone.'</p>';
        $body .= '<p>Сайт <strong>ДЕЖУРНАЯ ВЕТАПТЕКА</strong> </p>';

        $sent = $this->mailer->compose()
            ->setSubject($subject)
            ->setTo($this->adminEmail)
            ->setHtmlBody($body)
            ->send();

        if (!$sent){
            throw new \DomainException('Ошибка отправки.');
        }
    }

    public function activate($id)
    {
        $call = $this->calls->get($id);
        $call->activate();
        $this->calls->save($call);
    }

    public function remove($id)
    {
        $call = $this->calls->get($id);
        $this->calls->remove($call);
    }
}