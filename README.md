### Новая система конфигурации
Yii.php подгружается после иниции общей конфигурации, что позволяет определять константы yii и различные системные функции в main-env.php и main-local.php.
В файлах main-env.php и main-local.php доступна переменая $config, что, в отличии от CMap::merge(), позволяет удалять ключи из конфига.

![config](https://raw.github.com/profet9/YiiBoilerplate/master/doc/config.png)

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

### Giiy

Это CRUD&Model-генератор основаный на giix и bootstrap-gii. Непонятный, запунанный, содержащий гетерогенный код и даже php-шаблоны гетерогенного кода, что делает его поддержку немыслемой.
Тем не менее имеет следующюю структуру:

	/
    backend/
        components/
            CRUDController.php - базовый класс для контроллеров бэкэнда
            ModelForm.php - компонент форм (расширение TbActiveForm)
        extensions/
            giiy/ - сам экстеншин
        views/
            {modelName}/
                _base/ - папка сгенерированных шаблонов (по умолчанию подключаются в основных)
                    admin.php - шаблон с датагридом
                    create.php - шаблон создания модели
                    form.php - шаблон формы
                    index.php - не используется
                    update.php - обновление
                    view.php - просмотр модели
                admin.php - шаблон с датагридом
                create.php - шаблон создания модели
                form.php - шаблон формы
                index.php - не используется
                update.php - обновление
                view.php - просмотр модели
        widgets/
            js/
                modelForm.js - js для modelForm
            views/
                ModelFileUpload/
                    file.php - вьюха виджета ModelFileUpload
                ModelFileUpload.php - виджет файла
    common/
        components/
            interfaces/ - папка с описаниями интерфейсов
                IFileBased.php - модель, использующая или представляющая файл
                Iillustrated.php - модель с картинкой
                ITypeEnumerable.php - модель имеющая тип, описываемый классом {modelName}TypeEnum
            ActiveRecord.php - расширение класса CActiveRecord содержащий вспомогательные методы.
        models/ - папка, содержащая сгенерированные модели и классы
            _base/ - сгенерированные классы моделей (перезаписываются)
            enum/ - сгенерированные enum-классы (только создаются)
            {modelName}.php - сгенерированные классы моделей, наследующиеся от базовых (только создаются)

Как будет время сделаю отдельным экстеншином.

##### CRUD + Upload.
CRUD-контроллеры наследуются от общего класса **CDURController**, в котором реализованы экшены **Create**, **Reade**, **Update**, **Delete** и **Upload**. Для AJAX-запросов возвращатся JSON. Экшен **Upload** используется только для моделей, реализующих интерфейс **IFileBased**. CRUD-контроллеры используют виджет **ModelForm** - расширенный **TbActiveForm**.
Новые методы виджета формы:

* **enum($attribute)** - значения из {ModelName}{AttributeName}Enum класса.
* **params()** - поле с набором динамических параметров модели.
* **date($attribute),time($attribute),datetime($attribute)** - 'date','time','datetime' pickers
* **elementTypes($attribute)** - Костыльный виджет для MANY_TO_MANY связей с {ModelName}TypeEnum классом.
* **tags($attribute)** - Список значений, с текстовыми разделителями.
* **editor($attribute)** - ckeditor.
* **relation($attribute)** - связанные модели.
* **relationForm($attribute)** - связанные модели с формой для их редактирования.
* **input($attribute)** - текстовое поле.
* **text($attribute)** - textarea.
* **check($attribute)** - checkbox.
* **submitButton()** - submit button.

Методы TbActiveForm работают, но последствия не известны.
В CRUD-контроллерах есть экшин Form, используемый методом relationForm для отображения формы создания и редактирования связанных моделей. Он отрисовывает форму на пустом лейауте и принимает 2 параметра: id модели и название модели, для релейшина которой отрисовывается форма.

##### Модели.

Модели насделются от класса ActiveRecord, в котором подключается **EActiveRecordRelationBehavior**, реализованны методы JSON-сериализации, created-modified и вспомогательные методы.

##### JSON-сериализация.

ActiveRecord реализует интерфейс JsonSerializable. Для JSON-данных модели формируются дополнительные поля:

* **_modelName** - имя класса модели.
* **_viewName** - отображаемое имя модели.
* **_picture** - url-адрес изображения модели.
* **_url** - url-адрес модели.

##### Вспомогательные методы.

* **getRelationNames($relationName,$asTable)** - возвращает массив id => name для релейшина $relationName. Если параметр $asTable = true, то возвращает таблицу с данными релейшина.
* **getRelationIds($relationName)** - возвращает массив первичных ключей решейшина.
* **toArray()** - преобразует данные модели в массив с дополнительными полями.

##### Кодогенератор.

Используемые модели наследуются от сгенерированных, чтобы их перегенерация не затирала имеющийся функционал.
Если файла модели нет, то он создается автоматически. CRUD-генератор создает контроллеры, только если они отсутсвуют. Вьюхи делятся на базовые, которые перезаписываются генератором, и основные, которые создаются только при их отсутствии и подключают базовые файлы.

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