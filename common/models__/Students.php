<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $email
 * @property string $mobile
 * @property string $dateofbirth
 * @property string $city
 * @property string $state
 * @property string $country
 * @property integer $classid
 * @property string $gender
 * @property string $username
 * @property string $password
 * @property string $emailverified
 * @property string $phoneverified
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Classes $class
 * @property StudentSubscription[] $studentSubscriptions
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'email', 'mobile'], 'required'],
            [['dateofbirth', 'created', 'updated'], 'safe'],
            [['classid', 'status'], 'integer'],
            [['emailverified', 'phoneverified'], 'string'],
            [['firstname', 'middlename', 'lastname'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 30],
            [['mobile', 'gender', 'username'], 'string', 'max' => 10],
            [['city', 'state', 'country'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255],
            [['classid'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['classid' => 'id']],
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
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'dateofbirth' => 'Dateofbirth',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'classid' => 'Class',
            'gender' => 'Gender',
            'username' => 'Username',
            'password' => 'Password',
            'emailverified' => 'Emailverified',
            'phoneverified' => 'Phoneverified',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'classid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSubscriptions()
    {
        return $this->hasMany(StudentSubscription::className(), ['studentid' => 'id']);
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
