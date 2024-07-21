<div wire:ignore id="toast" class="toast toast-end z-[99999] hidden">
    <div class="bg-white p-[0.15rem] rounded-lg  shadow-xl border-s-8 border-success">
        <div class="bg-alert-success p-3">
            <h3 class="text-sm text-success-content">Berhasil...!</h3>
            <span class="text-xs opacity-85" id="toast-msg">Media baru berhasil ditampilkan</span>
        </div>
    </div>


    @push('scripts')
        <script type="module">
            const toast = document.getElementById('toast');
            const toastmsg = document.getElementById('toast-msg');
            Livewire.on('show-toast', (event) => {
                toast.classList.remove('hidden');
                toastmsg.innerHTML = event.msg;
                setTimeout(() => {
                    document.getElementById('toast').classList.add('hidden');
                }, 3000);
            });
        </script>
    @endpush
</div>
