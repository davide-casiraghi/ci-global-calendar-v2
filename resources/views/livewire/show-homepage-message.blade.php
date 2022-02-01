<div>
    @include('partials.contextualFeedback', [
                'message' => $message->body,
                'color' => 'warning',
                'extraClasses' => 'mb-4 mt-4 z-20 relative max-w-2xl m-auto',
            ])
</div>
