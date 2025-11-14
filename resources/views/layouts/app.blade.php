<!DOCTYPE html>
<html lang="nl" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Werkrooster</title>
    @vite('resources/js/app.js')
    <style>
        :root {
            --bg: #f1f5f9;
            --bg-card: #ffffff;
            --bg-soft: #e5e7eb;
            --text: #0f172a;
            --text-sub: #6b7280;
            --primary: #0ea5e9;
            --danger: #ef4444;
        }
        [data-theme="dark"] {
            --bg: #020617;
            --bg-card: #0f172a;
            --bg-soft: #111827;
            --text: #e5e7eb;
            --text-sub: #9ca3af;
            --primary: #38bdf8;
            --danger: #f97373;
        }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .app-shell {
            max-width: 1100px;
            margin: 0 auto;
            padding: 16px;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .nav-links {
            display: flex;
            gap: 8px;
        }
        .nav a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--bg-soft);
            color: var(--text-sub);
            font-size: 0.85rem;
        }
        .nav a.active {
            background: var(--primary);
            color: #fff;
        }
        .btn-toggle-theme {
            border-radius: 999px;
            border: none;
            padding: 6px 12px;
            font-size: 0.85rem;
            cursor: pointer;
            background: var(--bg-soft);
            color: var(--text-sub);
        }
        .card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.08);
        }
        .badge-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 999px;
        }
    </style>
</head>
<body>
<div id="layout">
    <div class="app-shell">
        <header class="nav">
            <div>
                <strong>Werkrooster</strong>
            </div>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('schedule.index') }}" class="{{ request()->routeIs('schedule.*') ? 'active' : '' }}">Rooster</a>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">Instellingen</a>
                <a href="{{ route('system.scheduler') }}" class="{{ request()->routeIs('system.scheduler') ? 'active' : '' }}">Systeem</a>
            </div>
            <button id="theme-toggle" class="btn-toggle-theme" type="button">🌙</button>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
</div>

<script>
    (function() {
        const root = document.documentElement;
        const stored = localStorage.getItem('theme') || 'light';
        root.setAttribute('data-theme', stored);
        const btn = document.getElementById('theme-toggle');
        if (btn) {
            btn.textContent = stored === 'light' ? '🌙' : '☀️';
            btn.addEventListener('click', () => {
                const current = root.getAttribute('data-theme') || 'light';
                const next = current === 'light' ? 'dark' : 'light';
                root.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                btn.textContent = next === 'light' ? '🌙' : '☀️';
            });
        }
    })();
</script>
</body>
</html>
