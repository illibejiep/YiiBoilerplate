<?
$this->breadcrumbs=array(
	'Pictures'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Picture','url'=>array('index')),
	array('label'=>'Create Picture','url'=>array('create')),
);
?>

<h1>Manage Pictures</h1>

<?

if (Yii::app()->getModule('giiy')->useBootstrap)
    require('_bootstrapGrid.php');
else
    require('_grid.php');

?>