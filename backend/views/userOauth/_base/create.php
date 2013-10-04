<?
$this->breadcrumbs=array(
	'User Oauths'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserOauth','url'=>array('index')),
	array('label'=>'Manage UserOauth','url'=>array('admin')),
);
?>

<h1>Create UserOauth</h1>

<? require(__DIR__.'/../form.php');?>