<?php

namespace App\Helpers;

use Illuminate\Html\HtmlBuilder;

class Helper {
    public static function linkActive(string $name, string $title = null, array $parameters = array(), array $attributes = array())
    {
        return '<li class="' . Route::currentRouteNamed($name) ? 'active' : '' . '" role="presentation">' . linkRoute($name, $title, $parameters, $attributes) .'</li>';
    }
}
