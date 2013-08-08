<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $contents
 * @property string $prior_content
 * @property integer $type
 * @property integer $device_id
 * @property integer $sound
 
 */
class Content extends CActiveRecord
{
  
  const TYPE_CONTAINS=10;
  const TYPE_NOT_CONTAINS=15;
   const TYPE_TIMESTAMP=20;
   const TYPE_DISKSPACE=30;
   const TYPE_CHECKSERVICE=40;
   const TYPE_CHANGES=50;

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
			array('sound', 'length', 'max'=>32),
			array('url', 'url'),
			array('contents', 'length', 'max'=>2500),
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
			'name' => 'Friendly Name',
			'url' => 'Url to check',
			'contents' => 'Contents to compare (optional)',
			'type' => 'Type',
			'device_id' => 'Device',
			'sound' => 'Sound',
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
		$criteria->compare('contents',$this->url,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('sound',$this->sound);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
  // send notification to admin mobile device via pushover
  public function notify($title='',$message='',$url='',$urlTitle='',$priority=1,$token='',$device='iphone',$sound='default',$debug=false) {
    $po = new Pushover();
    $po->setToken(Yii::app()->params['pushover']['key']);
    $po->setUser($token);
    $po->setDevice($device);
    $po->setSound($sound);
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
  
  public function test($id) {
    $result = new stdClass;
    $result->status = true;
    $result->id = $id;
    $result->msg ='OK';
     $item = Content::model()->findByPk($id);
     $result->title = $item['name'];
     $result->urlTitle = 'Check this page...';
     $result->url = $item['url'];
     switch ($item['type']) {
       case self::TYPE_NOT_CONTAINS:
       $data = $this->getRemotePage($item['url']);
       if (stristr($data,$item['contents'])!==false) {
         $result->msg ='Fail';
         $result->status =false;
       }          
       break;
       case self::TYPE_CONTAINS:
        $data = $this->getRemotePage($item['url']);
        if (!stristr($data,$item['contents'])) {
          $result->msg ='Fail';
          $result->status =false;
        }          
       break;
       case self::TYPE_TIMESTAMP:
        $data = $this->getRemotePage($item['url']);
        if (time()-intval($data)>660) {
          $result->msg ='Fail';
          $result->status =false;          
        }
       break;
       case self::TYPE_DISKSPACE:
       $data = $this->getRemotePage($item['url']);
       if (intval($data)<1000000) { // < 1 MB returns failure
         $result->msg ='Fail';
         $result->status =false;          
       }
       break;
       case self::TYPE_CHECKSERVICE:
       $data = $this->getRemotePage($item['url']);
       if (trim(strtolower($data))<>'ok') { 
         $result->msg ='Fail';
         $result->status =false;          
       }
       break;      
       case self::TYPE_CHANGES:
       $data = $this->getRemotePage($item['url']);
       if ($data <> $item['prior_content']) {
         $result->msg ='Changed';
         $result->status =false;          
         // save data as new prior_content
         $save_result = $item->save();
       }
       break;      
     }
     return $result;
  }

  protected function beforeSave()
  {
    if ($this->type == self::TYPE_CHANGES) {
        $this->prior_content = $this->getRemotePage($this->url);
      }
    return parent::beforeSave();
  }
  

  function getRemotePage($url) {
  	$ch = curl_init();
  	$timeout = 5;
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  	$data = curl_exec($ch);
  	curl_close($ch);
  	return $data;
  }
  

    public function testAll() {
      $str = '';
  	  $errors = false;	  
  	  // monitor all content items
      $checks = Content::model()->findAll();
      foreach ($checks as $item) {
        // perform the test
        $str.='<p>Checking '.$item['name'].'...';
        $result = Content::model()->test($item['id']);
        // if there is an error send notification to the device
        if (!$result->status) {
          if ($item['type']==self::TYPE_CHANGES)
            $temp_result_string = 'Page Changed';
          else
            $temp_result_string = 'Failed';
          $str.=$temp_result_string.'<br />'; 
          $str.='Please check <a href="'.$item['url'].'">'.$item['url'].'</a><br />';
           if ($item['device_id']==0) {
             //  send to all devices
             $devices = Device::model()->findAll();
             foreach ($devices as $device) {
               Content::model()->notify($item['name'].' '.$temp_result_string,'Please check into...',$item['url'],'this page',1,$device['pushover_token'],$device['pushover_device'],$item['sound']);                            
               $str.='Notifying '.$device['name'].'<br />';
             }
           } else {
             $device = Device::model()->findByPk($item['device_id']);
             Content::model()->notify($item['name'].' '.$temp_result_string,'Please check into...',$item['url'],'this page',1,$device['pushover_token'],$device['pushover_device'],$item['sound']) ;               
             $str.='Notifying '.$device['name'].'<br />';
           }
           $str.='</p>';
          $errors = true;
        } else {
          $str.='success</p>';
        }      
      } 
      // check for sending heartbeart
      if (!$errors) {
        // only notify me with heartbeat every heartbeat_interval hours
        // note: cron must run every ten minutes or change 10 below to fit your interval
        // the point of date('i')<10 is to send heartbeat only in first part of any hour
        if ((date('G')% Yii::app()->params['heartbeat_interval']) == 0 and date('i')<10) {
          $this->sendHeartbeat();
          $str.='<p>Heartbeat sent.</p>';
        } else {
          $str.='<p>Skipped heartbeat for now.</p>';        
        }
  	  }
  	  return $str;    
    }

    public function testNotify($result) {
      $item = Content::model()->findByPk($result->id);      
      if ($item['type']==self::TYPE_CHANGES)
        $temp_result_string = 'Page Changed';
      else
        $temp_result_string = 'Failed';
      if ($item['device_id']==0) {
        //  send to all devices
        $devices = Device::model()->findAll();
        foreach ($devices as $device) {
          Content::model()->notify($item['name'].' '.$temp_result_string,'Please check into...',$item['url'],'this page',1,$device['pushover_token'],$device['pushover_device'],$item['sound']);                            
        }
      } else {
        $device = Device::model()->findByPk($item['device_id']);
        Content::model()->notify($item['name'].' '.$temp_result_string,'Please check into...',$item['url'],'this page',1,$device['pushover_token'],$device['pushover_device'],$item['sound']) ;               
      }
    }
    
    public function sendHeartbeat() {
      $devices = Device::model()->findAll();
      // sends heartbeat to all devices
      foreach ($devices as $device) {
        Content::model()->notify('Heartbeat','Testing testing testing...','http://jeffreifman.com/','Learn more about monitor app',1,$device['pushover_token'],$device['pushover_device'],Yii::app()->params['heartbeat_sound']) ;
          // add break here to skip secondary devices
      }	      
    }	

    public function getTypeOptions()
     {
       return array(
         self::TYPE_CONTAINS=>'Check that page contains this content',
         self::TYPE_NOT_CONTAINS=>'Check that page does NOT contains this content',
         self::TYPE_TIMESTAMP=>'Verify recent timestamp e.g. cron',
         self::TYPE_DISKSPACE=>'Verify free diskspace',
         self::TYPE_CHECKSERVICE=>'Verify service is running',
         self::TYPE_CHANGES=>'Notify when page changes',
          );
      }			

       public function getDeviceOptions()
       {
         $deviceArray = CHtml::listData(Device::model()->findAll(), 'id', 'name');
         return $deviceArray;
      }	

  	public function getSoundOptions() {
  	  return array(
      'pushover'=>'pushover',
      'bike'=>'bike',
      'bugle'=>'bugle',
      'cashregister'=>'cashregister',
      'classical'=>'classical',
      'cosmic'=>'cosmic',
      'falling'=>'falling',
      'gamelan'=>'gamelan',
      'incoming'=>'incoming',
      'intermission'=>'intermission',
      'magic'=>'magic',
      'mechanical'=>'mechanical',
      'pianobar'=>'pianobar',
      'siren'=>'siren',
      'spacealarm'=>'spacealarm',
      'tugboat'=>'tugboat',
      'alien'=>'alien',
      'climb'=>'climb',
      'persistent'=>'persistent',
      'echo'=>'echo',
      'updown'=>'updown',
      'none'=>'none'
      );
  	}

}