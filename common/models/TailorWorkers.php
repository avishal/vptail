<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tailor_workers".
 *
 * @property integer $id
 * @property integer $tailorid
 * @property integer $workerid
 * @property string $created
 * @property string $updated
 *
 * @property TailorUsers $tailor
 * @property Worker $worker
 */
class TailorWorkers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tailor_workers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tailorid', 'workerid'], 'integer'],
            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['tailorid'], 'exist', 'skipOnError' => true, 'targetClass' => TailorUsers::className(), 'targetAttribute' => ['tailorid' => 'id']],
            [['workerid'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::className(), 'targetAttribute' => ['workerid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tailorid' => 'Tailorid',
            'workerid' => 'Workerid',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTailor()
    {
        return $this->hasOne(TailorUsers::className(), ['id' => 'tailorid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Worker::className(), ['id' => 'workerid']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord)
            $this->created = $this->updated = date("Y-m-d H:i:s", time());
        else
            $this->updated = date("Y-m-d H:i:s", time());
        return parent::beforeSave($insert);
    }
}
