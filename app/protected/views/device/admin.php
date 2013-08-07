<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Add Device','url'=>array('create')),
);

 // display flash when user isn't a member anywhere
if(Yii::app()->user->hasFlash('warning')) {
  $this->widget('bootstrap.widgets.TbAlert', array(
      'block'=>true, // display a larger alert block?
      'fade'=>true, // use transitions?
      'closeText'=>'×', // close link text - if set to false, no close link is displayed
      'alerts'=>array( // configurations per alert type
  	    'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
      ),
  ));
}

  if(Yii::app()->user->hasFlash('info')) {
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
    	    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));
  }
  

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Devices</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'device-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'pushover_token',
		'pushover_device',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'header'=>'Options',
      'template'=>'{test}{update}{delete}',
          'buttons'=>array
          (
              'test' => array
              (
                'options'=>array('title'=>'test'),
                'label'=>'<i class="icon-bell icon-large" style="margin:5px;"></i>',
                'url'=>'Yii::app()->createUrl("device/test", array("id"=>$data->id))',
              ),
          ),			
		),
	),
)); ?>
