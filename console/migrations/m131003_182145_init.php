<?php

class m131003_182145_init extends CDbMigration
{
    public function safeUp()
    {
        $initFile = Yii::getPathOfAlias('common.data') . DIRECTORY_SEPARATOR . 'init.sql';
        $this->getDbConnection()->getPdoInstance()->exec(file_get_contents($initFile));
    }

    public function Down()
    {
        $this->dbConnection->getPdoInstance()->exec('DROP SCHEMA public CASCADE; CREATE SCHEMA public;');
        echo 'we have clean database'.PHP_EOL;
        exit();
    }
}