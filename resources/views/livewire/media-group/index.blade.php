<div class="flex flex-col gap-4 md:gap-6">
    <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col gap-4">
        <div class="flex flex-col">
            <div class="flex gap-3 md:gap-4 justify-between items-end">
                <div class="flex gap-2 items-center">
                    <i class="lni lni-package text-neutral-500  mask mask-squircle p-2 bg-neutral-100"></i>
                    <h1 class="text-neutral-600  font-semibold lg:text-lg">
                        Tabel group media
                    </h1>
                </div>
                @livewire('media-group.create-group')

            </div>

            <hr class="my-3">

            <div class="flex flex-col md:flex-row gap-3 justify-between md:items-center">
                <div class="flex justify-between md:justify-normal gap-2">
                    <select wire:model.live="orderBy" class="select select-sm select-bordered"
                        {{ $groupIsEmpty ? 'disabled' : '' }}>
                        <option value="desc">Terbaru</option>
                        <option value="asc">Terlama</option>
                    </select>
                    <select wire:model.live="pagination" class="select select-sm select-bordered"
                        {{ $groupIsEmpty ? 'disabled' : '' }}>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <label class="input ring-0 input-bordered input-sm flex items-center gap-2">
                    <i class="lni lni-search-alt"></i>
                    <input type="text" wire:model.live="search" class="grow" {{ $groupIsEmpty ? 'disabled' : '' }}
                        placeholder="Cari...">
                </label>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table lg:table-pin-cols text-xs min-w-max">
                <thead class="bg-neutral-100">
                    <tr>
                        <th class="w-0 bg-neutral-100">
                            No
                        </th>
                        <td>Nama Group</td>
                        <td>List Media</td>
                        <td>Tanggal dibuat</td>
                        <th class="w-0 bg-neutral-100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $index => $group)
                        <tr>
                            <th class="text-center">
                                {{ $index + 1 }}
                            </th>
                            <td>
                                {{ $group->name }}

                            </td>

                            <td>
                                @foreach ($group->media as $media)
                                    <h5 wire:click="$dispatch('show-media-modal', { media: '{{ $media->id }}' })"
                                        class="cursor-pointer hover:underline text-blue-700">
                                        {{ $media->name }} <span class="text-neutral-400">
                                            ({{ $media->pivot->duration }}s)
                                        </span> {{ $loop->last ? '' : ', ' }}
                                @endforeach
                            </td>

                            <td>
                                {{ $group->created_at->translatedFormat('l, j F Y - H:i:s') }}
                            </td>

                            <td class="flex gap-2 border-none items-center">
                                <button type="button"
                                    wire:click="$dispatch('show-edit-group-modal', {id: '{{ $group->id }}'})"
                                    class="btn btn-sm btn-warning btn-square">
                                    <i class="lni lni-pencil"></i>
                                </button>
                                <button type="button"
                                    wire:click="$dispatch('show-delete-group-modal', {id: '{{ $group->id }}', 'name': '{{ $group->name }}'})"
                                    class="btn btn-sm btn-error btn-square">
                                    <i class="lni lni-eraser"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        @livewire('components.no-data', ['data' => 'media'])
                    @endforelse
                </tbody>
            </table>
        </div>


        <div class="">
            {{ $groups->links('vendor.livewire.tailwind') }}
        </div>
    </div>

    @livewire('media-group.edit-group')
    @livewire('media-group.delete-group')
    @livewire('media.show-media')
</div>
