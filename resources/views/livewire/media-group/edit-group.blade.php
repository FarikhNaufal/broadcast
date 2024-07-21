<div x-data="{ editGroupModal: @entangle('editGroupModal') }">
    <dialog class="modal" :class="{ 'modal-open': editGroupModal }">
        <div class="modal-box w-11/12 md:w-1/2">
            <div class="flex justify-between items-center ">
                <h4 class="font-bold text-lg">
                    Edit group media
                </h4>

                <button class="btn btn-sm btn-default" wire:click="$set('editGroupModal', false)">✕</button>
            </div>

            <form wire:submit="updateGroup" class="mt-2">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Nama</span>
                    </div>
                    <input wire:model="form.name" type="text" class="input input-bordered input-sm" autofocus />
                    @error('form.name')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror
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
                    <button class="btn btn-sm btn-primary">
                        Simpan
                        <span wire:loading wire:target="updateClient" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>

</div>
