<?php
/**
 * Web Import Razze - Importazione via Browser
 *
 * INSTALLAZIONE:
 * 1. Carica questo file nella root di WordPress
 * 2. Carica la cartella "complete corrette" nella root di WordPress
 * 3. Visita: https://tuosito.it/web-import-razze.php
 * 4. Inserisci la password: importa2024
 * 5. Clicca "Avvia Importazione"
 *
 * SICUREZZA: Elimina questo file dopo l'importazione!
 */

// PASSWORD DI SICUREZZA - Cambiala prima di usare!
define('IMPORT_PASSWORD', 'importa2024');

// Carica WordPress
require_once __DIR__ . '/wp-load.php';

// Verifica password
session_start();
$authenticated = false;

if (isset($_POST['password']) && $_POST['password'] === IMPORT_PASSWORD) {
    $_SESSION['import_authenticated'] = true;
}

if (isset($_SESSION['import_authenticated']) && $_SESSION['import_authenticated'] === true) {
    $authenticated = true;
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importazione Razze - Cani in Casa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { font-size: 28px; margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 40px; }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        input[type="password"], input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-box .number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        .stat-box .label {
            color: #666;
            margin-top: 5px;
        }
        #progress-container {
            display: none;
            margin-top: 30px;
        }
        .progress-bar {
            background: #e0e0e0;
            border-radius: 10px;
            height: 30px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .progress-fill {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            width: 0%;
            transition: width 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        #log {
            background: #1e1e1e;
            color: #00ff00;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            max-height: 400px;
            overflow-y: auto;
            line-height: 1.6;
        }
        .success { color: #00ff00; }
        .error { color: #ff4444; }
        .info { color: #00bfff; }
        .warning { color: #ffaa00; }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐕 Importazione Razze Canine</h1>
            <p>Cani in Casa - Sistema di Import Automatico</p>
        </div>

        <div class="content">
            <?php if (!$authenticated): ?>
                <!-- LOGIN FORM -->
                <form method="POST" class="login-form">
                    <div class="form-group">
                        <label for="password">🔒 Password di Accesso</label>
                        <input type="password" id="password" name="password" placeholder="Inserisci la password" required autofocus>
                    </div>
                    <button type="submit" class="btn">Accedi</button>
                    <p style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
                        Password predefinita: <code>importa2024</code>
                    </p>
                </form>
            <?php else: ?>
                <!-- IMPORT INTERFACE -->
                <div class="stats">
                    <div class="stat-box">
                        <div class="number">320</div>
                        <div class="label">Razze Totali</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">32</div>
                        <div class="label">File JSON</div>
                    </div>
                    <div class="stat-box">
                        <div class="number" id="imported-count">0</div>
                        <div class="label">Importate</div>
                    </div>
                </div>

                <button onclick="startImport()" class="btn" id="start-btn">
                    🚀 Avvia Importazione
                </button>

                <div id="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill">0%</div>
                    </div>
                    <div id="log"></div>
                </div>

                <div class="logout">
                    <a href="?logout=1">Esci</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($authenticated): ?>
    <script>
        function addLog(message, type = 'info') {
            const log = document.getElementById('log');
            const timestamp = new Date().toLocaleTimeString('it-IT');
            const className = type;
            log.innerHTML += `<div class="${className}">[${timestamp}] ${message}</div>`;
            log.scrollTop = log.scrollHeight;
        }

        function updateProgress(current, total) {
            const percent = Math.round((current / total) * 100);
            const fill = document.getElementById('progress-fill');
            const count = document.getElementById('imported-count');

            fill.style.width = percent + '%';
            fill.textContent = percent + '%';
            count.textContent = current;
        }

        async function startImport() {
            const btn = document.getElementById('start-btn');
            const progressContainer = document.getElementById('progress-container');

            btn.disabled = true;
            btn.textContent = '⏳ Importazione in corso...';
            progressContainer.style.display = 'block';

            addLog('🚀 Avvio importazione...', 'info');
            addLog('📂 Ricerca file JSON...', 'info');

            try {
                const response = await fetch('web-import-razze-ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'import' })
                });

                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';

                while (true) {
                    const { value, done } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop(); // Keep incomplete line in buffer

                    for (const line of lines) {
                        if (line.trim()) {
                            try {
                                const data = JSON.parse(line);

                                if (data.type === 'progress') {
                                    updateProgress(data.current, data.total);
                                    addLog(`✓ ${data.breed} - ${data.message}`, 'success');
                                } else if (data.type === 'error') {
                                    addLog(`✗ ${data.message}`, 'error');
                                } else if (data.type === 'info') {
                                    addLog(data.message, 'info');
                                } else if (data.type === 'complete') {
                                    addLog('', 'info');
                                    addLog('═══════════════════════════════════════', 'success');
                                    addLog('✅ IMPORTAZIONE COMPLETATA!', 'success');
                                    addLog(`📦 Razze importate: ${data.imported}/${data.total}`, 'success');
                                    addLog(`⏱️  Tempo impiegato: ${data.time}`, 'info');
                                    addLog('═══════════════════════════════════════', 'success');
                                    btn.textContent = '✅ Importazione Completata';
                                    btn.style.background = '#28a745';
                                }
                            } catch (e) {
                                console.error('Parse error:', e, line);
                            }
                        }
                    }
                }
            } catch (error) {
                addLog('❌ Errore durante l\'importazione: ' + error.message, 'error');
                btn.disabled = false;
                btn.textContent = '🔄 Riprova Importazione';
            }
        }
    </script>
    <?php endif; ?>
</body>
</html>
