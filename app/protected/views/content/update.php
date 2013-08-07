<?php
$this->breadcrumbs=array(
	'Contents'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Content','url'=>array('admin')),
);
?>

<p>Update check for:</p><h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>