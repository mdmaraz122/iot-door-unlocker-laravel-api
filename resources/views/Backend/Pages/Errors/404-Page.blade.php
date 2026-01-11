<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #0f172a;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            margin: 0;
            color: white;
            user-select: none;
            -webkit-user-select: none;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        .error-text {
            font-size: 8rem;
            font-weight: 800;
            background: linear-gradient(45deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
        }

        .btn-home {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-home:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .error-text {
                font-size: 6rem;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-6">
<div class="text-center">
    <!-- 404 Number -->
    <div class="error-text mb-4">404</div>

    <!-- Message -->
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-200 mb-4">
        Page Not Found
    </h1>

    <p class="text-gray-400 mb-12 max-w-md">
        The page you are looking for doesn't exist or has been moved.
    </p>

    <!-- Home Button -->
    <a href="{{ route('home') }}"
        id="homeBtn"
        class="btn-home text-white font-medium py-3 px-8 rounded-xl text-lg cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        Go Home
    </a>
</div>
</body>
</html>
