<?php

namespace store\entities\user;


use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $identity [varchar(255)]
 * @property string $network [varchar(255)]
 */
class Network extends ActiveRecord
{
    public static function create($identity, $network): self
    {
        Assert::notEmpty($identity);
        Assert::notEmpty($network);

        $item = new static();
        $item->identity = $identity;
        $item->network = $network;

        return $item;
    }

    public function isForNetwork($identity, $network): bool
    {
        return $this->identity === $identity && $this->network === $network;
    }

    public static function tableName()
    {
        return '{{%user_networks}}';
    }
}