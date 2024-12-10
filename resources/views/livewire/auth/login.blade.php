<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {


    public function mount(){

    }

}; ?>

<div class="max-w-sm lg:ml-40">


    <x-header title="Login" subtitle="Login into your existing account." separator />
    <x-form wire:submit="login">
        <x-input label="E-mail" value="random@random.com" icon="o-envelope" inline />
        <x-input label="Password" value="random" type="password" icon="o-key" inline />

        <x-slot:actions>
            <x-button label="Sign up" link="/signup" icon="fas.user-plus" class="btn-primary" spinner="signup" />
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>

    </x-form>

</div>
