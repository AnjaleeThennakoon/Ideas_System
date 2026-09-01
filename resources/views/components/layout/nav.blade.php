
    <nav class="border-b border-border px-6">
        <div class=" max-w-7xl mx-auto h-16 flex items-center justify-between">
            <div>
                <a href="/">
                    <img src="/images/image.jpg" alt="" width="100" alt="idea logo">
                </a>
            </div>

            <div class="flex gap-x-5">
                @auth
                    <form method="POST" action="/logout"
                    @csrf
                    <button>Log Out </button>

                @endauth

                @guest
                        <a href="/login" >Sign In </a>
                        <a href="/register" class="btn">Register</a>
                @endguest


            </div>
        </div>
    </nav>
