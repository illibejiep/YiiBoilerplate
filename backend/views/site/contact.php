<?php
$this->pageTitle = Yii::app()->name . ' - Contact Us';
$this->breadcrumbs = array(
	'Contact',
);
?>

<h1>Contact Us</h1>

<?php if (Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
	If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

	<?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('CActiveForm', array(
	'id' => 'contact-form',
	'enableClientValidation' => true,
	'htmlOptions' => array('class' => 'well'),
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textField($model, 'name'); ?><br>
	<?php echo $form->textField($model, 'email'); ?><br>
	<?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?><br>
	<?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?><br>
	<div style="clear:both"></div><br>
	<?php if (CCaptcha::checkRequirements()): ?>
	<?php $this->widget('CCaptcha'); ?>
	<?php echo $form->textField($model, 'verifyCode'); ?>
	<p class="help-block">Please, enter the letters as they are shown in the image above. Letters are not
		case-sensitive</p>
	<?php endif; ?>

	<div class="form-actions">
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->
<?php  endif; ?>