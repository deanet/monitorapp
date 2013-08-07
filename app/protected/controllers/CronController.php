<?php

class CronController extends Controller
{
  
  public function actionIndex()
	{
	  $result='asdasda';
	  $result = Content::model()->testAll();
		$this->render('index',array(
			'result'=>$result,
		));
	}
	
	public function actionHeartbeat() {
	  Content::model()->sendHeartbeat();
    Yii::app()->user->setFlash('info','Your notification has been sent. Check your device.');
    $this->redirect('/content/index');       
	}
}
?>