<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'device-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

	<?php
  echo $form->labelEx($model,'send_email'); 
  echo $form->dropDownList($model,'send_email', $model->getSendOptions()); 
   echo $form->error($model,'send_email'); 
	?>

	<?php echo $form->textFieldRow($model,'pushover_token',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'pushover_device',array('class'=>'span5','maxlength'=>32)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
