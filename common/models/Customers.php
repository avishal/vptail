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
            [['firstname', 'lastname', 'email', 'mobile', 'created', 'updated'], 'required'],
            [['status'], 'integer'],
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
}
