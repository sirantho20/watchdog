<?php

use yii\db\Schema;
use yii\db\Migration;

class m150715_161556_dbSetup extends Migration
{
    public function up()
    {
        $this->execute(file_get_contents(Yii::getAlias('@app').'/data/db.sql'));
    }

    public function down()
    {
        $this->execute('DROP TABLE IF EXISTS mail_queue, domain_record, domain, account');
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
