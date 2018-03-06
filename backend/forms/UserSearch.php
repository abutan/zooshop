<?php

namespace backend\forms;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use store\entities\user\User;

/**
 * UserSearch represents the model behind the search form of `store\entities\user\User`.
 */
class UserSearch extends Model
{
    public $id;
    public $status;
    public $date_from;
    public $date_to;
    public $username;
    public $phone;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'phone', 'email'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d']
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from. '00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to. '23:59:59') : null])
        ;

        return $dataProvider;
    }
}
