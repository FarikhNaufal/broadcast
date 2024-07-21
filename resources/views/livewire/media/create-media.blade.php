<div>
    <button class="btn btn-primary btn-sm flex gap-1" onclick="createMediaModal.showModal();">
        <i class="lni lni-plus text-xs"></i>
        <h5 class="hidden md:block">Tambah</h5>
    </button>

    <dialog wire:ignore.self id="createMediaModal" class="modal z-50">
        <div class="modal-box w-11/12 md:w-1/2 lg:w-1/3 no-scrollbar">
            <div class="flex justify-between items-center">
                <h4 class="font-bold text-lg">
                    Tambah media informasi
                </h4>
                <button class="btn btn-sm btn-default" onclick="closeMediaModal()">✕</button>
            </div>

            <form wire:submit="storeMedia" class="mt-2">
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
                        <select wire:model.lazy="form.type" class="select select-bordered select-sm w-full"
                            autocomplete="off" wire:change="updateType">
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
                                    <div class="aspect-video" id="photo-parent">
                                        <img src="{{ $form->data->temporaryUrl() }}" alt="Preview"
                                            class="aspect-video object-contain">
                                        <button wire:click.prevent="removeImage"
                                            class="btn btn-sm btn-circle bg-opacity-75 absolute flex place-items-center right-3 top-3">
                                            <img src="{{ asset('Assets/svg/delete.svg') }}" class="w-5" alt="">
                                        </button>
                                    </div>
                                @else
                                    <div id="add-photo-btn" class="flex flex-col justify-center items-center gap-2  py-3">
                                        <img src="{{ asset('Assets/svg/photo.svg') }}" class="w-20" alt="">
                                        <input type="file" id="photo-input" accept="image/*" wire:model="form.data"
                                            class="hidden">

                                        <button type="button" class="btn btn-sm btn-neutral" onclick="openPostInput()">
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
                        <div wire:ignore.self class="label">
                            <span class="label-text-alt text-red-600">{{ $message }}</span>
                        </div>
                    @enderror

                </label>

                <div class="modal-action">
                    <button class="btn btn-sm btn-primary">
                        Tambah
                    </button>
                </div>
            </form>
        </div>

    </dialog>


    @push('scripts')
        <script type="module">
            Livewire.on('close-create-media-modal', function(event) {
                createMediaModal.close();
            });
        </script>

        <script>
            function openPostInput() {
                document.getElementById('photo-input').click();
            }



            function closeMediaModal() {
                Livewire.dispatch('closeMediaModal');
                createMediaModal.close();

            }
        </script>
    @endpush
</div>
