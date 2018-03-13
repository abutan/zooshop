<?php

namespace store\entities\site;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $phone [varchar(255)]
 * @property int $status [smallint(6)]
 * @property int $created_at [int(11)]
 */
class Call extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE =1;

    public static function create($name, $phone): self
    {
        $call = new static();
        $call->name = $name;
        $call->phone = $phone;
        $call->status = self::STATUS_DRAFT;
        $call->created_at = time();

        return $call;
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function activate()
    {
        if ($this->isActive()){
            throw new \DomainException('Сообщение уже прочитано.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function attributeLabels() {
        return [
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'status' => 'Состояние',
            'created_at' => 'Отправлено',
        ];
    }

    public static function tableName()
    {
        return '{{%calls}}';
    }
}