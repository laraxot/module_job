<div>
    <x-card-simple>
        <x-slot name="title">Job Status</x-slot>
        <x-slot name="txt">
            <pre>{!! $out !!}</pre>

            <x-input.group type="select" name="conn" :options="['sync'=>'sync','database'=>'database']" wire.model.lazy="form_data.conn" />
           
        </x-slot>
    </x-card-simple>
    <button class="btn btn-primary" wire:click="dummyAction()">send 1000 Dummy Action</button>
</div>