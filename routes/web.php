<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', function (){
    if(Auth::check()){
        return Redirect::to('lists');
    }
    return Redirect::to('login');
});

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
});

# auth
Volt::route('/login', 'auth.login')->name('auth.login');
Volt::route('/signup', 'auth.signup')->name('auth.signup');


Route::middleware('auth')->group(function () {
    # blacklists
    Volt::route('/blacklists', 'blacklists.index')->name('blacklists.index');
    Volt::route('/blacklists/create', 'blacklists.create')->name('blacklists.create');
    Volt::route('/blacklists/{blacklist}', 'blacklists.show')->name('blacklists.show');
    Volt::route('/blacklists/{blacklist}/edit', 'blacklists.edit')->name('blacklists.edit');

    # jobs
    Volt::route('/jobs', 'jobs.index')->name('jobs.index');
    Volt::route('/jobs/create', 'jobs.create')->name('jobs.create');
    Volt::route('/jobs/{job}', 'jobs.show')->name('jobs.show');
    Volt::route('/jobs/{job}/edit', 'jobs.edit')->name('jobs.edit');

    # lists
    Volt::route('/lists', 'lists.index')->name('lists.index');
    Volt::route('/lists/create', 'lists.create')->name('lists.create');
    Volt::route('/lists/{list}', 'lists.show')->name('lists.show');
    Volt::route('/lists/{list}/edit', 'lists.edit')->name('lists.edit');

    # profiles
    Volt::route('/templates', 'templates.index')->name('templates.index');
    Volt::route('/templates/create', 'templates.create')->name('templates.create');
    Volt::route('/templates/{template}', 'templates.show')->name('templates.show');
    Volt::route('/templates/{template}/edit', 'templates.edit')->name('templates.edit');


    # profiles
    Volt::route('/profiles', 'profiles.index')->name('profiles.index');
    Volt::route('/profiles/create', 'profiles.create')->name('profiles.create');
    Volt::route('/profiles/{profile}', 'profiles.show')->name('profiles.show');
    Volt::route('/profiles/{profile}/edit', 'profiles.edit')->name('profiles.edit');

    # users
    Volt::route('/users', 'users.index')->name('users.index');
    Volt::route('/users/create', 'users.create')->name('users.create');
    Volt::route('/users/{user}', 'users.show')->name('users.show');
    Volt::route('/users/{user}/edit', 'users.edit')->name('users.edit');

    # plans
    Volt::route('/plans', 'plans.index')->name('plans.index');
    Volt::route('/plans/create', 'plans.create')->name('plans.create');
    Volt::route('/plans/{plan}', 'plans.show')->name('plans.show');
    Volt::route('/plans/{plan}/edit', 'plans.edit')->name('plans.edit');
});
