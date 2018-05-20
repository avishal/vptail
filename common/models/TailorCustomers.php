<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tailor_customers".
 *
 * @property integer $id
 * @property integer $tailorid
 * @property integer $customerid
 * @property string $created
 * @property string $updated
 *
 * @property TailorUsers $tailor
 * @property Customers $customer
 */
class TailorCustomers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tailor_customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tailorid', 'customerid'], 'integer'],
            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['tailorid'], 'exist', 'skipOnError' => true, 'targetClass' => TailorUsers::className(), 'targetAttribute' => ['tailorid' => 'id']],
            [['customerid'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customerid' => 'id']],
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
            'customerid' => 'Customerid',
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
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['id' => 'customerid']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord)
            $this->created = $this->updated = date("Y-m-d H:i:s", time());
        else
            $this->updated = date("Y-m-d H:i:s", time());
        return parent::beforeSave($insert);
    }
}
