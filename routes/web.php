<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'users.index');

# auth
Volt::route('/login', 'auth.login')->name('login');
Volt::route('/signup', 'auth.signup')->name('signup');


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


    # lists
    Volt::route('/lists', 'lists.index')->name('lists.index');
    Volt::route('/lists/create', 'lists.create')->name('lists.create');
    Volt::route('/lists/{list}', 'lists.show')->name('lists.show');
    Volt::route('/lists/{list}/edit', 'lists.edit')->name('lists.edit');
});
