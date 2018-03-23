<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\shop\DeliveryMethod;

/**
 * DeliveryMethodSearch represents the model behind the search form about `fond\entities\shop\DeliveryMethod`.
 */
class DeliverySearch extends Model
{
    public $id;
    public $name;
    public $cost;
    public $min_price;
    public $max_price;
    public $min_weight;
    public $max_weight;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cost', 'min_price', 'max_price', 'min_weight', 'max_weight'], 'integer'],
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
        $query = DeliveryMethod::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC],
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

