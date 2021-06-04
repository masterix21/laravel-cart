<div>
    @if (Cart::isEmpty())
        <p class="py-4 px-3 text-gray-300 text-sm">
            <i>{{ __('The cart is empty') }}</i>
        </p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($this->cartItems as $item)
                <li class="py-4 px-3">
                    <div class="flex space-x-3">
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-medium">{{ $item->label }}</h3>
                                <p class="text-xs text-green-500 font-mono">{{ $item->price }}</p>
                            </div>
                            @if (! blank($item->description))
                                <p class="text-xs text-gray-500 leading-5">{!! nl2br($item->description) !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex">
                        <a wire:click="removeItem({{ $item->id }})"
                           class="text-red-600 text-xs hover:text-red-400 cursor-pointer">
                            {{ __('Remove') }}
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
