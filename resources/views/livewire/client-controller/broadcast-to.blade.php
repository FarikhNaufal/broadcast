<div>
    <button class="btn btn-sm btn-primary btn-outline flex gap-1" onclick="broadcastToModal.showModal()">
        <i class="lni lni-slideshare text-xs"></i>
        <span class="hidden md:block">
            Broadcast
        </span>
    </button>
    <dialog wire:ignore.self id="broadcastToModal" class="modal">
        <div class="modal-box w-11/12 md:w-1/2">
            <div class="flex justify-between items-center ">
                <h4 class="font-bold text-lg">
                    Broadcast
                </h4>
                <button class="btn btn-sm btn-default" onclick="broadcastModalClosed()">✕</button>
            </div>

            <form wire:submit="broadcastTo" class="mt-2">
                <label wire:ignore class="form-control">
                    <div class="label">
                        <span class="label-text">Client</span>
                        <span class="label-text-alt cursor-pointer flex items-center gap-2">
                            Pilih semua
                            <input wire:model="checked" type="checkbox" id="toggle-select"
                                class="checkbox checkbox-xs" />
                        </span>
                    </div>
                    <select multiple="multiple" wire:model="clients" id="clientselect">
                        @foreach ($clientsx as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('clients')
                        <span class="label-text-alt text-red-600">{{ $message }}</span>
                    @enderror

                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Jenis media</span>
                        @error('usingGroup')
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <select wire:model.lazy="usingGroup" class="select select-bordered select-sm w-full"
                        autocomplete="off">
                        <option value="" selected>Silahkan pilih..!</option>
                        <option value='0'>Non-Group</option>
                        <option value='1'>Group</option>
                    </select>
                </label>



                @switch($usingGroup ?? null)
                    @case('0')
                        @foreach ($options as $index => $option)
                            <div class="flex items-end gap-2 mb-2">
                                <label wire:ignore class="form-control w-full">
                                    <div class="label {{ $index != 0 ? 'hidden' : '' }}">
                                        <span class="label-text">Media</span>
                                    </div>
                                    <select wire:model="options.{{ $index }}.media"
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
                                        <input wire:model="options.{{ $index }}.duration" type="number"
                                            placeholder="..." class="grow w-7" />
                                        detik
                                    </label>
                                </label>
                                @if (count($options) > 1)
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
                                @error('options.*.media')
                                    <span class="label-text-alt text-red-600">{{ $message }}</span>
                                @enderror
                                @error('options.*.duration')
                                    <span class="label-text-alt text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @break

                    @case('1')
                        <label class="form-control">
                            <div class="label">
                                <span class="label-text">Pilih Group</span>
                                @error('groupID')
                                    <span class="label-text-alt text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <select wire:model.live="groupID" class="select select-bordered select-sm w-full"
                                autocomplete="off">
                                @foreach ($groups as $group)
                                    <option selected="selected">Pilih media..!</option>
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    @break

                    @default
                @endswitch

                <div class="modal-action">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Kirim
                        <span wire:loading wire:target="broadcastTo" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>

    </dialog>

    @push('scripts')
        <script type="module">
            Livewire.on('close-broadcast-to-modal', function(event) {
                broadcastToModal.close();
                tomselect.clear();
            });
            var tomselect = new TomSelect('#clientselect', {
                create: false,
                multiple: true,
                placeholder: "Silahkan pilih...!"
            })

            const toggleSelectCheckbox = document.getElementById('toggle-select');
            toggleSelectCheckbox.addEventListener('change', function() {
                const isChecked = toggleSelectCheckbox.checked;
                const allValues = tomselect.options;
                const valuesToSelect = Object.keys(allValues).map(key => allValues[key].value);

                if (isChecked) {
                    tomselect.setValue(valuesToSelect); // Pilih semua
                } else {
                    tomselect.setValue([]); // Batalkan semua
                }
            });
        </script>

        <script>
            function broadcastModalClosed() {
                broadcastToModal.close();
                Livewire.dispatch('broadcastModalClosed');
            }
        </script>
    @endpush

</div>
