<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_queue".
 *
 * @property integer $mail_id
 * @property integer $domain_id
 * @property string $message
 * @property integer $sent
 * @property string $date_sent
 *
 * @property Domain $domain
 */
class MailQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain_id'], 'required'],
            [['domain_id', 'sent'], 'integer'],
            [['date_sent'], 'safe'],
            [['message'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mail_id' => 'Mail ID',
            'domain_id' => 'Domain ID',
            'message' => 'Message',
            'sent' => 'Sent',
            'date_sent' => 'Date Sent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['domain_id' => 'domain_id']);
    }
}
