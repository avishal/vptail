<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_tests".
 *
 * @property integer $id
 * @property integer $studentid
 * @property integer $testid
 * @property integer $questionid
 * @property string $selectedoption
 * @property string $correctanswer
 * @property string $created
 * @property string $updated
 *
 * @property Student $student
 * @property TblTest $test
 * @property TblTestQuestions $question
 */
class StudentTests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_tests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studentid', 'testid', 'questionid'], 'integer'],
            [['correctanswer'], 'string'],
            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['selectedoption'], 'string', 'max' => 50],
            [['studentid'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['studentid' => 'id']],
            [['testid'], 'exist', 'skipOnError' => true, 'targetClass' => TblTest::className(), 'targetAttribute' => ['testid' => 'id']],
            [['questionid'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestions::className(), 'targetAttribute' => ['questionid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'studentid' => 'Studentid',
            'testid' => 'Testid',
            'questionid' => 'Questionid',
            'selectedoption' => 'Selectedoption',
            'correctanswer' => 'Correctanswer',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Students::className(), ['id' => 'studentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(TblTest::className(), ['id' => 'testid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestions::className(), ['id' => 'questionid']);
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->created = $this->updated = date('Y-m-d H:i:s', time());
        }
        else
            $this->updated = date('Y-m-d H:i:s', time());
        return parent::beforeSave($insert);
    }
}
