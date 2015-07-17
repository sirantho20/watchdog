<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_152653_addAuthKey extends Migration
{
    public function up()
    {
        $this->addColumn('account', 'auth_key', Schema::TYPE_STRING);

    }

    public function down()
    {
        $this->dropColumn('account', 'auth_key');
    }
    
}
