<?
$this->breadcrumbs=array(
	'User Oauths'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserOauth','url'=>array('index')),
	array('label'=>'Create UserOauth','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-oauth-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Oauths</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?=CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    <? $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    
                    <?=$form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>
                    <?=$form->textFieldRow($model,'id',array('class'=>'span5')); ?>
                    <?=$form->textFieldRow($model,'service',array('class'=>'span5','maxlength'=>255)); ?>
                    <?=$form->textFieldRow($model,'foreign_id',array('class'=>'span5','maxlength'=>1023)); ?>
        <div class="form-actions">
        <? $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
    </div>
    <? $this->endWidget(); ?>
</div><!-- search-form -->

<? $this->widget('bootstrap.widgets.TbExtendedGridView',array(
    'fixedHeader' => true,
    'headerOffset' => 80,
	'id'=>'user-oauth-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
                array(
            'name' => 'service',
            'type' => 'raw',
        ),
                array(
            'name' => 'foreign_id',
            'type' => 'raw',
        ),
    		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
));
