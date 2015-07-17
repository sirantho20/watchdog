<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "domain_record".
 *
 * @property integer $id
 * @property integer $domain_id
 * @property string $record_type
 * @property string $record_value
 * @property string $last_checked
 *
 * @property Domain $domain
 */
class DomainRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain_id', 'record_type', 'record_value', 'last_checked'], 'required'],
            [['domain_id'], 'integer'],
            [['last_checked'], 'safe'],
            [['record_type', 'record_value'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain_id' => 'Domain ID',
            'record_type' => 'Record Type',
            'record_value' => 'Record Value',
            'last_checked' => 'Last Checked',
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
