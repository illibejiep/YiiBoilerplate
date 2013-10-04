<?php

Yii::import('gii.generators.crud.CrudGenerator');

class GiiyCrudGenerator extends CrudGenerator
{
	public $codeModel = 'ext.giiy.giiyCrud.GiiyCrudCode';

    protected function getModels() {
        $models = array();
        $files = scandir(Yii::getPathOfAlias('application.models'));
        foreach ($files as $file) {
            if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
                $fileClassName = substr($file, 0, strpos($file, '.'));
                if (class_exists($fileClassName) && is_subclass_of($fileClassName, 'ActiveRecord')) {
                    $fileClass = new ReflectionClass($fileClassName);
                    if (!$fileClass->isAbstract() && !is_array(ActiveRecord::model($fileClassName)->getPrimaryKey()))
                        $models[] = $fileClassName;
                }
            }
        }

        $files = scandir(Yii::getPathOfAlias('common.models'));
        foreach ($files as $file) {
            if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
                $fileClassName = substr($file, 0, strpos($file, '.'));
                if (class_exists($fileClassName) && is_subclass_of($fileClassName, 'ActiveRecord')) {
                    $fileClass = new ReflectionClass($fileClassName);
                    if (!$fileClass->isAbstract() && !is_array(ActiveRecord::model($fileClassName)->getPrimaryKey()))
                        $models[] = $fileClassName;
                }
            }
        }

        return $models;
    }
}