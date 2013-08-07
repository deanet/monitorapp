<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Device','url'=>array('index')),
	array('label'=>'Create Device','url'=>array('create')),
	array('label'=>'Update Device','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Device','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Device','url'=>array('admin')),
);
?>

<h1>View Device <?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'email',
		'send_email',
		'pushover_token',
		'pushover_device',
	),
)); ?>
