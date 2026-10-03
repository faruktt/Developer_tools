<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon | We're Launching Soon</title>
    <meta name="description" content="Something awesome is on its way. Stay tuned for our launch!">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-primary: #0a0c16;
            --bg-secondary: #111425;
            --accent-glow: #6366f1;
            --accent-cyan: #06b6d4;
            --accent-pink: #ec4899;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(20px);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        /* Ambient Glow Backgrounds */
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(140px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.45;
            animation: float 14s ease-in-out infinite alternate;
        }

        .glow-1 {
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }

        .glow-2 {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, var(--accent-cyan) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            animation-duration: 18s;
            animation-delay: -5s;
        }

        .glow-3 {
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, var(--accent-pink) 0%, transparent 70%);
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.25;
            animation-duration: 20s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }
            100% {
                transform: translate(40px, 50px) scale(1.12);
            }
        }

        /* Subtle Grid Pattern */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(circle at center, black 40%, transparent 85%);
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 85%);
            z-index: 0;
            pointer-events: none;
        }

        /* Header */
        header {
            position: relative;
            z-index: 10;
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
        }

        .logo-icon svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
        }

        /* Main Content */
        main {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 1.5rem;
            text-align: center;
        }

        /* Status Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 1.15rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            backdrop-filter: var(--glass-blur);
            font-size: 0.85rem;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #22c55e;
            box-shadow: 0 0 10px #22c55e;
            position: relative;
        }

        .badge-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 1.5px solid #22c55e;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.6);
                opacity: 0.9;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* Typography */
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.25rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #ffffff 30%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .highlight-text {
            background: linear-gradient(135deg, #818cf8 0%, #22d3ee 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.65;
            font-weight: 400;
        }

        /* Countdown Grid */
        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            max-width: 580px;
            margin: 0 auto 2.75rem;
        }

        .countdown-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 1.25rem 0.5rem;
            backdrop-filter: var(--glass-blur);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .countdown-card:hover {
            transform: translateY(-4px);
            border-color: rgba(99, 102, 241, 0.35);
        }

        .countdown-number {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 0.35rem;
            font-variant-numeric: tabular-nums;
        }

        .countdown-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Subscription Form */
        .form-container {
            max-width: 480px;
            margin: 0 auto 2.5rem;
        }

        .subscribe-form {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 0.35rem;
            backdrop-filter: var(--glass-blur);
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .subscribe-form:focus-within {
            border-color: var(--accent-glow);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .subscribe-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            padding: 0.85rem 1.15rem;
            color: var(--text-main);
            font-size: 0.95rem;
            font-family: inherit;
        }

        .subscribe-input::placeholder {
            color: #64748b;
        }

        .subscribe-button {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            outline: none;
            color: #ffffff;
            padding: 0.85rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .subscribe-button:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
        }

        .subscribe-button:active {
            transform: translateY(0);
        }

        .form-message {
            font-size: 0.85rem;
            margin-top: 0.75rem;
            min-height: 1.25rem;
            transition: opacity 0.3s ease;
        }

        .form-message.success {
            color: #4ade80;
        }

        .form-message.error {
            color: #f87171;
        }

        /* Social Icons */
        .socials {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-link {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .social-link svg {
            width: 18px;
            height: 18px;
            transition: transform 0.25s ease;
        }

        .social-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .social-link:hover svg {
            transform: scale(1.1);
        }

        /* Footer */
        footer {
            position: relative;
            z-index: 10;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Responsive Breakpoints */
        @media (max-width: 640px) {
            .countdown {
                gap: 0.5rem;
            }

            .countdown-card {
                padding: 1rem 0.25rem;
                border-radius: 14px;
            }

            .countdown-number {
                font-size: 1.75rem;
            }

            .countdown-label {
                font-size: 0.65rem;
            }

            .subscribe-form {
                flex-direction: column;
                gap: 0.5rem;
                background: transparent;
                border: none;
                padding: 0;
            }

            .subscribe-input {
                width: 100%;
                background: rgba(255, 255, 255, 0.04);
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 12px;
            }

            .subscribe-button {
                width: 100%;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Ambient Glows -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>
    <div class="ambient-glow glow-3"></div>
    <div class="bg-grid"></div>

    <!-- Header / Brand -->
    <header>
        <a href="/" class="logo">
            <div class="logo-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span>{{ config('app.name', 'Laravel') }}</span>
        </a>
    </header>

    <!-- Main Hero -->
    <main>
        <!-- Status Pill -->
        <div class="badge">
            <span class="badge-dot"></span>
            <span>We are launching soon</span>
        </div>

        <!-- Headline -->
        <h1>
            <span class="gradient-text">Coming</span> <span class="highlight-text">Soon</span>
        </h1>

        <!-- Subtitle -->
        <p class="description">
            We are crafting something truly special and impactful. Our new platform is almost ready to elevate your digital experience.
        </p>

        <!-- Countdown Timer -->
        <div class="countdown" id="countdown">
            <div class="countdown-card">
                <div class="countdown-number" id="days">24</div>
                <div class="countdown-label">Days</div>
            </div>
            <div class="countdown-card">
                <div class="countdown-number" id="hours">18</div>
                <div class="countdown-label">Hours</div>
            </div>
            <div class="countdown-card">
                <div class="countdown-number" id="minutes">45</div>
                <div class="countdown-label">Minutes</div>
            </div>
            <div class="countdown-card">
                <div class="countdown-number" id="seconds">30</div>
                <div class="countdown-label">Seconds</div>
            </div>
        </div>

        <!-- Early Access Notification Form -->
        <div class="form-container">
            <form class="subscribe-form" id="notifyForm" onsubmit="handleNotify(event)">
                <input 
                    type="email" 
                    id="emailInput"
                    class="subscribe-input" 
                    placeholder="Enter your email address..." 
                    required 
                    autocomplete="email"
                />
                <button type="submit" class="subscribe-button">Notify Me</button>
            </form>
            <div class="form-message" id="formMessage"></div>
        </div>

        <!-- Social Media Links -->
        <div class="socials">
            <a href="#" class="social-link" aria-label="Twitter / X">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
            <a href="#" class="social-link" aria-label="GitHub">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
            </a>
            <a href="#" class="social-link" aria-label="LinkedIn">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
            </a>
            <a href="#" class="social-link" aria-label="Discord">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.893.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                </svg>
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>

    <!-- Countdown & Interactivity Script -->
    <script>
        // Set target launch date (30 days from today)
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 30);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;

            if (distance < 0) {
                document.getElementById('days').innerText = '00';
                document.getElementById('hours').innerText = '00';
                document.getElementById('minutes').innerText = '00';
                document.getElementById('seconds').innerText = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = String(days).padStart(2, '0');
            document.getElementById('hours').innerText = String(hours).padStart(2, '0');
            document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
            document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Notify form handler
        function handleNotify(event) {
            event.preventDefault();
            const input = document.getElementById('emailInput');
            const message = document.getElementById('formMessage');

            if (!input.value) return;

            message.textContent = "Thank you! We'll notify you as soon as we launch.";
            message.className = 'form-message success';
            input.value = '';

            setTimeout(() => {
                message.textContent = '';
                message.className = 'form-message';
            }, 6000);
        }
    </script>
</body>
</html>
