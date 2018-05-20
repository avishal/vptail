<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $mobile
 * @property string $address
 * @property integer $status
 * @property string $password
 * @property string $created
 * @property string $updated
 */
class Customers extends \yii\db\ActiveRecord
{
    const ACTIVE_STATUS = 10;
    const INACTIVE_STATUS = 0;
    const DELETED_STATUS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'mobile'], 'required'],
            [['status'], 'integer'],
            ['email','email'],
            [['password'], 'string'],
            [['created', 'updated'], 'safe'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'status' => 'Status',
            'password' => 'Password',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function getTailorCustomer()
    {
        return $this->hasOne(TailorCustomers::className(), ['tailorid' => 'id']);
    }

    public function getTailorWorker()
    {
        return $this->hasOne(TailorCustomers::className(), ['tailorid' => 'tailorid'])->viaTable('tailor_workers', ['tailorid' => 'id']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord)
            $this->created = $this->updated = date("Y-m-d H:i:s", time());
        else
            $this->updated = date("Y-m-d H:i:s", time());
        return parent::beforeSave($insert);
    }
}
