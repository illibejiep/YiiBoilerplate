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

