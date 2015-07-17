<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_101433_deleteUsername extends Migration
{
    public function up()
    {
        $this->dropColumn('account', 'username');
    }

    public function down()
    {
        $this->addColumn('account', 'username', Schema::TYPE_STRING);
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
