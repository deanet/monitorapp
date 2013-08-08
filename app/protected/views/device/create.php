<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Devices','url'=>array('index')),
);
?>

<h1>Add a Device</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>