<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_095433_addPasswordColumn extends Migration
{
    public function up()
    {
        $this->addColumn('account', 'password', Schema::TYPE_STRING.' NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('account', 'password');
    }
    
}
