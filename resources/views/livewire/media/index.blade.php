<div class="flex flex-col gap-4 md:gap-6">
    <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col gap-4">
        <div class="flex flex-col">
            <div class="flex  gap-3 md:gap-4 justify-between items-end">
                <div class="flex gap-2 items-center">
                    <i class="lni lni-printer text-neutral-500  mask mask-squircle p-2 bg-neutral-100"></i>
                    <h1 class="text-neutral-600  font-semibold lg:text-lg">
                        Tabel media informasi
                    </h1>
                </div>
                @livewire('media.create-media')

            </div>

            <hr class="flex my-3">

            <div class="flex flex-col md:flex-row gap-2 md:gap-3 justify-between md:items-center">
                <div class="flex justify-between md:justify-normal gap-2">
                    <select wire:model.live="orderBy" class="select select-sm select-bordered"
                        {{ $mediaIsEmpty ? 'disabled' : '' }}>
                        <option value="desc">Terbaru</option>
                        <option value="asc">Terlama</option>
                    </select>
                    <select wire:model.live="pagination" class="select select-sm select-bordered"
                        {{ $mediaIsEmpty ? 'disabled' : '' }}>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <label class="input ring-0 input-bordered input-sm flex items-center gap-2">
                    <i class="lni lni-search-alt"></i>
                    <input type="text" wire:model.live="search" class="grow" {{ $mediaIsEmpty ? 'disabled' : '' }}
                        placeholder="Cari...">
                </label>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table lg:table-pin-cols text-xs min-w-max">
                <thead>
                    <tr class="bg-neutral-100">
                        <th class="bg-neutral-100 w-0">
                            No
                        </th>
                        <td>Nama</td>
                        <td class="w-min">Tipe</td>
                        <td>Detail</td>
                        <td>Tanggal dibuat</td>
                        <th class="bg-neutral-100 w-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($mediaIsEmpty)
                        @livewire('components.no-data', ['data' => 'media'])
                    @else
                        @foreach ($medias as $index => $media)
                            <tr>
                                <th class="text-center">
                                    {{ $index + 1 }}
                                </th>
                                <td class="max-w-52">
                                    <h2>
                                        {{ $media->name }}
                                    </h2>
                                </td>


                                <td class="capitalize">
                                    @isset($this->mediaTypes[$media->type])
                                        <div class="{{ $this->mediaTypes[$media->type]['bg'] }} {{ $this->mediaTypes[$media->type]['text'] }} px-3 py-0.5 rounded w-fit flex items-center justify-center gap-1">
                                            <i class="{{ $this->mediaTypes[$media->type]['icon'] }}"></i>
                                            {{ $media->type }}
                                        </div>
                                    @endisset
                                </td>
                                <td>

                                    <button wire:click="$dispatch('show-media-modal', { media: '{{ $media->id }}'})"
                                        class="underline text-blue-500">Lihat</button>
                                </td>
                                <td>
                                    {{ $media->created_at->translatedFormat('l, j F Y - H:i:s') }}
                                </td>

                                <td>
                                    <div class="flex gap-x-2 items-center">
                                        <button type="button"
                                            wire:click="$dispatch('show-edit-media-modal', {id: '{{ $media->id }}'})"
                                            class="btn btn-sm btn-warning btn-square">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                        <button type="button"
                                            wire:click="$dispatch('show-delete-media-modal', {id: '{{ $media->id }}', 'name': '{{ $media->name }}'})"
                                            class="btn btn-sm btn-error btn-square">
                                            <i class="lni lni-eraser"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>

        <div class="">
            {{ $medias->links('vendor.livewire.tailwind') }}
        </div>
    </div>

    <div class="hidden">
        <div class="text-success"></div>
        <div class="text-error"></div>
        <div class="text-red-700"></div>
        <div class="bg-red-100"></div>
        <div class="text-blue-700"></div>
        <div class="bg-blue-100"></div>
        <div class="text-green-700"></div>
        <div class="bg-green-100"></div>
    </div>
    @livewire('media.edit-media')
    @livewire('media.delete-media')
    @livewire('media.show-media')
</div>
