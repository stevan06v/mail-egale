<?php

use App\Models\EmailList;
use Livewire\Volt\Component;

new class extends Component {

    public EmailList $email_list;
    public ?string $name;
    public ?string $email_column_name;
    public ?string $name_column_name;

    public function mount($id)
    {
        $this->email_list = EmailList::find($id);
        $this->name = $this->email_list->name;
        $this->email_column_name = $this->email_list->email_column_name;
        $this->name_column_name = $this->email_list->name_column_name;
        $this->emails = $this->email_list->email_entries()->get()->toArray();
    }

}; ?>

<div>
    <livewire:lists.components.email-list :email-list="$email_list"/>
</div>
