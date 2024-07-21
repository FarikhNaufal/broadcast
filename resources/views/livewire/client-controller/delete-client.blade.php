<div x-data="{ deleteClientModal: $wire.entangle('showDeleteClientModal') }">
    <dialog class="modal" :class="{'modal-open': deleteClientModal}" x-cloak>
        <div class="modal-box w-11/12 md:w-1/2 lg:w-1/3">
            <div class="flex justify-between items-center">
                <h4 class="font-semibold text-lg">
                    Hapus client
                </h4>

                <button class="btn btn-sm btn-default" wire:click="$set('showDeleteClientModal', false)">✕</button>
            </div>

            <div class="mt-4">
                <h4 class=" text-neutral-700">
                    Apakah anda yakin untuk menghapus <span class="font-semibold">{{$clientName}}</span> ?
                </h4>

                {{-- <p class="text-neutral-500 text-sm mt-1">Client yang menampilkan sesi ini akan terhapus.</p> --}}

            </div>

            <div class="modal-action">
                <button class="btn btn-sm btn-default" wire:click="$set('showDeleteClientModal', false)">
                    Batal
                </button>
                <button wire:click="delete" class="btn btn-sm btn-error">
                    Hapus
                    <span wire:loading wire:target="delete" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>

    </dialog>
</div>
