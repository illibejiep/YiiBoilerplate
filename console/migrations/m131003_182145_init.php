<?php

class m131003_182145_init extends CDbMigration
{
    public function safeUp()
    {
        $dbType = $this->dbConnection->driverName;

        $initFile = Yii::getPathOfAlias('common.data') . DIRECTORY_SEPARATOR . "init.$dbType.sql";
        $sql = file_get_contents($initFile);
        foreach (explode(";\n",$sql) as $command) {
            if (!trim($command," \n\r"))
                continue;
            $this->execute($command);
        }

    }

    public function Down()
    {
        switch ($this->dbConnection->driverName) {
            case 'pgsql':
                $this->execute('DROP SCHEMA public CASCADE; CREATE SCHEMA public;');
                break;
            case 'mysql':
                $dbName = Yii::app()->db->createCommand("select database()")->query()->readColumn(0);
                $this->execute("DROP DATABASE $dbName");
                $this->execute("CREATE DATABASE $dbName;");
                break;
        }

        exit();
    }
}