<?php
Yii::import('gii.generators.crud.CrudCode');

class GiiyCrudCode extends CrudCode
{
    public $models = array();
    /** @var  GiiyModule */
    public $giiyModule;

    public function init()
    {
        $this->giiyModule = Yii::app()->getModule('giiy');
        parent::init();
    }


    public function rules()
    {
        return array(
            array('template', 'required'),
            array('template', 'validateTemplate', 'skipOnError'=>true),
            array('template,models', 'sticky'),
            array('models','type','type'=>'array'),
        );
    }


	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}')";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if ($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5'))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5','maxlength'=>$column->size))";
		}
	}

    public function requiredTemplates()
    {
        return array(
            'controller.php',
        );
    }

    public function getTableSchema()
    {
        return CActiveRecord::model($this->model)->tableSchema;
    }

    public function getModelClass()
    {
        return @Yii::import($this->model,true);
    }


    public function prepare()
    {
        $this->files=array();
        foreach ($this->models as $model) {

            $this->model = $model;
            $this->controller = $model;

            $templatePath=$this->templatePath;
            $controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';
            if (!file_exists($this->controllerFile) ||
                strpos(file_get_contents($this->controllerFile),' extends GiiyCRUDController') === false)
            {
                $this->files[]=new CCodeFile(
                    $this->controllerFile,
                    $this->render($controllerTemplateFile)
                );
            }

            $files=scandir($templatePath);
            foreach($files as $file)
            {
                if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
                {
                    $this->files[]=new CCodeFile(
                        $this->viewPath.DIRECTORY_SEPARATOR.'_base'.DIRECTORY_SEPARATOR.$file,
                        $this->render($templatePath.'/_base/'.$file)
                    );

                    if (!file_exists($this->viewPath.DIRECTORY_SEPARATOR.$file))
                        $this->files[]=new CCodeFile(
                            $this->viewPath.DIRECTORY_SEPARATOR.$file,
                            $this->render($templatePath.DIRECTORY_SEPARATOR.$file)
                        );
                }
            }
        }

    }

    protected function generateClassName($tableName)
    {

        $className='';
        foreach(explode('_',$tableName) as $name)
        {
            if($name!=='')
                $className.=ucfirst($name);
        }
        return $className;
    }
}
