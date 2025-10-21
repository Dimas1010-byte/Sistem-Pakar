<?php
// Reusable header - includes head, styles, and opening body + header/nav
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>College Compass</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: '#42b6f0',
                            'background-light': '#f6f7f8',
                            'background-dark': '#101c22',
                        },
                        fontFamily: { display: ['Plus Jakarta Sans'] },
                        borderRadius: { DEFAULT: '0.5rem', lg: '1rem', xl: '1.5rem', full: '9999px' },
                    },
                },
            };
        </script>

        <!-- Custom stylesheet extracted from PHP files -->
        <link rel="stylesheet" href="assets/css/custom.css" />
    </head>
    <body id="page-body" class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-slate-200">
        <div class="flex flex-col min-h-screen">
            <header class="sticky top-0 z-50 header-sea header-glass">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-20">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 text-primary">
                                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img">
                                        <defs>
                                            <linearGradient id="logoGrad" x1="0%" x2="100%" y1="0%" y2="100%">
                                                <stop offset="0%" stop-color="#7dd3fc" />
                                                <stop offset="50%" stop-color="#67e8f9" />
                                                <stop offset="100%" stop-color="#34d399" />
                                            </linearGradient>
                                            <filter id="softShadow" x="-20%" y="-20%" width="140%" height="140%">
                                                <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#0369a1" flood-opacity="0.22" />
                                            </filter>
                                        </defs>
                                        <g filter="url(#softShadow)">
                                            <path d="M42.4379 44C42.4379 44 36.0744 33.9038 41.1692 24C46.8624 12.9336 42.2078 4 42.2078 4L7.01134 4C7.01134 4 11.6577 12.932 5.96912 23.9969C0.876273 33.9029 7.27094 44 7.27094 44L42.4379 44Z" fill="url(#logoGrad)" stroke="#ffffff" stroke-opacity="0.22" stroke-width="1"></path>
                                        </g>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold brand-title text-white">Kompas Kampus</h2>
                        </div>

                        <nav class="hidden md:flex items-center gap-6">
                            <a class="nav-link text-sm font-medium text-white hover:opacity-90 transition-colors" href="index.php">Beranda</a>
                            <a class="nav-link text-sm font-medium text-white hover:opacity-90 transition-colors" href="soal.php">Soal</a>
                            <a class="nav-link text-sm font-medium text-white hover:opacity-90 transition-colors" href="#about">Tentang</a>
                        </nav>

                        <div class="hidden md:flex items-center gap-3">
                            <button id="loginBtn" class="px-4 py-2 text-sm font-semibold rounded-full btn-ghost transition-colors">Login</button>
                            <button id="signupBtn" class="px-4 py-2 text-sm font-semibold rounded-full btn-primary-filled transition-shadow">Daftar</button>
                            <button id="darkToggle" class="px-3 py-2 ml-2 rounded-full bg-white/10 text-white" title="Toggle dark mode">
                                <span class="material-symbols-outlined">dark_mode</span>
                            </button>
                        </div>

                        <div class="md:hidden flex items-center gap-2">
                            <button id="darkToggleMobile" class="text-white mr-2 bg-white/10 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined">dark_mode</span>
                            </button>
                            <button class="md:hidden text-white bg-white/10 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined">menu</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <script>
                // Dark mode toggle: save preference to localStorage
                (function () {
                    const body = document.getElementById('page-body');
                    function apply(pref) {
                        if (pref === 'dark') body.classList.add('dark');
                        else body.classList.remove('dark');
                    }
                    const stored = localStorage.getItem('cc_theme');
                    apply(stored || 'light');

                    function toggle() {
                        const now = body.classList.contains('dark') ? 'light' : 'dark';
                        apply(now);
                        localStorage.setItem('cc_theme', now);
                    }

                    document.getElementById('darkToggle')?.addEventListener('click', toggle);
                    document.getElementById('darkToggleMobile')?.addEventListener('click', toggle);
                })();
            </script>
