<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Octane</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <?php echo vite('ui/js/app.js'); ?>
</head>

<body class="min-h-screen bg-neutral-150 text-neutral-950 selection:bg-black selection:text-white">
<main class="min-h-screen flex items-center justify-center px-6">
    <section class="w-full max-w-2xl">

        <div class="mb-10">
            <p class="text-xs font-medium uppercase tracking-[0.28em] text-neutral-500">
                Octane
            </p>

            <h1 class="mt-4 text-4xl md:text-5xl font-semibold tracking-[-0.04em] text-black">
                Your application is ready.
            </h1>

            <p class="mt-5 max-w-xl text-base leading-7 text-neutral-400">
                Octane has been installed successfully. Open the documentation,
                explore the source, or start building your application.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="https://github.com/kykyrudza/octane-application"
               target="_blank"
               class="rounded-lg bg-black px-4 py-2.5 text-sm font-semibold text-neutral-100 hover:bg-neutral-800 transition">
                Documentation
            </a>

            <a href="https://github.com/kykyrudza/octane-framework"
               target="_blank"
               class="rounded-lg border border-neutral-200 px-4 py-2.5 text-sm font-semibold text-neutral-800 hover:bg-neutral-200 transition">
                GitHub
            </a>

            <a href="https://github.com/kykyrudza/octane-framework/releases"
               target="_blank"
               class="rounded-lg border border-neutral-200 px-4 py-2.5 text-sm font-semibold text-neutral-800 hover:bg-neutral-200 transition">
                Releases
            </a>
        </div>

        <footer class="mt-12 border-t border-neutral-800 pt-6 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between text-xs text-neutral-600">
            <span>
                <?php echo htmlspecialchars((string)(app()->version()), ENT_QUOTES, 'UTF-8'); ?>
            </span>
            <span>PHP <?php echo htmlspecialchars((string)(PHP_VERSION), ENT_QUOTES, 'UTF-8'); ?></span>
        </footer>

    </section>
</main>
</body>
</html>
