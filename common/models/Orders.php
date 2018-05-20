<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $tailorid
 * @property integer $customerid
 * @property double $per_pant_price
 * @property double $per_shirt_price
 * @property integer $pant_count
 * @property integer $shirt_count
 * @property integer $delivery_date
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_PROGRESS = 1;
    const STATUS_READY = 2;
    const STATUS_DELIVERED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tailorid', 'customerid', 'pant_count', 'shirt_count', 'status'], 'integer'],
            [['per_pant_price', 'per_shirt_price'], 'number'],
            [['delivery_date', 'created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
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
            'per_pant_price' => 'Per Pant Price',
            'per_shirt_price' => 'Per Shirt Price',
            'pant_count' => 'Pant Count',
            'shirt_count' => 'Shirt Count',
            'delivery_date' => 'Delivery Date',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

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
