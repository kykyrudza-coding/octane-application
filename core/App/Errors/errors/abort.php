<?php
$escape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$displayMessage = $message !== '' ? $message : 'Server Error';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $escape($code) ?> — <?= $escape($displayMessage) ?></title>

    <style>
        :root {
            --bg:      #f3f4f6;
            --text:    #374151;
            --muted:   #9ca3af;
            --border:  #d1d5db;
            --font:    ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
            "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
            sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
            "Segoe UI Symbol", "Noto Color Emoji";
        }

        *, ::before, ::after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
        }

        html, body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font);
            font-weight: 300;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .wrapper {
            display: flex;
            align-items: center;
            max-width: 100%;
        }

        .code {
            flex-shrink: 0;
            font-size: 2.25rem;
            line-height: 1;
            font-weight: 200;
            letter-spacing: 0.04em;
            color: var(--muted);
            padding-right: 1rem;
            margin-right: 1rem;
            border-right: 1px solid var(--border);
        }

        .message {
            font-size: 1.25rem;
            line-height: 1.6;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            word-break: break-word;
            max-width: 480px;
        }

        @media (max-width: 480px) {
            .wrapper {
                flex-direction: column;
                text-align: center;
            }

            .code {
                padding-right: 0;
                margin-right: 0;
                padding-bottom: 1rem;
                margin-bottom: 1rem;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="wrapper">
        <div class="code"><?= $escape($code) ?></div>
        <div class="message"><?= $escape($displayMessage) ?></div>
    </div>
</div>
</body>
</html>