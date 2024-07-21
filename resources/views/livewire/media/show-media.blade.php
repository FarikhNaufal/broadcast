<div x-data="{ showMediaModal: $wire.entangle('showMediaModal') }">
    @if ($media)
        <dialog class="modal" :class="{ 'modal-open': showMediaModal }" x-cloak>
            <div class="modal-box w-11/12 md:w-1/2 lg:max-w-5xl p-4">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold">
                        {{ $media->name }}
                    </h4>
                    <button class="btn btn-sm btn-default" wire:click="closeMediaModal">✕</button>
                </div>

                <div class="mt-3">
                    @switch($media->type)
                        @case('text')
                            <div class="flex text-center w-full h-full aspect-video flex-col items-center justify-center p-4"
                                wire:ignore x-data x-init="const md = markdownit();
                                const content = `{{ $media->data }}`
                                const mediaText = document.getElementById('mediaText')
                                mediaText.classList.add('prose')
                                mediaText.innerHTML = md.render(content);">
                                <div id="mediaText"></div>
                            </div>
                        @break

                        @case('image')
                            <img src="{{ Storage::url($media->data) }}" alt=""
                                class="rounded aspect-video object-contain">
                        @break

                        @case('youtube')
                            <iframe
                                src="http://www.youtube-nocookie.com/embed/{{ $media->data }}?enablejsapi=1&origin=http://127.0.0.1:8000/client&autoplay=1&loop=1&mute=1&controls=0&fs=1&vq=720p&playlist={{ $media->data }}"
                                frameborder="0" class="w-full aspect-video"></iframe>
                        @break

                        @default
                    @endswitch
                </div>
            </div>

        </dialog>
    @endif

</div>
