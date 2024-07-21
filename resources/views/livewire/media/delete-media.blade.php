<div>
    <dialog class="modal {{$deleteMediaModal ? 'modal-open' : ''}}">
        <div class="modal-box w-11/12 md:w-1/2 lg:w-1/3">
            <div class="flex justify-between items-center">
                <h4 class="text-primary font-semibold text-lg">
                    Hapus media informasi
                </h4>

                <button class="btn btn-sm btn-default" wire:click="$set('deleteMediaModal', false)">✕</button>
            </div>

            <div class="mt-4">
                <h4 class=" text-neutral-700">
                    Apakah anda yakin untuk menghapus <span class="font-semibold">{{$mediaName}}</span> ?
                </h4>

                {{-- <p class="text-neutral-500 text-sm mt-1">Semua sesi informasi yang menampilkan media ini akan ikut terhapus.</p> --}}
            </div>



            <div class="modal-action">
                <button class="btn btn-sm btn-default" wire:click="$set('deleteMediaModal', false)">
                    Batal
                </button>
                <button wire:click="delete" class="btn btn-sm btn-error">
                    Hapus
                </button>
            </div>
        </div>

    </dialog>


</div>
