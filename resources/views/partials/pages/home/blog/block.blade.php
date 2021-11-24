
<div class="relative bg-gray-50 pt-4 pb-10 px-4 sm:px-6 lg:mt-20 lg:mb-10 lg:px-8">
    <div class="absolute inset-0">
        <div class="bg-white h-1/3 sm:h-2/3"></div>
    </div>
    <div class="relative max-w-7xl mx-auto">
        <div class="text-center">
            <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                From the blog
            </h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.
            </p>
        </div>

        <div class="px-4 py-2 mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
            @foreach($lastPosts as $post)
                @include('partials.pages.home.blog.block_post')
            @endforeach
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('posts.blog') }}" class="font-medium rounded-md text-white px-4 py-2 bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary active:bg-primary-700 transition ease-in-out duration-150">All blog articles</a>
        </div>
    </div>
</div>
