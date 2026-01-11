<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Unlock | Smart Door Unlocker</title>
    <script src="{{ url('https://cdn.tailwindcss.com') }}"></script>
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}">
    <link rel="preconnect" href="{{ url('https://fonts.googleapis.com') }}">
    <link rel="preconnect" href="{{ url('https://fonts.gstatic.com') }}" crossorigin>
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/smart-unlock.png') }}">
    <style>
        :root {
            --primary-purple: #08ffff;
            --primary-blue: #f63bed;
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--dark-bg);
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Oil/Gloss Effect */
        .oil-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: oilFloat 20s ease-in-out infinite alternate;
        }

        .gloss-effect {
            background: linear-gradient(145deg,
            rgba(255, 255, 255, 0.05) 0%,
            rgba(255, 255, 255, 0.1) 50%,
            rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .gloss-button {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-blue) 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            color: black;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        }

        .gloss-button::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 80%);
            transform: rotate(30deg);
            transition: transform 0.5s ease;
        }

        .gloss-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.5);
        }

        .gloss-button:hover::after {
            transform: rotate(30deg) translateX(20px);
        }

        /* Typography */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-blue) 100%);

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .heading-xl {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.025em;
        }

        .heading-lg {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .heading-md {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Animations */
        @keyframes oilFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(-20px, 10px) scale(1.05);
            }
            66% {
                transform: translate(10px, -15px) scale(1.02);
            }
            100% {
                transform: translate(20px, 5px) scale(1.08);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.8);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--primary-purple), var(--primary-blue));
            border-radius: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .heading-xl {
                font-size: 3rem;
            }

            .heading-lg {
                font-size: 2.25rem;
            }

            .heading-md {
                font-size: 1.75rem;
            }
        }
    /*    */
        /* Simple animation delays */
        .animation-delay-150 {
            animation-delay: 0.15s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        /* Hide loader */
        #simpleLoader.hidden {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s, visibility 0.5s;
        }



        /* Modern Glass Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg,
            rgba(8, 255, 255, 0.9) 0%,
            rgba(246, 59, 237, 0.9) 100%);
            border-radius: 8px;
            border: 2px solid rgba(15, 23, 42, 0.95);
            box-shadow:
                inset 0 0 6px rgba(255, 255, 255, 0.2),
                0 0 10px rgba(8, 255, 255, 0.3);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg,
            rgba(8, 255, 255, 1) 0%,
            rgba(246, 59, 237, 1) 100%);
            box-shadow:
                inset 0 0 8px rgba(255, 255, 255, 0.3),
                0 0 15px rgba(8, 255, 255, 0.5);
        }

        ::-webkit-scrollbar-corner {
            background: rgba(15, 23, 42, 0.95);
        }

        /* Firefox Scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(8, 255, 255, 0.8) rgba(15, 23, 42, 0.95);
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar animation */
        @keyframes scrollbarPulse {
            0%, 100% {
                box-shadow:
                    inset 0 0 6px rgba(255, 255, 255, 0.2),
                    0 0 10px rgba(8, 255, 255, 0.3);
            }
            50% {
                box-shadow:
                    inset 0 0 8px rgba(255, 255, 255, 0.3),
                    0 0 15px rgba(8, 255, 255, 0.5);
            }
        }

        ::-webkit-scrollbar-thumb:active {
            animation: scrollbarPulse 1s infinite;
        }
    </style>
</head>
<body class="relative">
<!-- Simple Smart Loader -->
<div id="minimalLoader" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
    <div class="relative">
        <!-- Spinning ring -->
        <div class="w-20 h-20 border-4 border-transparent border-t-purple-500 border-r-blue-500 rounded-full animate-spin"></div>

        <!-- Center icon -->
        <div class="absolute inset-0 flex items-center justify-center">
            <i class="fas fa-unlock text-white text-xl"></i>
        </div>
    </div>
</div>
<!-- Oil Effect Background -->
<div class="oil-overlay"></div>

