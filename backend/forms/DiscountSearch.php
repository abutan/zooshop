<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\shop\Discount;

/**
 * DiscountSearch represents the model behind the search form of `store\entities\shop\Discount`.
 */
class DiscountSearch extends Model
{
    public $id;
    public $name;
    public $active;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Discount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function activeList(): array
    {
        return [
            1 => 'Активно',
            0 => 'Отключено'
        ];
    }
}
