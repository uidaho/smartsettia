<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fixes incompatibility with MySQL < 5.7.7
        Schema::defaultStringLength(191);

        // Create {{ $view_name }} provider in blade templates
        view()->composer('*', function($view) {
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
        });

        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $value) && strlen($value) >= 10;
        });

        Validator::replacer('phone', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid phone number');
        });
    
        //Validator rule for names
        Validator::extend('name', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[[:alnum:]])([\w\-\.\' ]*)([\w\-\.\']$)#', $value);
        });
    
        Validator::replacer('name', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use letters, numbers, underscores, dashes, spaces, periods and it must start with a letter or number');
        });
    
        //Validator rule for user full names
        Validator::extend('full_name', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[[:alpha:]])([[:alpha:]\_\-\. ]*)([[:alpha:]\_\-\.]$)#', $value);
        });
    
        Validator::replacer('full_name', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use letters, underscores, dashes, spaces, periods and it must start with a letter');
        });
    
        //Validator rule for values
        Validator::extend('value_string', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[[:alnum:]\+\-])([\w\+\-\.\'\, ]*$)#', $value);
        });
    
        Validator::replacer('value_string', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use alphanumerics spaces +-_.\', and it must start with a alphanumeric or a plus or minus');
        });
    
        //Validator rule for types
        Validator::extend('type_name', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[[:alpha:]\_])([\w]*$)#', $value);
        });
    
        Validator::replacer('type_name', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use alphanumerics, underscores and it must start with a letter or underscore');
        });
    
        //Validator rule for error messages
        Validator::extend('error_string', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[\w])([\w\-\.\'\, ]*$)#', $value);
        });
    
        Validator::replacer('error_string', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use alphanumerics spaces _.\', and it must start with a alphanumeric or underscore');
        });
    
        //Validator rule for mac addresses
        Validator::extend('mac', function($attribute, $value, $parameters, $validator) {
            return preg_match('#^(([[:xdigit:]]{2}){6})$#', $value);
        });
    
        Validator::replacer('mac', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you must provide a valid mac address like 000000000000');
        });
    
        //Validator rule for versions
        Validator::extend('version', function($attribute, $value, $parameters, $validator) {
            return preg_match('#(^[0-9])(([\+\-\.][[:alnum:]]+)*$)#', $value);
        });
    
        Validator::replacer('version', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you can only use alphanumerics +-. and it must start with a number and end with an alphanumeric');
        });
    
        //Validator rule for uuid
        Validator::extend('uuid', function($attribute, $value, $parameters, $validator) {
            return preg_match('#^([[:xdigit:]]{8})(-[[:xdigit:]]{4}){3}(-[[:xdigit:]]{12})$#', $value);
        });
    
        Validator::replacer('uuid', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid you must provide five groups of hexadecimals in the form 8-4-4-4-12');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
