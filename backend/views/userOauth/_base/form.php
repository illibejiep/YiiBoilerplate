<? $form = $this->beginWidget('ModelForm',array('model'=>$model,'fromModel' => isset($fromModel)?$fromModel:null)); ?><div>
    <?=$form->errorSummary($form->model);?></div>
    <?=$form->input('service'); ?>
    <?=$form->input('foreign_id'); ?>
    <?=$form->relation('user'); ?>
<?=$form->submitButton(); ?>
<? $this->endWidget(); ?>