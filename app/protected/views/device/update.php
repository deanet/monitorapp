<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Devices','url'=>array('index')),
);
?>

<h1>Update Device: <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>