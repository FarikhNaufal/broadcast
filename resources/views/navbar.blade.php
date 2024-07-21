<div class="navbar bg-white top-0 z-40 fixed px-3 lg:py-5 lg:px-7 shadow">
    <div class="navbar-start">
        <label for="my-drawer-2" class="btn btn-ghost p-0 drawer-button lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-5 h-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
    </div>

    <div class="navbar-end gap-3">
        <h3 class="font-semibold text-neutral-600 hidden lg:block text-sm">
            Hi,
            <span class="text-primary">
                {{Auth::user()->name}}
            </span>
        </h3>
        @persist('avatar')
        <div class="avatar">
            <div class="p-3 bg-teal-100 text-teal-600 flex items-center font-semibold mask mask-squircle">
                {{ Str::substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
        @endpersist()
    </div>
</div>

