<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $type
 * @property integer $device_id
 */
class Content extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Content the static model class
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
		return '{{content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url', 'required'),
			array('type, device_id', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, type, device_id', 'safe', 'on'=>'search'),
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
			'url' => 'Url',
			'type' => 'Type',
			'device_id' => 'Device',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('device_id',$this->device_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
  // send notification to admin mobile device via pushover
  public function notify($title='',$message='',$url='',$urlTitle='',$priority=1,$token='',$device='iphone',$debug=false) {
    $po = new Pushover();
    $po->setToken(Yii::app()->params['pushover']['key']);
    $po->setUser(getUserProfile(1)->getAttribute('pushover_token'));
    $po->setDevice(getUserProfile(1)->getAttribute('pushover_device'));
    // to do - base this on logged in user
    // getUserProfile(Yii::app()->user->id)->getAttribute('pushover_token')
    //getUserProfile(Yii::app()->user->id)->getAttribute('pushover_device')
    $po->setTitle($title);
    $po->setMessage($message);
    if ($url<>'') {
      $po->setUrl($url);      
    }
    if ($urlTitle<>'') {
      $po->setUrlTitle($urlTitle);
    }
    $po->setPriority($priority);
    $po->setTimestamp(time());
    $po->setDebug(true);
    $go = $po->send();
    if ($debug) {
      echo '<pre>';
      print_r($go);
      echo '</pre>';      
    }
  }
	
}