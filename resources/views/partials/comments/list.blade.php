<div class="border-t border-b border-gray-200 mb-4 mt-4">
    <h3 class="my-4 mt-4">Comments</h3>

    @foreach ($post->comments as $comment)
        <div class="mb-4">
            <div class="block text-sm font-medium">
                {{$comment->name}}
            </div>
            <div class="block text-xs mt-1">
                {!! $comment->body !!}
            </div>
        </div>
    @endforeach
</div>