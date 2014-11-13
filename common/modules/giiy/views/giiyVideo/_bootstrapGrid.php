<? $this->widget('bootstrap.widgets.TbExtendedGridView',array(
    'fixedHeader' => true,
    'headerOffset' => 80,
    'id'=>'video-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'bootstrap.widgets.TbImageColumn',
            'imagePathExpression'=>'$data->picture?$data->picture->resize(180,120):null',
            'placeKittenSize' => '180/120',
            'htmlOptions' => array(
                'width' => 200,
                'height' => 140,
            ),
        ),
        array(
            'name' => 'type_enum',
            'value' => 'VideoTypeEnum::$names[$data->type_enum]',
        ),
        array(
            'name' => 'name',
            'value' => '"<a href=\"/giiy/GiiyVideo/update/$data->id\">$data->name</a>"',
            'type' => 'raw',
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
            'name' => 'duration',
            'type' => 'raw',
        ),
        array(
            'name' => 'bit_rate',
            'type' => 'raw',
        ),
        array(
            'name' => 'codec',
            'type' => 'raw',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
