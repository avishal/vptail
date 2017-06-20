<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentSubscription;

/**
 * StudentSubscriptionSearch represents the model behind the search form about `common\models\StudentSubscription`.
 */
class StudentSubscriptionSearch extends StudentSubscription
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'studentid', 'subscriptionid'], 'integer'],
            [['starttime', 'endtime','paymentid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = StudentSubscription::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'studentid' => $this->studentid,
            'subscriptionid' => $this->subscriptionid,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
            'paymentid' => $this->paymentid,
        ]);

        return $dataProvider;
    }
}
