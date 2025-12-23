<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Event Ticketing')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body class="{{ Route::is('login', 'register', 'password.request', 'password.reset', 'register.organizer') ? 'no-scroll' : '' }}">

    @unless(Route::is('login') || Route::is('register') || Route::is('password.request') || Route::is('password.reset') || Route::is('register.organizer'))
    @include('partials.navbar')
    @endunless

    @yield('content')

    @unless(Route::is('login') || Route::is('register') || Route::is('password.request') || Route::is('password.reset') || Route::is('register.organizer'))
    @include('partials.footer')
    @endunless

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('darkModeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const body = document.body;

            // 1. Fungsi untuk mengaktifkan Dark Mode
            const enableDarkMode = () => {
                body.classList.add('dark-mode');
                // Pastikan themeIcon ada sebelum memodifikasi class-nya
                if (themeIcon) {
                    themeIcon.classList.remove('bi-moon-stars-fill');
                    themeIcon.classList.add('bi-sun-fill', 'text-warning');
                }
                localStorage.setItem('theme', 'dark');
            };

            // 2. Fungsi untuk mematikan Dark Mode
            const disableDarkMode = () => {
                body.classList.remove('dark-mode');
                // Pastikan themeIcon ada sebelum memodifikasi class-nya
                if (themeIcon) {
                    themeIcon.classList.remove('bi-sun-fill', 'text-warning');
                    themeIcon.classList.add('bi-moon-stars-fill');
                }
                localStorage.setItem('theme', 'light');
            };

            // 3. Logika Penentuan Tema (Prioritas: Manual > System)
            const determineTheme = () => {
                const savedTheme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (savedTheme === 'dark') {
                    enableDarkMode();
                } else if (savedTheme === 'light') {
                    disableDarkMode();
                } else if (systemPrefersDark) {
                    enableDarkMode();
                }
            };

            // Jalankan saat pertama kali load
            determineTheme();

            // 4. Listener untuk Tombol Klik (Hanya jika tombol ada di halaman)
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    if (body.classList.contains('dark-mode')) {
                        disableDarkMode();
                    } else {
                        enableDarkMode();
                    }
                });
            }

            // 5. Listener untuk Perubahan Tema Sistem secara Real-time
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    e.matches ? enableDarkMode() : disableDarkMode();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglers = document.querySelectorAll('.toggle-password');
            togglers.forEach(toggler => {
                toggler.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('bi-eye', 'bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('bi-eye-slash', 'bi-eye');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>