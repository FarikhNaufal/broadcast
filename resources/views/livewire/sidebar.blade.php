<div class="drawer-side z-50">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="w-60 lg:w-[250px] min-h-full bg-white text-base-content">
        @persist('logoimage')
        <div class="w-fit mx-7 mb-4 py-4">
            <a href="/" wire:navigate>
                <img src="{{ asset('Assets/logo.webp') }}" class="w-32" alt="" width="100" height="100">
            </a>
        </div>
        @endpersist()

        <ul>
            <li>
                <a href="/" wire:navigate
                    class="px-7 py-2 flex gap-3 items-center hover:bg-neutral-200 hover:bg-opacity-30 text-neutral-700 hover:text-primary {{ Route::is('dashboard') ? 'text-primary' : '' }} w-full ">
                    <i class="lni lni-home  text-lg"></i>
                    <h4 class="text-sm">
                        Dashboard
                    </h4>
                </a>
            </li>

            <li class="px-7 my-2">
                <h1 class="text-primary font-semibold text-sm">
                    MENU
                </h1>
            </li>

            <li>
                <a href="/client" wire:navigate
                    class="px-7 py-2 flex gap-3 items-center hover:bg-neutral-200 hover:bg-opacity-30 text-neutral-700 hover:text-primary {{ Route::is('client') ? 'text-primary' : '' }} w-full">
                    <i class="lni lni-display-alt text-lg"></i>
                    <h4 class="text-sm">
                        Client
                    </h4>
                </a>
            </li>
            <li>
                <a href="/media" wire:navigate
                    class="px-7 py-2 flex gap-3 items-center hover:bg-neutral-200 hover:bg-opacity-30 text-neutral-700 hover:text-primary {{ Route::is('media') ? 'text-primary' : '' }} w-full">
                    <i class="lni lni-printer text-lg"></i>
                    <h4 class="text-sm">
                        Media Informasi
                    </h4>
                </a>
            </li>
            <li>
                <a href="/group" wire:navigate
                    class="px-7 py-2 flex gap-3 items-center hover:bg-neutral-200 hover:bg-opacity-30 text-neutral-700 hover:text-primary {{ Route::is('group') ? 'text-primary' : '' }} w-full">
                    <i class="lni lni-package text-lg"></i>
                    <h4 class="text-sm">
                        Group Media
                    </h4>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="" enctype="multipart/form-data">
                    @csrf
                    <button
                        class="px-7 py-2 flex gap-3 items-center justify-start hover:bg-neutral-200 hover:bg-opacity-30 w-full text-primary text-sm"
                        type="submit">

                        <i class="lni lni-exit text-lg"></i>
                        Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

</div>
