<?php

class m130808_020536_add_prior_to_content_table extends CDbMigration
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
    $this->addColumn($this->tableName,'prior_content','TEXT');
 	}

 	public function safeDown()
 	{
 	  	$this->before();
      $this->dropColumn($this->tableName,'prior_content');
 	}
}