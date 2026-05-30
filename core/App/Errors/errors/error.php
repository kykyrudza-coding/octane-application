<?php
$escape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $debug ? $escape($errorType) : 'Server Error' ?></title>

    <style>
        :root {
            --bg:        #0a0b0d;
            --surface:   #111318;
            --surface2:  #181b21;
            --border:    rgba(255,255,255,.08);
            --border-hov:rgba(255,255,255,.15);
            --text:      #f1f5f9;
            --muted:     #94a3b8;
            --muted2:    #64748b;
            --accent:    #ef4444;
            --accent-bg: rgba(239, 68, 68, 0.1);
            --hl-bg:     rgba(239, 68, 68, 0.15);

            /* Системні шрифти для швидкості та офлайн-роботи */
            --sans:      system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --mono:      ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            --radius:    8px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--sans);
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── top stripe ── */
        .stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
        }

        main {
            max-width: 1080px;
            margin: 0 auto;
            padding: 48px 24px 80px;
        }

        /* ── header ── */
        .header {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 32px;
        }

        .status-badge {
            flex-shrink: 0;
            padding: 4px 12px;
            background: var(--accent-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 6px;
            font-family: var(--mono);
            font-size: 13px;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: .02em;
            margin-top: 4px;
        }

        .header-text h1 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -.02em;
            margin-bottom: 8px;
            word-wrap: break-word;
        }

        .header-text .subtitle {
            font-family: var(--mono);
            font-size: 13.5px;
            color: var(--muted);
            word-break: break-all;
        }

        /* ── panels ── */
        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--muted);
            background: var(--surface2);
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-head .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--muted2);
            flex-shrink: 0;
        }

        .btn-copy {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-family: var(--sans);
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        .btn-copy:hover {
            background: var(--border);
            color: var(--text);
        }

        /* ── request ── */
        .request-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        }

        .req-cell {
            padding: 16px 20px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .req-cell:last-child { border-right: none; }

        .req-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--muted2);
            margin-bottom: 6px;
        }

        .req-val {
            font-family: var(--mono);
            font-size: 13.5px;
            color: var(--text);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ── code context ── */
        .code-wrap {
            overflow-x: auto;
            padding: 12px 0;
        }

        .code-line {
            display: grid;
            grid-template-columns: 60px 1fr;
            font-family: var(--mono);
            font-size: 13.5px;
            line-height: 1.6;
        }

        .code-line.hl {
            background: var(--hl-bg);
            font-weight: 500;
        }

        .ln {
            padding: 2px 16px 2px 0;
            text-align: right;
            color: var(--muted2);
            user-select: none;
            border-right: 2px solid transparent;
        }

        .code-line.hl .ln {
            color: var(--accent);
            border-right-color: var(--accent);
        }

        .lc {
            padding: 2px 20px 2px 20px;
            white-space: pre;
            color: var(--text);
        }

        .code-line.hl .lc { color: #ffffff; }

        /* ── trace ── */
        .trace-body {
            font-family: var(--mono);
            font-size: 13px;
            line-height: 1.6;
            color: var(--muted);
            padding: 20px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        /* ── production ── */
        .prod-wrap {
            padding: 24px;
            text-align: center;
        }

        .prod-wrap p {
            color: var(--muted);
            font-size: 16px;
        }

        @media (max-width: 640px) {
            main { padding: 32px 16px 56px; }
            .header { flex-direction: column; gap: 12px; }
            .request-grid { grid-template-columns: 1fr; }
            .req-cell { border-right: none; }
        }
    </style>
</head>
<body>
<div class="stripe"></div>
<main>
    <div class="header">
        <div class="status-badge"><?= $debug ? $escape($errorType) : '500' ?></div>
        <div class="header-text">
            <h1><?= $debug ? $escape($errorMessage) : 'Внутрішня помилка сервера' ?></h1>
            <?php if ($debug): ?>
                <div class="subtitle"><?= $escape($errorFile) ?>:<?= $escape($errorLine) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (! $debug): ?>
        <div class="panel">
            <div class="prod-wrap">
                <p>Сталася помилка під час обробки вашого запиту. Будь ласка, спробуйте пізніше.</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-head">
            <div class="panel-title"><div class="dot"></div>Request Detail</div>
        </div>
        <div class="request-grid">
            <div class="req-cell">
                <div class="req-label">Method</div>
                <div class="req-val"><?= $escape($requestSummary['method']) ?></div>
            </div>
            <div class="req-cell">
                <div class="req-label">URI</div>
                <div class="req-val" title="<?= $escape($requestSummary['uri']) ?>"><?= $escape($requestSummary['uri']) ?></div>
            </div>
            <div class="req-cell">
                <div class="req-label">Host</div>
                <div class="req-val"><?= $escape($requestSummary['host']) ?></div>
            </div>
            <div class="req-cell">
                <div class="req-label">Client IP</div>
                <div class="req-val"><?= $escape($requestSummary['ip']) ?></div>
            </div>
        </div>
    </div>

    <?php if ($debug && $codeContext !== []): ?>
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <div class="dot" style="background:var(--accent)"></div>
                    <?= $escape(basename($errorFile)) ?>
                </div>
            </div>
            <div class="code-wrap">
                <?php foreach ($codeContext as $line): ?>
                    <div class="code-line<?= $line['highlight'] ? ' hl' : '' ?>">
                        <div class="ln"><?= $escape($line['number']) ?></div>
                        <div class="lc"><?= $escape($line['content']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($debug && $errorTrace !== ''): ?>
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><div class="dot"></div>Stack Trace</div>
                <button class="btn-copy" onclick="copyTrace(this)">Copy</button>
            </div>
            <div class="trace-body" id="stack-trace"><?= $escape($errorTrace) ?></div>
        </div>
    <?php endif; ?>
</main>

<script>
    function copyTrace(btn) {
        const traceText = document.getElementById('stack-trace').innerText;
        navigator.clipboard.writeText(traceText).then(() => {
            const originalText = btn.innerText;
            btn.innerText = 'Copied!';
            btn.style.color = '#fff';
            btn.style.borderColor = 'var(--accent)';
            setTimeout(() => {
                btn.innerText = originalText;
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }
</script>
</body>
</html>