<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {

    use Toast;
    public ?string $email;
    public ?string $password;


    public function save()
    {


        $validatedData = $this->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|unique:users,email',
        ]);

        $user = User::where("email", "=", $this->email)->first();

        if ($user) {
            Auth::login($user);
            return Redirect::to('greeting/' . $user->id);
        } else {
            $this->error("User not found. Please sign up!", position: 'toast-bottom toast-end');
        }
    }

}; ?>

<div class="max-w-sm lg:ml-40">


    <x-header title="Login" subtitle="Login into your existing account." separator/>
    <x-form wire:submit="login">
        <x-input label="E-mail" wire:model="email" value="random@random.com" icon="o-envelope" inline/>
        <x-input label="Password" wire:model="password" value="random" type="password" icon="o-key" inline/>

        <x-slot:actions>
            <x-button label="Sign up" link="/signup" icon="fas.user-plus" class="btn-primary" spinner="signup"/>
            <x-button label="Login" wire:click="save()" icon="o-paper-airplane" class="btn-primary" spinner="login"/>
        </x-slot:actions>

    </x-form>

</div>
