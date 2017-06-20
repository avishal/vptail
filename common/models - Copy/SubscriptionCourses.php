<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscription_courses".
 *
 * @property integer $id
 * @property integer $classid
 * @property integer $subscriptionid
 * @property string $created
 * @property string $updated
 *
 * @property Classes $class
 * @property SubscriptionPlans $subscription
 */
class SubscriptionCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription_courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classid', 'subscriptionid'], 'integer'],
            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['classid'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['classid' => 'id']],
            [['subscriptionid'], 'exist', 'skipOnError' => true, 'targetClass' => SubscriptionPlans::className(), 'targetAttribute' => ['subscriptionid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'classid' => 'Classid',
            'subscriptionid' => 'Subscriptionid',
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
    public function getSubscription()
    {
        return $this->hasOne(SubscriptionPlans::className(), ['id' => 'subscriptionid']);
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
