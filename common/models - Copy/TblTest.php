<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_test".
 *
 * @property integer $id
 * @property string $title
 * @property integer $chapterid
 * @property string $allotedtime
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Subjchapters $chapter
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
            [['chapterid', 'status'], 'integer'],
            [['allotedtime', 'created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 50],
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
            'title' => 'Title',
            'chapterid' => 'Chapter',
            'allotedtime' => 'Allotedtime',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapter()
    {
        return $this->hasOne(SubjectChapters::className(), ['id' => 'chapterid']);
    }
}
