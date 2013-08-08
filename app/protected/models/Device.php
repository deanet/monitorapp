<?php

/**
 * This is the model class for table "{{device}}".
 *
 * The followings are the available columns in table '{{device}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $send_email
 * @property string $pushover_token
 * @property string $pushover_device
 */
class Device extends CActiveRecord
{
    const SEND_DEVICE = 0;
    const SEND_EMAIL = 1;
    const SEND_BOTH = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{device}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pushover_token, pushover_device', 'required'),
			array('name', 'length', 'max'=>128),
			array('email', 'length', 'max'=>128),
			array('email', 'email'),
			array('pushover_token, pushover_device', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, pushover_token, pushover_device', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'email' => 'Email Address',
			'send_email' => 'Send Notifications As',
			'pushover_token' => 'Pushover Token',
			'pushover_device' => 'Pushover Device',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pushover_token',$this->pushover_token,true);
		$criteria->compare('pushover_device',$this->pushover_device,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
  public function getSendEmailOptions()
   {
     return array(
       self::SEND_DEVICE=>'Notify device via Pushover',
       self::SEND_EMAIL=>'Notify via email',
       self::SEND_BOTH=>'Notify email and device',
        );
    }			
	
}