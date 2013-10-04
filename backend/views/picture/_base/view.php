<?
$this->breadcrumbs=array(
	'Pictures'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Picture','url'=>array('index')),
	array('label'=>'Create Picture','url'=>array('create')),
	array('label'=>'Update Picture','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Picture','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Picture','url'=>array('admin')),
);
?>

<h1>View Picture #<?=$model->id; ?></h1>

<? $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'type_enum',
		'name',
		'width',
		'height',
		'created',
		'modified',
		'description',
		'announce',
	),
)); ?>
