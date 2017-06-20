<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TestQuestions;

/**
 * TestQuestionsSearch represents the model behind the search form about `common\models\TestQuestions`.
 */
class TestQuestionsSearch extends TestQuestions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'testid', 'status'], 'integer'],
            [['question', 'first_option', 'second_option', 'third_option', 'fourth_option', 'fifth_option', 'sixth_option', 'answer', 'solution', 'created', 'updated'], 'safe'],
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
        $query = TestQuestions::find();

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
            'testid' => $this->testid,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'first_option', $this->first_option])
            ->andFilterWhere(['like', 'second_option', $this->second_option])
            ->andFilterWhere(['like', 'third_option', $this->third_option])
            ->andFilterWhere(['like', 'fourth_option', $this->fourth_option])
            ->andFilterWhere(['like', 'fifth_option', $this->fifth_option])
            ->andFilterWhere(['like', 'sixth_option', $this->sixth_option])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'solution', $this->solution]);

        return $dataProvider;
    }
}
