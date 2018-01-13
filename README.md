### Новая система конфигурации
Yii.php подгружается после иниции общей конфигурации, что позволяет определять константы yii и различные системные функции в main-env.php и main-local.php.
В файлах main-env.php и main-local.php доступна переменая $config, что, в отличии от CMap::merge(), позволяет удалять ключи из конфига.

![config](https://github.com/illibejiep/YiiBoilerplate/blob/master/doc/config.png?raw=true)

При разделении приложения на common и остальное все, что находится в common перестает быть частью приложения и необходимо прописывать алиас до нужной папки. В результате множество модулей и расширений yii перестают работать, если их переложить в common. Наверно самый простой способ это исправить это переопределить методы Yii::getPathOfAlias() и Yii::import(). Метод Yii::getPathOfAlias() возвращает путь для common, если соответствующая директория или класс отсутствуют в папке приложения. Yii::import() переопределен так, что класс сначала ищется в папке приложения, а потом в common. В результате для приложения все выглядит так, как-буддто модули и расширения из common являются частью приложения.

### Расширения
* [yiiBooster](http://yii-booster.clevertech.biz/)
- [cfile](http://www.yiiframework.com/extension/cfile/)
- [mail](http://www.yiiframework.com/extension/mail/)
- [curl](http://www.yiiframework.com/extension/curl/)
- [dgsphinxsearch](http://www.yiiframework.com/extension/dgsphinxsearch/)
- [yandexmap](http://www.yiiframework.com/extension/yandexmap/)
- [jquery-gmap](http://www.yiiframework.com/extension/jquery-gmap/)
- модифицированный [yii-user](http://www.yiiframework.com/extension/yii-user/) (удалена модель profile)
- модифицированный [rights](http://www.yiiframework.com/extension/rights/) (интегрирован с yii-user)
- [eauth](https://github.com/Nodge/yii-eauth) + [eoauth](https://github.com/jorgebg/yii-eoauth) + [lightopenid](http://www.yiiframework.com/extension/loid)
- модифицированный [image](http://www.yiiframework.com/extension/image/) вот [этот](https://bitbucket.org/z_bodya/yii-image) форк (добавлена поддержка bmp)
- модифицированный [activerecord-relation-behavior](http://www.yiiframework.com/extension/activerecord-relation-behavior)
- [datetimepicker](http://www.yiiframework.com/extension/datetimepicker/)
- модифицированный [ffmpeg-php](http://github.com/CodeScaleInc/ffmpeg-php)
- (jwplayer)[http://www.longtailvideo.com/jw-player]
- [yii-debug-toolbar](http://www.yiiframework.com/extension/yii-debug-toolbar/)
- [giiy](https://github.com/profet9/giiy)

### Как пощупать (потрогать).

Скачиваем проект своим любимым способом в свою любимую папку для проектов.
```
    git clone https://github.com/profet9/YiiBoilerplate.git
```
Настраиваем свой вэб-сервер.

Запускаем скрипт деплоя с нужным окружением.
```
    ./runpostdeploy dev
```

Прописываем в конфиге свою базу данных и остальные параметры. Например так:
```php
// in common/config/main-local.php
$config['components']['db'] = array(
    'connectionString' => 'pgsql:host=localhost;dbname=yii',
    'emulatePrepare' => false,
    'username' => 'pgsql',
    'charset' => 'utf8',
    'enableParamLogging' => true,
    'enableProfiling' => true,
    'tablePrefix' => '',
);
unset($config['components']['db']['password']);
$config['params'] = array(
    'frontendUrl' => 'http://www.yii.local',
    'backendUrl'  => 'http://admin.yii.local',
);
```

Запускаем миграции.
```
    ./yiic migrate
```

Теперь, если повезло, в бэкэнде можно заливать картинки и видео. А также прикреплять картинки в качестве превью к видео. В фронтэнде ничего интересного.

Для примера сделаем каталог товаров.

создадим миграции:
```
    ./yiic migrate create catalog
```

```php
// in migration file
public function safeUp()
{
    $this->createTable('catalog',array(
        'id' => 'serial PRIMARY KEY', // for mysql 'integer AUTO_INCREMENT PRIMARY KEY'
        'parent_id' => 'integer REFERENCES catalog ON UPDATE CASCADE ON DELETE CASCADE',
        'picture_id' => 'integer REFERENCES picture ON UPDATE CASCADE ON DELETE SET NULL',
        'name' => 'varchar',
        'description' => 'text',
    ));

    $this->createIndex('catalog_parent_idx','catalog','parent_id');
    $this->createIndex('catalog_picture_idx','catalog','picture_id');

    $this->createTable('item', array(
        'id' => 'serial PRIMARY KEY', // for mysql 'integer AUTO_INCREMENT PRIMARY KEY'
        'catalog_id' => 'integer REFERENCES catalog ON UPDATE CASCADE ON DELETE SET NULL',
        'picture_id' => 'integer REFERENCES picture ON UPDATE CASCADE ON DELETE SET NULL',
        'name' => 'varchar',
        'price' => 'float',
        'description' => 'text',
    ));

    $this->createIndex('item_catalog_idx','item','catalog_id');
    $this->createIndex('item_picture_idx','item','picture_id');
}

public function safeDown()
{
    $this->dropTable('item');
    $this->dropTable('catalog');
}

```

По адресу {backendUrl}/gii в разделе "GiiyModel Generator" генерим модели. Реализуем в моделях интерфейс Iillustrated

```php

// in common/models/Catalog.php
class Catalog extends BaseCatalog implements Iillustrated
{
    /** @return Catalog */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

    /** @return Picture|null */
    public function getPicture()
    {
        return $this->getRelated('picture');
    }

}

```

```php

// in common/models/Item.php
class Item extends BaseItem implements Iillustrated
{
    /** @return Item */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

    /** @return Picture|null */
    public function getPicture()
    {
        return $this->getRelated('picture');
    }
}
```

И сгенерим CRUD-контроллеры в разделе "GiiyCrud Generator".

Прописываем новые контроллеры в меню.

```php

//somewere in backend/view/main.php
'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => array(
                array('label' => 'Pictures', 'url' => array('/Picture')),
                array('label' => 'Videos', 'url' => array('/Video')),
                array('label' => 'Catalog', 'url' => array('/Catalog')),
                array('label' => 'Item', 'url' => array('/Item')),
            ),
        ),
//...
```

Теперь вполне реально работать над каталогом товаров.
