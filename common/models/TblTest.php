<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_test".
 *
 * @property integer $id
 * @property string $title
 * @property integer $classid
 * @property integer $subjid
 * @property integer $chapterid
 * @property string $allotedtime
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property StudentTests[] $studentTests
 * @property Subjchapters $chapter
 * @property Classes $class
 * @property Subjects $subj
 * @property TblTestQuestions[] $tblTestQuestions
 */
class TblTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'allotedtime', 'status', 'created', 'updated'], 'required'],
            [['classid', 'subjid', 'chapterid', 'status'], 'integer'],
            [['allotedtime', 'created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['chapterid'], 'exist', 'skipOnError' => true, 'targetClass' => SubjectChapters::className(), 'targetAttribute' => ['chapterid' => 'id']],
            [['classid'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['classid' => 'id']],
            [['subjid'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subjid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'classid' => 'Classid',
            'subjid' => 'Subjid',
            'chapterid' => 'Chapterid',
            'allotedtime' => 'Allotedtime',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentTests()
    {
        return $this->hasMany(StudentTests::className(), ['testid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapter()
    {
        return $this->hasOne(SubjectChapters::className(), ['id' => 'chapterid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'classid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubj()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'subjid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblTestQuestions()
    {
        return $this->hasMany(TestQuestions::className(), ['testid' => 'id']);
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
