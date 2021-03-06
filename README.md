# Emailer

Сервис для генерации HTML писем и отправки их получателям. Генерация идет аналогично стандартному рендерингу в фреймворке.

будет ряд усовершенствований, например, выбор типа адаптера отправления письма и т.д.

Установка: composer require masterflash-ru/emailer

Для админки доступен интерфейс редактирования записей в базе - "Редактирование шаблонов писем с сайта"

После установки загрузите дамп в базу из папки data.

Создается плагин контроллеров Emailer:

```php
//обращение в контроллере
$this->Emailer($nameOrModel,$values, $toEmails, $options);

//если ничего не передавать, возращает сам объект 
$emailer=$this->Emailer();
```
$nameOrModel - экземпляр ViewModel, как в контроллере, или имя шаблона (сценария вывода) в терминологии ZF3.
Поиск ведется по имени вначале в базе данных, если не найдено, то среди файлов. Путь к файлу указывается так же как принято в ZF3;

$values - массив со значениями в шаблон, но если $nameOrModel был строкой;

$toEmails - строка или массив Email получателей;

$options - опции, массив, ключи: subject - тема сообщения, mailfrom - обратный адрес письма

Функции плагина контроллера Emailer:

Вызов | описание
------|--------------
setOptions(array $options):void | Задать опции, поддерживаются  subject, mailfrom
Render($nameOrModel,$values = null):string | Рендер, обрабатывает шаблон-сценарий вывода, $nameOrModel - экземпляр ViewModel или имя шаблона, $values - значения передаваемые в шаблон
setToEmails($toEmails):void | Задать адрес/адреса получателей, строка или массив
getToEmails():array | получить массив Email получателей
setSubject(string $Subject):void | Установить тему письма
getSubject():string | Получить тему письма
setMailFrom(string $mailFrom):void | Установить обратный Email
getmailFrom():string | Получить Email обратного адреса
sendEmail(string $message, $toEmails=null):void | отправить письмо, $message - строка HTML письма, $toEmails - получатель/получатели, если пусто, то нужно указать при помощи функции setToEmails

В конфигурации вашего приложения должна быть указана конфигурация коннекта к базе данных 'DefaultSystemDb', например,
```php
return [
    "databases"=>[
        //соединение с базой + имя драйвера
        'DefaultSystemDb' => [
            'driver'=>'MysqlPdo',
            //"unix_socket"=>"/tmp/mysql.sock",
            "host"=>"localhost",
            'login'=>"login",
            "password"=>"password",
            "database"=>"simba4",
            "locale"=>"ru_RU",
            "character"=>"utf8"
        ],
    ],

.....
];
```

### Важное замечание

Для включения изображений в HTML письма, следует указывать там абсолютные адреса, 
использовать помощник View-а ServerUrl(), например, 
```html
<img src="<?=$this->ServerUrl($this->$this->basePath("image/pic.jpg"))?>" alt="">
```

Для работы с базой в конфиге приложения должно быть объявлено DefaultSystemDb:
```php
......
    "databases"=>[
        //соединение с базой + имя драйвера
        'DefaultSystemDb' => [
            'driver'=>'MysqlPdo',
            //"unix_socket"=>"/tmp/mysql.sock",
            "host"=>"localhost",
            'login'=>"root",
            "password"=>"**********",
            "database"=>"simba4",
            "locale"=>"ru_RU",
            "character"=>"utf8"
        ],
    ],
.....
```
для работы с кешем аналогично:
```php
.....
    'caches' => [
        'DefaultSystemCache' => [
            'adapter' => [
                'name'    => Filesystem::class,
                'options' => [
                    // Store cached data in this directory.
                    'cache_dir' => './data/cache',
                    // Store cached data for 3 hour.
                    'ttl' => 60*60*2 
                ],
            ],
            'plugins' => [
                [
                    'name' => Serializer::class,
                    'options' => [
                    ],
                ],
            ],
        ],
    ],
.....
```

