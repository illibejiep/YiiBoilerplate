# Новая система конфигурации
Yii.php подгружается после иниции общей конфигурации, что позволяет определять константы yii и различные системные функции в main-env.php и main-local.php.
В файлах main-env.php и main-local.php доступна переменая $config, что, в отличии от CMap::merge(), позволяет удалять ключи из конфига.

![config](https://raw.github.com/profet9/YiiBoilerplate/master/doc/config.png)