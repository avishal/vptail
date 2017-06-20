<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_subscription".
 *
 * @property integer $id
 * @property integer $studentid
 * @property integer $subscriptionid
 * @property string $starttime
 * @property string $endtime
 *
 * @property Student $student
 * @property SubscriptionPlans $subscription
 */
class StudentSubscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studentid', 'subscriptionid'], 'integer'],
            [['starttime', 'endtime'], 'required'],
            [['starttime', 'endtime'], 'safe'],
            [['studentid'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['studentid' => 'id']],
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
            'studentid' => 'Studentid',
            'subscriptionid' => 'Subscriptionid',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Students::className(), ['id' => 'studentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscription()
    {
        return $this->hasOne(SubscriptionPlans::className(), ['id' => 'subscriptionid']);
    }
}
