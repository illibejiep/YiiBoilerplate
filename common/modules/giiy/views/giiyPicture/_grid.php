<? $this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'picture-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'columns'=>array(
        array(
            'type' => 'raw',
            'value' => '"<img src=\"".($data->picture?$data->picture->resize(180,120):null)."\">"',
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
        ),
        array(
            'name' => 'type_enum',
            'value' => 'GiiyPictureTypeEnum::$names[$data->type_enum]',
        ),
        array(
            'name' => 'width',
            'type' => 'raw',
        ),
        array(
            'name' => 'height',
            'type' => 'raw',
        ),
        array(
            'name' => 'created',
            'type' => 'raw',
        ),
        array(
            'name' => 'modified',
            'type' => 'raw',
        ),
        array(
            'class'=>'zii.widgets.grid.CButtonColumn',
        ),
    ),
));