<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "measurements".
 *
 * @property integer $id
 * @property integer $tailorid
 * @property integer $customerid
 * @property double $length
 * @property double $chest
 * @property double $stomach
 * @property double $sleeve_length
 * @property double $shoulder
 * @property double $neck
 * @property double $cuff_length
 * @property double $pant_height
 * @property double $pant_waist
 * @property double $pant_thigh
 * @property double $pant_knee
 * @property double $pant_bottom
 * @property double $pant_inner
 * @property double $pant_butt
 * @property string $created
 * @property string $updated
 *
 * @property TailorUsers $tailor
 * @property TailorCustomers $customer
 */
class Measurements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'measurements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tailorid', 'customerid'], 'integer'],
            [['length', 'chest', 'stomach', 'sleeve_length', 'shoulder', 'neck', 'cuff_length', 'pant_height', 'pant_waist', 'pant_thigh', 'pant_knee', 'pant_bottom', 'pant_inner', 'pant_butt'], 'number'],
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
            'length' => 'Length',
            'chest' => 'Chest',
            'stomach' => 'Stomach',
            'sleeve_length' => 'Sleeve Length',
            'shoulder' => 'Shoulder',
            'neck' => 'Neck',
            'cuff_length' => 'Cuff Length',
            'pant_height' => 'Pant Height',
            'pant_waist' => 'Pant Waist',
            'pant_thigh' => 'Pant Thigh',
            'pant_knee' => 'Pant Knee',
            'pant_bottom' => 'Pant Bottom',
            'pant_inner' => 'Pant Inner',
            'pant_butt' => 'Pant Butt',
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
        return $this->hasOne(TailorCustomers::className(), ['id' => 'customerid']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord)
            $this->created = $this->updated = date("Y-m-d H:i:s", time());
        else
            $this->updated = date("Y-m-d H:i:s", time());
        return parent::beforeSave($insert);
    }
}
