<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;


new class extends Component {
    //
}; ?>

<div class="max-w-sm lg:ml-40">
    <x-header title="Sign Up" subtitle="Create a new account." separator/>
    <x-form wire:submit="login">
        <x-input label="Nickname" value="stevan06v" icon="o-envelope" inline/>
        <x-input label="E-mail" value="random@random.com" icon="o-envelope" inline email/>
        <x-input label="Password" value="random" type="password" icon="o-key" inline/>
        <x-input label="Retype Password" value="random" type="password" icon="o-key" inline/>

        <x-slot:actions>
            <x-button label="Login" link="/login" icon="o-paper-airplane" class="btn-primary" spinner="login"/>
            <x-button label="Sign up" type="submit" icon="fas.user-plus" class="btn-primary" spinner="login"/>
        </x-slot:actions>
    </x-form>
</div>
