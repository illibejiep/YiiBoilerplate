<?
$this->breadcrumbs=array(
	'User Oauths'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserOauth','url'=>array('index')),
	array('label'=>'Create UserOauth','url'=>array('create')),
	array('label'=>'Update UserOauth','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UserOauth','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserOauth','url'=>array('admin')),
);
?>

<h1>View UserOauth #<?=$model->id; ?></h1>

<? $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'service',
		'foreign_id',
	),
)); ?>
