<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_test_questions".
 *
 * @property integer $id
 * @property integer $testid
 * @property string $question
 * @property string $first_option
 * @property string $second_option
 * @property string $third_option
 * @property string $fourth_option
 * @property string $fifth_option
 * @property string $sixth_option
 * @property string $answer
 * @property string $solution
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property TblTest $test
 */
class TestQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_test_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['testid', 'status'], 'integer'],
            [['question', 'first_option', 'second_option', 'answer', 'solution'], 'required'],
            [['question', 'solution'], 'string'],
            [['created', 'updated'], 'safe'],
            [['first_option', 'second_option', 'third_option', 'fourth_option', 'fifth_option', 'sixth_option', 'answer'], 'string', 'max' => 5],
            [['testid'], 'exist', 'skipOnError' => true, 'targetClass' => TblTest::className(), 'targetAttribute' => ['testid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testid' => 'Test no',
            'question' => 'Question',
            'first_option' => 'First Option',
            'second_option' => 'Second Option',
            'third_option' => 'Third Option',
            'fourth_option' => 'Fourth Option',
            'fifth_option' => 'Fifth Option',
            'sixth_option' => 'Sixth Option',
            'answer' => 'Answer',
            'solution' => 'Solution',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(TblTest::className(), ['id' => 'testid']);
    }
}
