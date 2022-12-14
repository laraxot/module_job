<div>
    <x-flash-message></x-flash-message>
    <x-card-simple>
        <x-slot name="title">Schedule Status</x-slot>
        <x-slot name="txt">
            <pre>{!! $out !!}</pre>
        </x-slot>
        <x-slot name="footer">
            @foreach ($acts as $act)
                <button class="btn btn-primary" wire:click="artisan('{{ $act->name }}')">{{ $act->name }}
                </button>
            @endforeach
            
        </x-slot>
    </x-card-simple>

</div>
