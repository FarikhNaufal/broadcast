<div class="flex flex-col gap-3 md:gap-6">
    @livewire('dashboard.stats')
    <div class="flex-col flex md:flex-row gap-3">
        <div class="bg-white rounded w-full p-3 md:p-6 pb-6">
            <h1 class="text-neutral-600 font-semibold mb-3">
                Log aktivitas
            </h1>
            <div role="tablist" class="tabs tabs-lifted">
                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Websocket"
                    checked="checked" />
                <div role="tabpanel" class="tab-content overflow-auto">
                    @livewire('dashboard.log.wslog')
                </div>

                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Sistem" />
                <div role="tabpanel" class="tab-content overflow-auto">
                    @livewire('dashboard.log.systemlog')
                </div>
            </div>
        </div>
        <div class="bg-white rounded w-full md:max-w-80 p-4 pb-6">
            <h1 class="text-neutral-600  font-semibold text mb-3">
                Status client
            </h1>
            @livewire('dashboard.client-status')
        </div>
    </div>

    <div class="hidden">
        <div class="text-success"></div>
        <div class="text-error"></div>
        <div class="text-yellow-500"></div>
        <div class="text-purple-500"></div>
    </div>
</div>
