<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "videos".
 *
 * @property integer $id
 * @property integer $chapterid
 * @property string $title
 * @property string $url
 * @property integer $isfree
 * @property integer $status
 * @property string $created
 * @property string $updated
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
            [['chapterid', 'title', 'url'], 'required'],
            [['chapterid', 'isfree', 'status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 25],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chapterid' => 'Chapterid',
            'title' => 'Title',
            'url' => 'Url',
            'isfree' => 'Isfree',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
