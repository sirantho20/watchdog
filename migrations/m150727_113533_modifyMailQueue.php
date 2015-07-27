<?php

use yii\db\Schema;
use yii\db\Migration;

class m150727_113533_modifyMailQueue extends Migration
{
    public function up()
    {
        $this->alterColumn('mail_queue', 'failure_type', Schema::TYPE_TEXT);
        $this->renameColumn('mail_queue', 'failure_type', 'message');
        $this->alterColumn('mail_queue', 'sent', Schema::TYPE_INTEGER.' NULL');
        

    }

    public function down()
    {
        $this->renameColumn('mail_queue', 'message', 'failure_type');
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
