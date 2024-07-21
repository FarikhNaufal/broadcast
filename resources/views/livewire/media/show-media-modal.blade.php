{{-- <dialog id="viewMediaModal{{$media->id}}" class="modal">
    <div class="modal-box w-11/12 md:w-1/2 lg:max-w-5xl p-4">
        <div class="flex justify-between items-center">
            <h4 class="font-bold text-lg">
                Detail konten
            </h4>
            <button class="btn btn-sm btn-default"
                onclick="viewMediaModal{{$media->id}}.close()">✕</button>
        </div>

        <div class="mt-3">
            @if ($media->type == 'image')
                <div class="aspect-video w-full h-full">
                    <img class="object-contain h-full w-full" src="{{Storage::url($media->data)}}" alt="">
                </div>
            @else
                <div class="aspect-video bg-neutral-800 p-4 text-neutral-100">
                    {{ $media->data }}
                </div>
            @endif
        </div>
    </div>
</dialog> --}}
