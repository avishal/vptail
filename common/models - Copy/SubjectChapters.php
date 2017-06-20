<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subjchapters".
 *
 * @property integer $id
 * @property integer $subjid
 * @property string $title
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Subjects $subj
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
            [['subjid', 'title'], 'required'],
            [['subjid', 'status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 50],
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
            'subjid' => 'Subject',
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
