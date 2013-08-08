<?php
$this->breadcrumbs=array(
	'Contents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Content','url'=>array('admin')),
);
?>

<h1>Create a New Content or Service Check</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>