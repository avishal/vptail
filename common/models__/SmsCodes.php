<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms_codes".
 *
 * @property integer $id
 * @property string $mobileno
 * @property string $country_code
 * @property string $code
 * @property integer $status
 * @property string $created
 */
class SmsCodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobileno', 'country_code', 'code'], 'trim'],
            [['mobileno', 'country_code', 'code'], 'required'],
            [['status'], 'integer'],
            [['created'], 'safe'],
            //[['mobileno'], 'string', 'max' => 15],
            [['mobileno'], 'udokmeci\yii2PhoneValidator\PhoneValidator','countryAttribute'=>'country_code'],// 
            [['country_code'], 'string', 'max' => 5],
            [['code'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobileno' => 'Mobile No',
            'country_code' => 'Country Code',
            'code' => 'Code',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }
}
