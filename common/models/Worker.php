<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $mobile
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property TailorWorkers[] $tailorWorkers
 */
class Worker extends \yii\db\ActiveRecord
{
    const ACTIVE_STATUS = 10;
    const INACTIVE_STATUS = 0;
    const DELETED_STATUS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['status'], 'integer'],
            ['email','email'],
            [['created', 'updated'], 'safe'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTailorWorkers()
    {
        return $this->hasMany(TailorWorkers::className(), ['workerid' => 'id']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord)
            $this->created = $this->updated = date("Y-m-d H:i:s", time());
        else
            $this->updated = date("Y-m-d H:i:s", time());
        return parent::beforeSave($insert);
    }
}
