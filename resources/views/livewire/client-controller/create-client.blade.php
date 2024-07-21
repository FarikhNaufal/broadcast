<div>
    <button class="btn btn-primary btn-sm flex gap-1" onclick="createClientModal.showModal()">
        <i class="lni lni-plus text-xs"></i>
        <span class="hidden md:block">
            Tambah
        </span>
    </button>
    <dialog wire:ignore.self id="createClientModal" class="modal">
        <div class="modal-box w-11/12 md:w-1/2">
            <div class="flex justify-between items-center ">
                <h4 class="font-bold text-lg">
                    Tambah client
                </h4>
                <button class="btn btn-sm btn-default" onclick="closeClientModal()">✕</button>
            </div>

            <form wire:submit="storeClient" class="mt-2">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Nama client</span>
                    </div>
                    <input wire:model="form.name" type="text" placeholder="Nama client"
                        class="input input-bordered input-sm" autofocus />
                    @error('form.name')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Password</span>
                    </div>
                    <div class="flex w-full gap-2">
                        <input wire:model="form.password" type="text" placeholder="Password"
                            class="input input-bordered w-full input-sm" />
                        <button type="button" wire:click="generatePassword" class="btn btn-sm">
                            Random
                            <span wire:loading wire:target="generatePassword"
                                class="loading loading-spinner loading-sm"></span>
                        </button>
                    </div>
                    @error('form.password')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Jenis media</span>
                    </div>
                    <select wire:model.lazy="form.usingGroup" class="select select-bordered select-sm w-full"
                        autocomplete="off">
                        <option value="" selected>Silahkan pilih..!</option>
                        <option value='0'>Non-Group</option>
                        <option value='1'>Group</option>
                    </select>
                    @error('form.usingGroup')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror
                </label>



                @switch($form->usingGroup ?? null)
                    @case('0')
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
                    @break

                    @case('1')
                        <label class="form-control">
                            <div class="label">
                                <span class="label-text">Pilih Group</span>
                                @error('form.groupID')
                                    <span class="label-text-alt text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <select wire:model.live="form.groupID" class="select select-bordered select-sm w-full"
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
                        Tambah
                        <span wire:loading wire:target="storeClient" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>

    </dialog>

    @push('scripts')
        <script type="module">
            Livewire.on('close-create-client-modal', function(event) {
                createClientModal.close();
            });
        </script>

        <script>
            function closeClientModal() {
                createClientModal.close();
                Livewire.dispatch('closeClientModal');
            }
        </script>
    @endpush

</div>
