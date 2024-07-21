<div>
    <button class="btn btn-primary btn-sm flex gap-1" onclick="createGroupModal.showModal()">
        <i class="lni lni-plus text-xs"></i>
        <h5 class="hidden md:block">
            Tambah
        </h5>
    </button>
    <dialog wire:ignore.self id="createGroupModal" class="modal">
        <div class="modal-box w-11/12 md:w-1/2">
            <div class="flex justify-between items-center ">
                <h4 class="font-bold text-lg">
                    Tambah group media
                </h4>
                <button class="btn btn-sm btn-default" onclick="closeGroupModal()">✕</button>
            </div>

            <form wire:submit="storeGroup" class="mt-2">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Nama</span>
                        @error('form.name')
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <input wire:model="form.name" type="text" placeholder="Nama group media"
                        class="input input-bordered input-sm" autofocus />

                </label>
                @foreach ($form->options as $index => $option)
                    <div class="flex items-end gap-2 mb-2">
                        <label wire:ignore class="form-control w-full">
                            <div class="label {{ $index != 0 ? 'hidden' : '' }}">
                                <span class="label-text">Media</span>
                            </div>
                            <select wire:model="form.options.{{ $index }}.media"
                                class="select select-bordered select-sm w-full" autocomplete="off">
                                <option selected="selected">Pilih media..!</option>
                                @foreach ($medias as $media)
                                    <option value="{{ $media->id }}">{{ $media->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="form-control">
                            <div class="label {{ $index != 0 ? 'hidden' : '' }}">
                                <span class="label-text">Durasi</span>
                            </div>
                            <label class="input input-bordered input-sm flex items-center gap-1">
                                <input wire:model="form.options.{{ $index }}.duration" type="number"
                                    placeholder="..." class="grow w-7" />
                                detik
                            </label>
                        </label>
                        @if (count($form->options) > 1)
                            <button type="button" class="btn btn-square btn-sm"
                                wire:click="removeOption({{ $index }})">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
                <div class="mt-2 flex justify-between items-start">
                    <button type="button" wire:click="addOption"
                        class="font-normal text-blue-700 p-0 flex gap-1 text-xs items-center ml-1">
                        Tambah media...
                    </button>
                    <div class="flex flex-col items-end">
                        @error('form.options.*.media')
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        @enderror
                        @error('form.options.*.duration')
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="modal-action">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Tambah
                        <span wire:loading wire:target="storeClient" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>

    </dialog>

    @push('scripts')
        <script type="module">
            Livewire.on('close-create-group-modal', function(event) {
                createGroupModal.close();
            });
        </script>

        <script>
            function closeGroupModal() {
                createGroupModal.close();
                Livewire.dispatch('closeGroupModal');
            }
        </script>
    @endpush

</div>
