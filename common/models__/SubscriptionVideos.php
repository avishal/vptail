<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscription_videos".
 *
 * @property integer $id
 * @property integer $videoid
 * @property integer $subscriptionid
 * @property string $created
 * @property string $updated
 *
 * @property Videos $video
 * @property SubscriptionPlans $subscription
 */
class SubscriptionVideos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription_videos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['videoid', 'subscriptionid'], 'integer'],
            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['videoid'], 'exist', 'skipOnError' => true, 'targetClass' => Videos::className(), 'targetAttribute' => ['videoid' => 'id']],
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
            'videoid' => 'Video',
            'subscriptionid' => 'Subscription',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Videos::className(), ['id' => 'videoid']);
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
