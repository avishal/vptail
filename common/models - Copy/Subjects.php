<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property integer $classid
 * @property string $title
 * @property string $image
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Subjchapters[] $subjchapters
 * @property Classes $class
 */
class Subjects extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $uploadpath = 'uploads/';
    public $logo_uploadpath = 'images/subjlogos/';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classid', 'title'], 'required'],
            [['classid', 'status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 15],
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'classid' => 'Class',
            'title' => 'Title',
            'image' => 'Image',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjchapters()
    {
        return $this->hasMany(Subjchapters::className(), ['subjid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'classid']);
    }

    public function getImageurl()
    {
        if($this->image)
            return \Yii::$app->request->BaseUrl.'/'.$this->uploadpath.$this->logo_uploadpath.$this->image;
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
}
