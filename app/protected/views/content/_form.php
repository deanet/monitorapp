<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>
	<?php echo $form->textAreaRow($model,'contents',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>

	<?php
  echo $form->labelEx($model,'type'); 
  echo $form->dropDownList($model,'type', $model->getTypeOptions()); 
   echo $form->error($model,'type'); 
	?>

  <?php 
      echo '<p>'. $form->dropDownList($model,'device_id',$model->getDeviceOptions(),array('empty'=>'Select Device')).'</p>';
  ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
