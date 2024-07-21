<div x-data="{ refreshEventModal: $wire.entangle('refreshEventModal') }">
    <dialog class="modal" :class="{'modal-open' : refreshEventModal}" x-cloak>
        <div class="modal-box w-11/12 md:w-1/2 lg:w-1/3">
            <div class="flex justify-between items-center">
                <h4 class="font-bold text-lg">
                    Mulai ulang client
                </h4>

                <button class="btn btn-sm btn-default" wire:click="$set('refreshEventModal', false)">✕</button>
            </div>

            <div class="mt-4">
                <h4 class=" text-neutral-700">
                    Apakah anda yakin untuk mulai ulang sesi <span class="font-semibold">{{$clientName}}</span> ?
                </h4>
                <p class="text-neutral-500 text-sm mt-1">Memulai ulang sesi akan memperbarui client yang idle.</p>
            </div>

            <div class="modal-action">
                <button class="btn btn-sm btn-default" wire:click="$set('refreshEventModal', false)">
                    Batal
                </button>
                <button wire:click="refreshEvent"  class="btn btn-sm btn-primary">
                    Refresh
                    <span wire:loading wire:target="refreshEvent" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>

    </dialog>


</div>
