<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "account".
 *
 * @property integer $account_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $date_added
 * @property string $date_updated
 * @property string $added_ip
 * @property string $updated_ip
 * @property string $password
 * @property string $auth_key
 *
 * @property Domain[] $domains
 */
class Account extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_added', 'date_updated'], 'safe'],
            [['first_name', 'last_name', 'email_address', 'added_ip', 'updated_ip'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email Address',
            'date_added' => 'Date Added',
            'date_updated' => 'Date Updated',
            'added_ip' => 'Added Ip',
            'updated_ip' => 'Updated Ip',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomains()
    {
        return $this->hasMany(Domain::className(), ['account_id' => 'account_id']); 
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
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email_address' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function beforeValidate() 
    {
        
        if($this->isNewRecord)
        {
            $this->setPassword($this->password);
            $this->added_ip = \Yii::$app->request->userIP;
            $this->auth_key = \Yii::$app->security->generateRandomString(32);
        }
        else
        {
            $this->updated_ip = \Yii::$app->request->userIP;
        }

        return parent::beforeValidate();
    }
}
