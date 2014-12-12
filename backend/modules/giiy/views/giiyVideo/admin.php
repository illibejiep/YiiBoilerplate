<?
$this->breadcrumbs=array(
	'Videos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Video','url'=>array('index')),
	array('label'=>'Create Video','url'=>array('create')),
);
?>

<h1>Manage Videos</h1>

<?

if (Yii::app()->getModule('giiy')->useBootstrap)
    require('_bootstrapGrid.php');
else
    require('_grid.php');

?>