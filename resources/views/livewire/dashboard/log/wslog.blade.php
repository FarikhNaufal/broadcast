<div class="max-h-80">
    <table class="table table-pin-rows text-xs border-table w-max lg:w-full">
        <thead class="bg-neutral-100">
            <tr>
                <th>
                    Aktivitas
                </th>
                <th>Waktu</th>
                <th>Client</th>
                <th>Detail</th>

            </tr>
        </thead>

        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td class="flex gap-2 border-none items-center">
                        <i
                            class="text-{{ $log->getExtraProperty('color') }} lni lni-{{ $log->getExtraProperty('icon') }} text-lg"></i>
                        <h5 class="capitalize font-normal">{{ $log->event }}</h5>
                    </td>
                    <td>
                        {{ $log->created_at->translatedFormat('l, j F Y - H:i:s') }}
                    </td>
                    <td>
                        {{ $log->causer->name ?? '' }}
                    </td>

                    <td>
                        {{ $log->description }}
                    </td>
                </tr>
            @empty
                @livewire('components.no-data', ['data' => 'log aktivitas'])
            @endforelse
        </tbody>
    </table>
</div>
{{-- <div class="mt-5">
    {{ $logs->links('vendor.livewire.tailwind') }}
</div> --}}
