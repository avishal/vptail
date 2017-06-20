<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TblTest;

/**
 * TblTestSearch represents the model behind the search form about `common\models\TblTest`.
 */
class TblTestSearch extends TblTest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'classid', 'subjid', 'chapterid', 'status'], 'integer'],
            [['title', 'allotedtime', 'created', 'updated'], 'safe'],
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
        $query = TblTest::find();

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
            'classid' => $this->classid,
            'subjid' => $this->subjid,
            'chapterid' => $this->chapterid,
            'allotedtime' => $this->allotedtime,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
