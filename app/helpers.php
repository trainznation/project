<?php
if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return Route::currentRouteNamed($route) ? 'active' : '';
    }
}
