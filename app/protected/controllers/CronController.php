<?php

class CronController extends Controller
{
  
  public function actionIndex()
	{
	  $errors = false;

	  // monitor all content items
    $items = Content::model()->findAll();
    foreach ($items as $i) {
      // perform the test
      // if there is an error send notification to the device
      // if no device, send to all devices
      
    }
        
    // check heartbeart
    if (!$errors) {
      // only notify me with heartbeat every heartbeat_interval hours
      // note: cron must run every ten minutes or change 10 below to fit your interval
      // the point of date('i')<10 is to send heartbeat only in first part of any hour
      if ((date('G')% Yii::app()->params['heartbeat_interval']) == 0 and date('i')<10) {
        //$monitor->notify('Monitor heart beat is okay at'.(date('G')).'-'.date('i'),'MonitorApp Heartbeart is alive. No action required.');            
      }
	  }
    
	}
}
?>