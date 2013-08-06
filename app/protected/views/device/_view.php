<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pushover_token')); ?>:</b>
	<?php echo CHtml::encode($data->pushover_token); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pushover_device')); ?>:</b>
	<?php echo CHtml::encode($data->pushover_device); ?>
	<br />


</div>