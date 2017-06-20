<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fcmdevices".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $device_token
 *
 * @property Student $user
 */
class Fcmdevices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fcmdevices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid'], 'integer'],
            [['device_token'], 'required'],
            [['device_token'], 'string', 'max' => 255],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'device_token' => 'Device Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Students::className(), ['id' => 'userid']);
    }
}
