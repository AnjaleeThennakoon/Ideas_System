
    <nav class="border-b border-border px-6">
        <div class=" max-w-7xl mx-auto h-16 flex items-center justify-between">
            <div>
                <a href="/">
                    <img src="/images/logo1.jpeg" alt="" width="100" alt="idea logo">
                </a>
            </div>

            <div class="flex gap-x-5">
                @auth
                    <a href="{{ route('profile.edit') }}">Edit profile </a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">Log Out</button>
                    </form>

                @endauth

                @guest
                        <a href="/login" >Sign In </a>
                        <a href="/register" class="btn">Register</a>
                @endguest


            </div>
        </div>
    </nav>
