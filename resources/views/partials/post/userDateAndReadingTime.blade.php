<div class="md:grid md:grid-cols-6 md:gap-6 text-base {{$textColor}}">
    <div class="md:col-span-2">
        By {{$post->user->profile->full_name}}
    </div>
    <div class="md:mt-0 md:col-span-4">
        <div class="float-right">
            {{ $post->created_at->format('M j, Y') }} |
            <div class="inline-block">
                {{ $post->readingTime('minutes') }} min read
            </div>
        </div>
    </div>
</div>