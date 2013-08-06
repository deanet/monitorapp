<?php

class m130806_193317_create_content_table extends CDbMigration
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
    $this->tableName = $this->tablePrefix.'content';

  $this->createTable($this->tableName, array(
             'id' => 'pk',
             'name'=> 'VARCHAR(255) NOT NULL',
             'url'=> 'VARCHAR(255) NOT NULL',
             'type'=> 'TINYINT DEFAULT 0',
             'device_id'=> 'INTEGER DEFAULT 0',
               ), $this->MySqlOptions);
              $this->createIndex('content_id', $this->tableName , 'id', true);
 	}

 	public function safeDown()
 	{
 	  	$this->before();
      $this->tableName = $this->tablePrefix.'content';
      $this->dropIndex('content_id', $this->tableName);
 	    $this->dropTable($this->tableName);
 	}
}