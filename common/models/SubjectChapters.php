<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subjchapters".
 *
 * @property integer $id
 * @property integer $classid
 * @property integer $subjid
 * @property string $title
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Subjects $subj
 * @property Classes $class
 * @property TblTest[] $tblTests
 */
class SubjectChapters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjchapters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classid', 'subjid', 'status'], 'integer'],
            [['subjid', 'title'], 'required'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['subjid'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subjid' => 'id']],
            [['classid'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['classid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'classid' => 'Classid',
            'subjid' => 'Subjid',
            'title' => 'Title',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
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
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'classid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblTests()
    {
        return $this->hasMany(TblTest::className(), ['chapterid' => 'id']);
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
