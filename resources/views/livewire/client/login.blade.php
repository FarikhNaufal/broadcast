<dialog id="my_modal_1" class="modal modal-open">
    <div class="modal-box w-1/4">
        <form wire:submit="login" class="flex flex-col gap-3 rounded">
            <input wire:model="name" type="text" class="input input-bordered w-full" placeholder="Nama client"
                id="channelName">
            <div class="">

                <input wire:model="password" type="text" class="input input-bordered w-full" placeholder="Password"
                    id="channelKey">
                @error('login')
                    <div class="label">
                        <span class="label-text text-red-600">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <button class="btn btn-primary w-full mt-2">Join</button>
        </form>
    </div>
</dialog>
