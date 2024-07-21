<div role="tablist" class="tabs tabs-lifted">
    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Aktif" checked />
    <div role="tabpanel" class="tab-content">
        <div class="pt-4 max-h-80 relative overflow-y-auto">
            @forelse ($active as $item)
                <div class="flex items-start gap-2 mb-3">
                    <img src="{{ asset('Assets/svg/client.svg') }}" class="w-12" alt="">
                    <div class="flex flex-col pt-1 items-start">
                        <h2 class="text-xs font-semibold text-gray-500 w-14 line-clamp-1 overflow-hidden truncate">
                            {{ $item->name }}
                        </h2>
                        @if ($item->usingGroup())
                            <h5 class="text-gray-500 text-2xs line-clamp-2">
                                {{ $item->group->name }}
                            </h5>
                        @else
                            <h5 class="text-gray-500 text-2xs line-clamp-2">
                                @foreach ($item->media as $media)
                                    {{ $media->name }},
                                @endforeach
                            </h5>
                        @endif
                    </div>
                </div>

            @empty
                <h5 class="text-gray-500 text-xs">Tidak ada client yang aktif.</h5>
            @endforelse
        </div>
    </div>

    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Nonaktif"/>
    <div role="tabpanel" class="tab-content">
        <div class="pt-4 max-h-80 relative overflow-y-auto">
            @forelse ($nonactive as $item)
                <div class="flex items-center gap-2 mb-3">
                    <img src="{{ asset('Assets/svg/client-non.svg') }}" class="w-12" alt="">
                    <div class="flex flex-col pt-1 items-start">
                        <h2 class="text-xs font-semibold text-gray-500 w-14 line-clamp-1 overflow-hidden truncate">
                            {{ $item->name }}
                        </h2>
                    </div>
                </div>

            @empty
                <h5 class="text-gray-500 text-xs">Tidak ada client yang nonaktif.</h5>
            @endforelse

        </div>
    </div>
</div>
