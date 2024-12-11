<?php

use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Livewire\Volt\Component;

new class extends Component {
    public ?User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function start()
    {
        return Redirect::to('lists');
    }


}; ?>

<div>
    <x-header title="Greetings, {{$user->nickname}} 👋!" subtitle="You are ready to use maileagle now!" separator/>

    <img class="w-5/12" src="/images/greetings.svg" alt="greetings.svg">

    <a href="https://websters.at/" target="_blank">
        <x-button label="Our Company"/>
    </a>
    <x-button label="Start using" wire:click="start()" class="btn-primary"/>
</div>
