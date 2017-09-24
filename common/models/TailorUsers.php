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
 */
class TailorUsers extends \yii\db\ActiveRecord
{
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
            [['firstname', 'lastname', 'email', 'mobile', 'shop_name', 'status', 'created', 'updated', 'password'], 'required'],
            [['status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['password'], 'string'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 10],
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
        ];
    }
}
