<div x-data="{show: false}"
     x-on:click.away="show = false"
     class="relative">
    <slot name="button-content">
        <button @click="show = ! show"
                class="flex items-center group focus:outline-none rounded-full focus:ring-2 focus:ring-offset-4 focus:ring-red-500">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 group-focus:text-red-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

            <livewire:cart-counter class="text-xs" empty-class="hidden" not-empty-class="bg-red-500 text-white rounded-full px-3 py-1 ml-1" />
        </button>
    </slot>
    <div x-cloak
         x-show="show"
         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
         role="menu"
         aria-orientation="vertical"
         aria-labelledby="menu-button"
         tabindex="-1">
        <slot name="header">
            <h4 class="font-semibold px-3 pt-3 text-gray-500">
                {{ __('Your cart...') }}
            </h4>
        </slot>
        <slot name="content">
            <livewire:cart-items />
        </slot>
        <slot name="footer"></slot>
    </div>
</div>
