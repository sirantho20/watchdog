<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "domain".
 *
 * @property integer $domain_id
 * @property string $domain
 * @property integer $notify_when_down
 * @property integer $notify_when_up
 * @property integer $account_id
 * @property string $date_added
 * @property string $date_updated
 * @property string $added_ip
 * @property string $updated_ip
 * @property integer $watch_mx
 * @property integer $watch_dns
 * @property integer $watch_ip
 *
 * @property Account $account
 * @property DomainRecord[] $domainRecords
 * @property MailQueue[] $mailQueues
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain', 'account_id', 'watch_mx', 'watch_dns'], 'required'],
            [['notify_when_down', 'notify_when_up', 'account_id', 'watch_mx', 'watch_dns', 'watch_ip'], 'integer'],
            [['date_added', 'date_updated'], 'safe'],
            [['domain'], 'string', 'max' => 100],
            [['added_ip', 'updated_ip'], 'string', 'max' => 45]
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_updated'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_added']
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'domain_id' => 'Domain ID',
            'domain' => 'Domain',
            'notify_when_down' => 'Notify When Down',
            'notify_when_up' => 'Notify When Up',
            'account_id' => 'Account ID',
            'date_added' => 'Date Added',
            'date_updated' => 'Date Updated',
            'added_ip' => 'Added Ip',
            'updated_ip' => 'Updated Ip',
            'watch_mx' => 'Watch Mx',
            'watch_dns' => 'Watch Dns',
            'watch_ip' => 'Watch Ip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainRecords()
    {
        return $this->hasMany(DomainRecord::className(), ['domain_id' => 'domain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailQueues()
    {
        return $this->hasMany(MailQueue::className(), ['domain_id' => 'domain_id']);
    }
    
    public function beforeValidate() {
        
        if($this->isNewRecord)
        {
            $this->account_id = \Yii::$app->user->identity->account_id;
            $this->added_ip = \Yii::$app->request->userIP;
            
        }
        else
        {
            $this->updated_ip = \Yii::$app->request->userIP;
        }
        
        return parent::beforeValidate();
    }
}
