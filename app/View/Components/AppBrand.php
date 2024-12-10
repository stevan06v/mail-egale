<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <a href="/" wire:navigate>
                    <!-- Hidden when collapsed -->
                    <div {{ $attributes->class(["hidden-when-collapsed"]) }}>
                        <div class="flex items-center gap-2">
                            <img src="/images/mail-eagle-logo.svg" alt="logo" class="w-9 max-w-full h-auto">
                            <span class="font-bold text-2xl me-3 bg bg-clip-text">
                                maileagle
                            </span>
                        </div>
                    </div>

                    <!-- Display when collapsed -->
                    <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
                            <img src="/images/mail-eagle-logo.svg" alt="logo" class="w-9 max-w-full h-auto">
                    </div>
                </a>
            HTML;
    }
}
