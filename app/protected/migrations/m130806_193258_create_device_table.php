<?php

class m130806_193258_create_device_table extends CDbMigration
{
     protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
     public $tablePrefix;
     public $tableName;

     public function before() {
       $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     }

   	public function safeUp()
   	{
   	  $this->before();
      $this->tableName = $this->tablePrefix.'device';

    $this->createTable($this->tableName, array(
               'id' => 'pk',
               'name'=> 'VARCHAR(128) NOT NULL',
               'email'=> 'VARCHAR(255) NOT NULL',               
               'pushover_token'=> 'VARCHAR(32) NOT NULL',
               'pushover_device' => 'VARCHAR(32) NOT NULL',
               'send_email'=> 'TINYINT(1) default 0',                              
                 ), $this->MySqlOptions);
                $this->createIndex('device_id', $this->tableName , 'id', true);
   	}

   	public function safeDown()
   	{
   	  	$this->before();
        $this->tableName = $this->tablePrefix.'device';
        $this->dropIndex('device_id', $this->tableName);
   	    $this->dropTable($this->tableName);
   	}
}