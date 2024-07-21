<div class="flex justify-center items-center h-screen">
    <div class="bg-white h-fit w-11/12 md:w-1/4 p-6 rounded-md flex flex-col gap-5 items-center justify-center">
        <img class="w-48" src="{{ asset('Assets/logo.png') }}" alt="">
        <div class="justify-center items-center flex flex-col">
            <h1 class="text-2xl font-semibold text-neutral-700">
                Selamat Datang
            </h1>
            <p class="text-neutral-500">Di Sistem Penyebaran Informasi</p>
        </div>

        <form wire:submit="log" class="w-full">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input wire:model="form.email" type="email" placeholder="Masukkan email anda"
                    class="input input-bordered w-full" />
                @error('form.email')
                    <div class="label">
                        <span class="label-text-alt text-red-600">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Password</span>
                </div>
                <input wire:model="form.password" type="password" placeholder="Masukkan password anda"
                    class="input input-bordered w-full" />
                @error('form.password')
                    <div class="label">
                        <span class="label-text-alt text-red-600">{{ $message }}</span>
                    </div>
                @enderror
                @error('form.credentials')
                    <div class="label">
                        <span class="label-text-alt text-red-600">{{ $message }}</span>
                    </div>
                @enderror
            </label>

            <button class="btn btn-primary mt-5 btn-block mb-2">
                Masuk
                <span wire:loading wire:target="log" class="loading loading-spinner"></span>
            </button>

            <button class="btn btn-block my-2">
                Masuk dengan Google
            </button>
        </form>
    </div>
</div>
