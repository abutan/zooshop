<?php

namespace store\forms\site;


use yii\base\Model;

class CommentForm extends Model
{
    public $text;
    public $parentId;
    public $verifyCode;

    public function rules() {
        return [
            ['text', 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
            ['verifyCode', 'captcha']
        ];
    }

    public function attributeLabels() {
        return [
            'text' => 'Ваше предложение (сообщение, вопрос)',
            'verifyCode' => 'Код подтверждения',
        ];
    }
}