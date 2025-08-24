<?php

use App\Models\EmailCampaign;
use App\Models\EmailConfiguration;
use App\Models\EmailList;
use App\Models\EmailTemplate;
use App\Models\User;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {

    use Toast;

    public User $user;

    public $emailTemplates;
    public $emailConfigurations;
    public $emailLists;
    public DateTime $scheduleTime;
    public ?int $batchSize;
    public ?int $batchIntervall;
    public ?int $timeoutPerEmail;
    public string $name;
    public string $subject;
    public string $fromName;
    public string $fromEmail;

    public $selectedEmailConfiguration;
    public $selectedEmailTemplate;
    public $selectedEmailList;


    public $selectedTab = "general-tab";

    public function mount(): void
    {

        $this->user = Auth::user();

        $this->emailConfigurations = $this->user->email_configurations;
        $this->emailLists = $this->user->email_lists;
        $this->emailTemplates = $this->user->email_templates;
    }

    public function save()
    {
        # $this->validate();
        EmailCampaign::create([
            "name" => $this->name,
            "email_configuration_id" => $this->selectedEmailConfiguration,
            "email_template_id" => $this->selectedEmailTemplate,
            "schedule_time" => $this->scheduleTime,
            "subject" => $this->subject,
            "from_email" => $this->fromEmail,
            "user_id" => $this->user->id
        ]);


        $this->success("Successfully created the list!", position: 'toast-bottom toast-right');
    }
}; ?>
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <x-header
        title="Create Email Campaign"
        subtitle="Set up your email campaign with configuration, template, and scheduling options."
        separator
    />

    <x-tabs wire:model="selectedTab">
        <x-tab name="general-tab" label="General" icon="o-users">
            <x-form wire:submit="save" class="space-y-6">
                <x-input label="Campaign name" wire:model="name"/>
                <x-input label="Subject" wire:model="subject"/>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input label="Sender Email" wire:model="fromEmail"/>
                    <x-datetime label="Date + Time" wire:model="scheduleTime" type="datetime-local"/>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select label="Email Configuration" wire:model="selectedEmailConfiguration"
                              placeholder-value="0"
                              placeholder="Select an email configuration"
                              :options="$emailConfigurations" icon="o-user"/>
                    <x-select label="Email Template" wire:model="selectedEmailTemplate"
                              placeholder-value="0"
                              placeholder="Select an email template"
                              :options="$emailTemplates" icon="o-user"/>

                </div>

                <div>
                    <x-select label="Email List" wire:model="selectedEmailList" placeholder="Select an email list"
                              placeholder-value="0"
                              :options="$emailLists" icon="o-user"/>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <x-button label="Back" class="btn-outline" link="/campaigns" spinner="back"/>
                    <x-button label="Create" class="btn-primary" type="submit" spinner="create"/>
                </div>
            </x-form>

        </x-tab>
        <x-tab name="tricks-tab" label="Extras" icon="o-sparkles">
            <div>Extras</div>
        </x-tab>

    </x-tabs>


    <x-toast position="toast-bottom toast-right"/>
</div>
