<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property integer $id
 * @property string $title
 * @property string $logo
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Student[] $students
 * @property Subjchapters[] $subjchapters
 * @property Subjects[] $subjects
 * @property SubscriptionCourses[] $subscriptionCourses
 */
class Classes extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $uploadpath = 'uploads/';
    public $logo_uploadpath = 'images/classlogos/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 15],
            [['logo'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'logo' => 'Logo',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['classid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjchapters()
    {
        return $this->hasMany(Subjchapters::className(), ['classid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subjects::className(), ['classid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionCourses()
    {
        return $this->hasMany(SubscriptionCourses::className(), ['classid' => 'id']);
    }

    public function getImageurl()
    {
        if($this->logo)
            return \Yii::$app->request->BaseUrl.'/'.$this->uploadpath.$this->logo_uploadpath.$this->logo;
        else
            return \Yii::$app->request->BaseUrl.'/'.$this->uploadpath."placeholder-icon.png";
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

    public function statusData()
    {
        return ['Active' => 1,'Inactive'=>0];
    }
}
