<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscription_plans".
 *
 * @property integer $id
 * @property string $title
 * @property double $price
 * @property double $special_price
 * @property integer $duration
 * @property string $description
 * @property string $created
 * @property string $updated
 *
 * @property StudentSubscription[] $studentSubscriptions
 * @property SubscriptionCourses[] $subscriptionCourses
 */
class SubscriptionPlans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription_plans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price', 'duration'], 'required'],
            [['price', 'special_price'], 'number'],
            [['duration'], 'integer'],
            [['description'], 'string'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'special_price' => 'Special Price',
            'duration' => 'Duration',
            'description' => 'Description',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSubscriptions()
    {
        return $this->hasMany(StudentSubscription::className(), ['subscriptionid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionCourses()
    {
        return $this->hasMany(SubscriptionCourses::className(), ['subscriptionid' => 'id']);
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
