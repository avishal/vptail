<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tailor_users".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $mobile
 * @property string $address
 * @property string $shop_name
 * @property string $shop_address
 * @property integer $status
 * @property string $created
 * @property string $updated
 * @property string $password
 * @property string $measurement_unit
 *
 * @property Measurements[] $measurements
 * @property Orders[] $orders
 * @property TailorCustomers[] $tailorCustomers
 * @property TailorWorkers[] $tailorWorkers
 */
class TailorUsers extends \yii\db\ActiveRecord
{

    const ACTIVE_STATUS = 10;
    const INACTIVE_STATUS = 0;
    const DELETED_STATUS = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tailor_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'mobile', 'shop_name'], 'required'],
            [['status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['password'], 'string'],
            ['email','email'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 50],
            [['mobile', 'measurement_unit'], 'string', 'max' => 10],
            [['address', 'shop_name', 'shop_address'], 'string', 'max' => 255],
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
            'shop_name' => 'Shop Name',
            'shop_address' => 'Shop Address',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'password' => 'Password',
            'measurement_unit' => 'Measurement Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurements()
    {
        return $this->hasMany(Measurements::className(), ['tailorid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['tailorid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTailorCustomers()
    {
        return $this->hasMany(TailorCustomers::className(), ['tailorid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTailorWorkers()
    {
        return $this->hasMany(TailorWorkers::className(), ['tailorid' => 'id']);
    }

    public function getTailorCustomer()
    {
        return $this->hasOne(TailorCustomers::className(), ['id' => 'tailorid']);
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
