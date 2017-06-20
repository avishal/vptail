<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "videos".
 *
 * @property integer $id
 * @property integer $classid
 * @property integer $subjid
 * @property integer $chapterid
 * @property string $title
 * @property string $url
 * @property integer $isfree
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Classes $class
 * @property Subjects $subj
 * @property SubjectChapters $chapter
 */
class Videos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classid', 'subjid', 'chapterid', 'isfree', 'status'], 'integer'],
            [['title', 'url'], 'required'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 25],
            [['url'], 'string', 'max' => 255],
            [['classid'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['classid' => 'id']],
            [['subjid'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subjid' => 'id']],
            [['chapterid'], 'exist', 'skipOnError' => true, 'targetClass' => SubjectChapters::className(), 'targetAttribute' => ['chapterid' => 'id']],
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
            'chapterid' => 'Chapterid',
            'title' => 'Title',
            'url' => 'Url',
            'isfree' => 'Isfree',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
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
    public function getChapter()
    {
        return $this->hasOne(SubjectChapters::className(), ['id' => 'chapterid']);
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
