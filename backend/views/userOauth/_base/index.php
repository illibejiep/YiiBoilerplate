<?
$this->breadcrumbs=array(
	'User Oauths',
);

$this->menu=array(
	array('label'=>'Create UserOauth','url'=>array('create')),
	array('label'=>'Manage UserOauth','url'=>array('admin')),
);
?>

<h1>User Oauths</h1>

<div class="view">

    	<b><?=CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?=CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?=CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?=CHtml::encode($data->user_id); ?>
	<br />

	<b><?=CHtml::encode($data->getAttributeLabel('service')); ?>:</b>
	<?=CHtml::encode($data->service); ?>
	<br />

	<b><?=CHtml::encode($data->getAttributeLabel('foreign_id')); ?>:</b>
	<?=CHtml::encode($data->foreign_id); ?>
	<br />


</div>
