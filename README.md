ADD em app/provider/EventServiceProvider


```<?php

protected $listen = [

        'App\Events\HomeEvent'=> [
            'App\Listeners\HomeEventListener',
            'App\Listeners\NewHomeListener',
        ],

        'Illuminate\Auth\Events\Login' => [

            'App\Listeners\LoginListener',
        ],

]




Após isso, execute no terminal bass o comando:

php artisan event:generate

php artisan make:listener NewHomeListener

php artisan make:mail NovoAcesso
