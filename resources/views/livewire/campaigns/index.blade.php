<?php

use App\Models\EmailCampaign;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function delete($campaignId): void
    {
        EmailCampaign::where('id', '=', $campaignId)->delete();

    }
}; ?>

<div>
    @php
        $email_campaigns = User::findOrFail(Auth::id())
            ->email_campaigns()
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);

                    $headers = [
                            ['key' => 'id', 'label' => '#'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'actions', 'label' => '']
                    ];
    @endphp

    <x-header title="Email Campaigns" subtitle="Manage your campaigns easily!" separator/>

    <div class="flex">
        <x-button link="campaigns/create" label="Create" class="btn-primary ml-auto"></x-button>
    </div>

    <x-table with-pagination :headers="$headers" :rows="$email_campaigns">

        <x-slot:empty>
            <x-icon name="fas.address-book" label="It is empty."/>
        </x-slot:empty>

        @scope('actions', $campaign)
        <div class="flex-initial flex gap-2">
            <x-button icon="fas.chart-simple" link="campaigns/{{$campaign->id}}/stats" spinner class="btn-success btn-sm"/>
            <x-button icon="fas.eye" link="campaigns/{{$campaign->id}}" spinner class="btn-sm"/>
            <x-button icon="fas.pen-to-square" link="campaigns/{{$campaign->id}}/edit" spinner class="btn-sm"/>
            <x-button icon="fas.trash-can" wire:click="delete({{$campaign->id}})" spinner class="btn-sm btn-primary"/>
        </div>
        @endscope
    </x-table>
    <x-toast position="toast-bottom toast-center"/>


</div>