<!-- Navigation -->
<nav class="gloss-effect sticky top-0 z-50 py-4 px-6 md:px-12">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/smart-unlock.png') }}" alt="Smart Unlock">
                </div>
                <span class="text-xl font-bold">
                    <span class="text-purple">Smart</span> Unlock
                </span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex items-center space-x-8">
            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-300 font-medium">Home</a>
            <a href="{{ route('backend.login') }}" class="gloss-button px-6 py-2 rounded-lg font-semibold">Login</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container mx-auto px-4 md:px-12 py-12">
    <!-- Hero Section -->
    <section class="py-12 md:py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="heading-xl mb-6">
                <span class="gradient-text">Smart Unlock</span><br>
                <span class="text-white">IoT-Based Door Unlock System</span><br>
            </h1>

            <p class="text-xl text-gray-300 mb-10 max-w-3xl mx-auto leading-relaxed">
                Smart Unlock is a web-based system that allows users to securely unlock doors remotely using a website.
            </p>

            <!-- Divider -->
            <div class="h-px w-32 mx-auto bg-gradient-to-r from-transparent via-purple-500 to-transparent my-12"></div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#features" class="gloss-button px-8 py-4 rounded-lg font-semibold text-lg flex items-center justify-center gap-3">
                    <i class="fas fa-rocket"></i>
                    Explore Features
                </a>
                <button class="px-8 py-4 rounded-lg font-semibold text-lg border border-cyan-700 hover:bg-cyan-800/50 transition duration-300 flex items-center justify-center gap-3">
                    <i class="fab fa-github"></i>
                    View on GitHub
                </button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="my-24" id="features">
        <h2 class="heading-lg text-center mb-12">Features</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="gloss-effect p-8 rounded-2xl hover:transform hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center mb-6">
                    <i class="fas fa-user-cog text-2xl text-white"></i>
                </div>
                <h3 class="heading-md mb-4">Role Management</h3>
                <p class="text-gray-300 mb-6">
                    Create, edit, and assign user roles with specific permissions. Control access through hierarchical roles such as Admin, Editor, and User for secure system management.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="gloss-effect p-8 rounded-2xl hover:transform hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center mb-6">
                    <i class="fa-solid fa-magnifying-glass-location text-2xl text-white"></i>
                </div>
                <h3 class="heading-md mb-4">IP Protection</h3>
                <p class="text-gray-300 mb-6">
                    The door unlock feature is accessible only from a fixed authorized IP address.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="gloss-effect p-8 rounded-2xl hover:transform hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center mb-6">
                    <i class="fa-regular fa-file-lines text-2xl text-white"></i>
                </div>
                <h3 class="heading-md mb-4">Reports</h3>
                <p class="text-gray-300 mb-6">
                    View and generate detailed system reports, including access logs, door activity, and user actions, for monitoring and analysis.
                </p>
            </div>
        </div>
    </section>

</main>

<!-- Footer -->
<footer class="gloss-effect mt-20 py-12 px-6 md:px-12">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-8 md:mb-0">
                <div class="flex items-center space-x-3 mb-4">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/smart-unlock.png') }}" alt="Smart Unlock">
                        </div>
                        <span class="text-xl font-bold">
                            <span class="text-purple">Smart</span> Unlock
                        </span>
                    </a>
                </div>
                <p class="text-gray-400 max-w-md">
                    Smart Unlock is a web-based system that allows users to securely unlock doors remotely using a website.
                </p>
            </div>

            <div class="flex flex-col items-center md:items-end">
                <div class="flex space-x-6 mb-6">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-github text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                </div>
                <p class="text-white-600 text-sm">Developed By <b><a href="">Md. Maraz</a></b></p>
            </div>
        </div>
    </div>
</footer>

<script>

    window.addEventListener('load', function() {
        document.getElementById('minimalLoader').style.display = 'none';
    });
    // Copy command functionality
    const copyCommandBtn = document.getElementById('copyCommand');
    const commandText = 'composer require laravel-auth-roles/package';

    copyCommandBtn.addEventListener('click', () => {
        navigator.clipboard.writeText(commandText).then(() => {
            const originalContent = copyCommandBtn.innerHTML;
            copyCommandBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            copyCommandBtn.classList.add('bg-green-900/30');

            setTimeout(() => {
                copyCommandBtn.innerHTML = originalContent;
                copyCommandBtn.classList.remove('bg-green-900/30');
            }, 2000);
        });
    });

    // Add floating animation to feature cards on hover
    const featureCards = document.querySelectorAll('.gloss-effect');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        });
    });

    // Tab switching for code examples
    const tabButtons = document.querySelectorAll('button:not(.gloss-button)');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-purple-700', 'to-blue-700');
                btn.classList.add('bg-gray-800');
            });

            // Add active class to clicked button
            this.classList.remove('bg-gray-800');
            this.classList.add('bg-gradient-to-r', 'from-purple-700', 'to-blue-700');
        });
    });

    // Animate oil overlay continuously
    const oilOverlay = document.querySelector('.oil-overlay');
    setInterval(() => {
        oilOverlay.style.animation = 'none';
        setTimeout(() => {
            oilOverlay.style.animation = 'oilFloat 20s ease-in-out infinite alternate';
        }, 10);
    }, 20000);
</script>
</body>
</html>
