<?php

class m130807_211910_add_sound_to_content_table extends CDbMigration
{
     protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci';
   public $tablePrefix;
   public $tableName;

   public function before() {
     $this->tablePrefix = Yii::app()->getDb()->tablePrefix;
     if ($this->tablePrefix <> '')
       $this->tableName = $this->tablePrefix.'content';
   }

 	public function safeUp()
 	{
 	  $this->before();
    $this->addColumn($this->tableName,'sound','VARCHAR(32) DEFAULT "default"');
 	}

 	public function safeDown()
 	{
 	  	$this->before();
      $this->dropColumn($this->tableName,'sound');
 	}
}