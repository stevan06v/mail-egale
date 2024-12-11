<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;


new class extends Component {

    public ?string $nickname = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function save()
    {
        $validatedData = $this->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'nickname' => $this->nickname,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        Auth::login($user);

        return redirect('/greeting/'.$user->id)->with('success', 'Account created successfully!');
    }

}; ?>

<div class="max-w-sm lg:ml-40">
    <x-header title="Sign Up" subtitle="Create a new account." separator/>
    <x-form wire:submit="login">
        <x-input label="Nickname" wire:model="nickname" value="stevan06v" icon="o-envelope" inline/>
        <x-input label="E-mail" wire:model="email" value="random@random.com" icon="o-envelope" inline email/>
        <x-input label="Password" wire:model="password" value="random" type="password" icon="o-key" inline/>
        <x-input label="Retype Password" wire:model="password_confirmation" value="random" type="password" icon="o-key"
                 inline/>

        <x-slot:actions>
            <x-button label="Login" link="/login" icon="o-paper-airplane" class="btn-primary" spinner="login"/>
            <x-button label="Sign up" wire:click="save()" icon="fas.user-plus" class="btn-primary" spinner="signup"/>
        </x-slot:actions>
    </x-form>
</div>
