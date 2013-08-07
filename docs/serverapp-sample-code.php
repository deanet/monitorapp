// Record timestamp of cronjob for monitoring
$file = file_put_contents('./protected/runtime/cronstamp.txt',time(),FILE_USE_INCLUDE_PATH);

public function actionCheckdb() {
  // code to test the mysql db
  // - you can place any code that tests the database service here -
  // must return 'ok' or 'error'
  $result = Place::model()->count();
  if ($result>0)
    echo 'ok';
  else
    echo 'error';
}

public function actionLastcron() {
  // echo timestamp of last cron execution
  $file = file_get_contents('./protected/runtime/cronstamp  .txt',FILE_USE_INCLUDE_PATH);
  echo $file;
}

public function actionCheckdisk() {
  // echo free disk space
  $df = disk_free_space("/");
  echo $df; 
}


