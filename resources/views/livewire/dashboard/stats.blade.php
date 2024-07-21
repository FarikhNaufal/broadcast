<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8">
    <a href="/client" wire:navigate
        class="bg-white p-2 md:p-4 rounded-lg border-x border-x-gray-300 border-t border-t-gray-300 border-b-4 border-b-purple-600 flex gap-3 md:gap-4 items-center">
        <div class="avatar">
            <div class="w-8 md:w-12 mask mask-squircle bg-purple-100 flex items-center justify-center">
                <i class="lni lni-display-alt text-purple-600 text-2xl font-semibold bg-"></i>
            </div>
        </div>
        <div class="">
            <h4 class="text-primary text-xs md:text-base font-semibold">{{ $client }} Client</h4>
            <h5 class=" text-neutral-400 text-2xs md:text-xs">Jumlah client</h5>

        </div>
    </a>
    <a href="/client" wire:navigate
        class="bg-white p-2 md:p-4 rounded-lg border-x border-x-gray-300 border-t border-t-gray-300 border-b-4 border-b-yellow-600 flex gap-3 md:gap-4 items-center ">
        <div class="avatar">
            <div class="w-8 md:w-12 mask mask-squircle bg-yellow-100 flex items-center justify-center">
                <i class="lni lni-pulse text-yellow-600 text-2xl font-semibold"></i>
            </div>
        </div>
        <div class="">
            <h4 class="text-primary text-xs md:text-base font-semibold">{{ $session }} Client aktif</h4>
            <h5 class=" text-neutral-400 text-2xs md:text-xs">Jumlah client aktif</h5>

        </div>
    </a>
    <a href="/media" wire:navigate
        class="bg-white p-2 md:p-4 rounded-lg border-x border-x-gray-300 border-t border-t-gray-300 border-b-4 border-b-blue-600 flex gap-3 md:gap-4 items-center ">
        <div class="avatar">
            <div class="w-8 md:w-12 mask mask-squircle bg-blue-100 flex justify-center items-center">
                <i class="lni lni-image text-blue-600 text-2xl font-semibold"></i>
            </div>
        </div>
        <div class="">
            <h4 class="text-primary text-xs md:text-base font-semibold">{{ $media }} Media</h4>
            <h5 class=" text-neutral-400 text-2xs md:text-xs">Jumlah media</h5>

        </div>
    </a>
    <a href="/group" wire:navigate
        class="bg-white p-2 md:p-4 rounded-lg border-x border-x-gray-300 border-t border-t-gray-300 border-b-4 border-b-green-600 flex gap-3 md:gap-4 items-center ">
        <div class="avatar">
            <div class="w-8 md:w-12 mask mask-squircle bg-green-100 flex items-center justify-center">
                <i class="lni lni-package text-green-600 text-2xl font-semibold"></i>
            </div>
        </div>
        <div class="">
            <h4 class="text-primary text-xs md:text-base font-semibold">{{ $group }} Group Media</h4>
            <h5 class=" text-neutral-400 text-2xs md:text-xs">Jumlah Group Media</h5>
        </div>
    </a>

</div>
