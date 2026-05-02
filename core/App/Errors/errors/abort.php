<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code ?> - <?= $message ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 select-none">

<div class="mx-auto text-white flex items-center justify-center h-screen">
    <div class="flex items-center justify-center h-9">
        <div class="h-full">
            <p class="text-zinc-700 font-light text-2xl">
                <?= $code ?>
            </p>
        </div>
        <div class="mx-2 border-r border-zinc-700 h-full"></div>
        <div class="h-full">
            <p class="text-zinc-700 font-light text-2xl">
                <?= $message ?>
            </p>
        </div>
    </div>
</div>

</body>
</html>
