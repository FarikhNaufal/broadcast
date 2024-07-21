<div x-data="{ editMediaModal: $wire.entangle('editMediaModal') }">
    <dialog class="modal" :class="{ 'modal-open': editMediaModal }" x-cloak>
        <div class="modal-box w-11/12 md:w-1/2 lg:w-1/3 max-h-screen no-scrollbar">
            <div class="flex justify-between items-center ">
                <h4 class="font-bold text-lg">
                    Edit media informasi
                </h4>
                <button class="btn btn-sm btn-default" wire:click="$set('editMediaModal', false)">✕</button>
            </div>

            <form wire:submit.prevent="updateMedia" class="mt-2">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Nama media</span>
                    </div>
                    <input wire:model="form.name" type="text" placeholder="Masukkan nama/judul media"
                        class="input input-bordered input-sm" autofocus />
                    @error('form.name')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                <label wire:ignore class="form-control">
                    <div class="label">
                        <span class="label-text">Pilih tipe media</span>
                    </div>

                    <div class="flex gap-2">
                        <select wire:model.live="form.type" class="select select-bordered select-sm w-full"
                            autocomplete="off" wire:change="$set('form.data', null)">
                            <option value="" selected>Silahkan pilih..!</option>
                            <option value="text">Teks</option>
                            <option value="image">Foto/Gambar</option>
                            <option value="youtube">Video Youtube</option>
                        </select>
                        <span wire:loading wire:target="form.type" class="loading loading-spinner loading-sm"></span>
                    </div>
                    @error('form.type')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror

                </label>

                <label class="form-control">
                    @switch($form->type ?? null)
                        @case('text')
                            <div class="label">
                                <span class="label-text">Teks Informasi</span>
                            </div>
                            <div wire:ignore>
                                @include('livewire.media.editor')
                            </div>
                        @break

                        @case('youtube')
                            <div class="label">
                                <span class="label-text">Tautan video Youtube</span>
                            </div>
                            <input wire:model="form.data" type="text" placeholder="Masukkan tautan youtube (Hanya value id)"
                                class="input input-bordered input-sm" />
                        @break

                        @case('image')
                            <div
                                class="mt-4 aspect-video relative flex bg-primary bg-opacity-5 border-2 border-primary border-opacity-10 justify-center items-center rounded-lg w-full">
                                @if ($form->data ?? null)
                                    <div class="aspect-video">
                                        @if ($form->data instanceof \Illuminate\Http\UploadedFile)
                                            <img id="media-photo-previews" src="{{ $form->data->temporaryUrl() }}"
                                                alt="Preview" class="aspect-video object-contain">
                                        @else
                                            <img id="media-photo-previews" src="{{ Storage::url($form->data) }}" alt="Preview"
                                                class="aspect-video object-contain">
                                        @endif
                                        <button wire:click.prevent="removeImage"
                                            class="btn btn-sm bg-opacity-100 absolute flex place-items-center right-3 top-3">
                                            Ubah
                                        </button>
                                    </div>
                                @else
                                    <div class="flex flex-col justify-center items-center gap-2  py-3">
                                        <img src="{{ asset('Assets/svg/photo.svg') }}" class="w-20" alt="">
                                        <input type="file" id="media-photo-input" accept="image/*" wire:model="form.data"
                                            class="hidden" wire:ignore>

                                        <button type="button" class="btn btn-sm btn-neutral"
                                            onclick="document.getElementById('media-photo-input').click()">
                                            Unggah gambar
                                            <span wire:loading wire:target="form.data" class="loading loading-spinner"></span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @break

                        @default
                    @endswitch
                    @error('form.data')
                        <div class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror

                </label>



                <div class="modal-action">
                    <button class="btn btn-sm btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

    </dialog>

    @push('scripts')

        <script>
            function closeMediaModal() {
                Livewire.dispatch('closeMediaModal');
                createMediaModal.close();
            }
        </script>
    @endpush
</div>
