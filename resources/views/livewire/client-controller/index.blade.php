<div>
    <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col gap-4">
        <div class="flex flex-col">
            <div class="flex justify-between items-end gap-y-3 md:gap-4">
                <div class="flex gap-2 items-center">
                    <i class="lni lni-display-alt text-neutral-500  mask mask-squircle p-2 bg-neutral-100"></i>
                    <h1 class="text-neutral-600 font-semibold lg:text-lg">
                        Tabel client
                    </h1>
                </div>
                <div class="flex gap-2">
                    @livewire('client-controller.broadcast-to')
                    <button wire:click="refreshAll" class="btn btn-outline btn-primary btn-sm">
                        <i wire:loading.class="animate-spin" wire:target="refreshAll" class="lni lni-reload"></i>
                        <span class="hidden md:block">
                            Refresh semua
                        </span>
                    </button>
                    @livewire('client-controller.create-client')
                </div>
            </div>
            <hr class="my-3">
            <div class="flex flex-col md:flex-row gap-2 md:gap-3 justify-between md:items-center">
                <div class="flex justify-between md:justify-normal gap-2">
                    <select wire:model.live="orderBy" class="select select-sm select-bordered"
                        {{ $clientIsEmpty ? 'disabled' : '' }}>
                        <option value="desc">Terbaru</option>
                        <option value="asc">Terlama</option>
                    </select>
                    <select wire:model.live="pagination" class="select select-sm select-bordered"
                        {{ $clientIsEmpty ? 'disabled' : '' }}>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <label class="input ring-0 input-bordered input-sm flex items-center gap-2">
                    <i class="lni lni-search-alt"></i>
                    <input type="text" wire:model.live="search" class="grow max-w-fit"
                        {{ $clientIsEmpty ? 'disabled' : '' }} placeholder="Cari...">
                </label>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table lg:table-pin-cols text-xs min-w-max">
                <thead>
                    <tr class="bg-neutral-100">
                        <th class=" bg-neutral-100">No</th>
                        <td>Nama</td>
                        <td>Password</td>
                        <td>Media</td>
                        <td>Status</td>
                        <td>Dibuat</td>
                        <td>Agent</td>
                        <th class="bg-neutral-100">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($clients as $index => $client)
                        <tr>
                            <th class="text-center">{{ $index + 1 }}</th>
                            <td class="max-w-52">{{ $client->name }}</td>
                            <td class="max-w-52">{{ Crypt::decrypt($client->password) }}</td>
                            <td class="max-w-52 text-blue-700">
                                @if ($client->usingGroup())
                                    <h5>
                                        {{ $client->group->name }}
                                    </h5>
                                @else
                                    @foreach ($client->media as $media)
                                        <h5 wire:click="$dispatch('show-media-modal', { media: '{{ $media->id }}' })"
                                            class="cursor-pointer hover:underline">
                                            {{ $media->name }} <span class="text-neutral-400">
                                                ({{ $media->pivot->duration }}s)
                                            </span> {{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                    </h5>
                                @endif
                            </td>
                            <td>
                                <div
                                    class="{{ $client->isActive ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} px-3 py-0.5 rounded w-full flex items-center justify-center gap-1 m-0">
                                    @if ($client->isActive)
                                        <i class="lni lni-checkmark-circle"></i>
                                        Aktif
                                    @else
                                        <i class="lni lni-cross-circle"></i>
                                        Nonaktif
                                    @endif
                                </div>
                            </td>
                            <td class="text-gray-600">
                                {{ $client->created_at->translatedFormat('l, j F Y - H:i:s') }}
                            </td>
                            <td class="max-w-sm lg:max-w-lg text-gray-600">
                                {{ $client->agent ?? '-' }}
                            </td>

                            <th>
                                <div class="flex gap-x-2 items-center">
                                    <button
                                        wire:click="$dispatch('show-refresh-event-modal', {id: '{{ $client->id }}', 'name': '{{ $client->name }}'})"
                                        class="btn btn-square  btn-sm">
                                        <i class="lni lni-reload"></i>
                                    </button>

                                    <button
                                        wire:click="$dispatch('show-edit-client-modal', {id: '{{ $client->id }}'})"
                                        class="btn btn-warning btn-square  btn-sm">
                                        <i class="lni lni-pencil"></i>
                                    </button>

                                    <button
                                        wire:click="$dispatch('show-delete-client-modal', {id:'{{ $client->id }}', 'name': '{{ $client->name }}'})"
                                        class="btn btn-error btn-square  btn-sm">
                                        <i class="lni lni-eraser"></i>
                                    </button>
                                </div>
                            </th>

                        </tr>
                    @empty
                        @if ($search == null)
                            @livewire('components.no-data', ['data' => 'sesi informasi'])
                        @endif
                    @endforelse

            </table>
        </div>
        <div class="">
            {{ $clients->links('vendor.livewire.tailwind') }}
        </div>
    </div>
    @livewire('client-controller.refresh-event')
    @livewire('client-controller.delete-client')
    @livewire('client-controller.edit-client')
    @livewire('media.show-media')

</div>
