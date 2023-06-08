<?php

return [
    'default_limit' => 10,

    /*
    |----------------------------------------------------
    | Default pagination type if it's not set in request.
    |----------------------------------------------------
    |
    | Available types: "offset", "cursor".
    |
    */
    'default_type' => 'offset',
];

$some = '
Описываю папочную структуру пустого проекта как шаблона на laravel, где настроено в формате RestfullApi
Swagger, также где есть авторизация через Laravel Sanctum, подтверждение почты и сброс пароля.

app/Domain
app/Domain/{db schema name}/Actions
app/Domain/Account/Actions/Profiles
app/Domain/Account/Actions/Users
app/Domain/Account/Models

app/Http
app/Http/Modules/{db schema name}
app/Http/Modules/{db schema name}/Controllers
app/Http/Modules/{db schema name}/Queries
app/Http/Modules/{db schema name}/Requests
app/Http/Modules/{db schema name}/Resources

app/Http
app/Http/Modules/Account
app/Http/Modules/Account/Controllers
app/Http/Modules/Account/Queries
app/Http/Modules/Account/Requests
app/Http/Modules/Account/Resources

app/Http
app/Http/Modules/Public
app/Http/Modules/Public/Controllers
app/Http/Modules/Public/Queries
app/Http/Modules/Public/Requests
app/Http/Modules/Public/Resources

app/Domain/Public
app/Domain/Public/Actions/Media


Настроен Swagger
Для авторизации используется Spatie Auth
Для формирования ReastAPI используеться

Сформируй описание папочной структуры для документации проекта в формате файла md
';



