<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Linking') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Linking Your Account With Google') }}
        </p>
    </header>
     @if(Auth::user()->google_id)
                <p style="color:white;">Your Google account is already connected!</p>
                @else
            <a href="{{ route('google.connect.redirect') }}" class="btn btn-primary" style="color:white;">Connect with Google</a>
            @endif 
</section>
