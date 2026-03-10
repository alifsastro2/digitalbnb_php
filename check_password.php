<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Password Hash Checker - Digital BnB</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #1a1a2e;
            color: #eee;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .section {
            background: #16213e;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            border: 2px solid #0f3460;
        }
        h2 {
            color: #00d4ff;
            margin-top: 0;
        }
        .result {
            background: #0f3460;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            word-break: break-all;
        }
        .success {
            color: #00ff88;
            font-weight: bold;
        }
        .error {
            color: #ff4444;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #0f3460;
            border: 1px solid #00d4ff;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background: #00d4ff;
            color: #000;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px;
        }
        button:hover {
            background: #00a8cc;
        }
        .info {
            background: #2d4356;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #00d4ff;
        }
        code {
            background: #000;
            padding: 2px 6px;
            border-radius: 3px;
            color: #00ff88;
        }
    </style>
</head>
<body>
    <h1>🔐 Password Hash Checker & Generator</h1>
    
    <div class="section">
        <h2>📊 Test Password Hash dari Database</h2>
        <div class="info">
            <strong>Hash di database.sql:</strong><br>
            <code>$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi</code>
        </div>
        
        <?php
        // Hash yang ada di database.sql
        $db_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        
        // Test berbagai password
        $test_passwords = ['admin123', 'admin', 'password', '123456'];
        
        echo "<h3>Testing passwords:</h3>";
        foreach ($test_passwords as $test_pass) {
            $is_valid = password_verify($test_pass, $db_hash);
            $status = $is_valid ? '<span class="success">✓ MATCH!</span>' : '<span class="error">✗ No match</span>';
            echo "<div class='result'>Password: <code>$test_pass</code> → $status</div>";
        }
        ?>
    </div>

    <div class="section">
        <h2>🔑 Generate Hash Baru</h2>
        <p>Generate hash untuk password yang kamu inginkan:</p>
        
        <form method="POST">
            <label>Password yang ingin di-hash:</label>
            <input type="text" name="new_password" placeholder="Masukkan password..." value="admin123" required>
            <button type="submit" name="generate">Generate Hash</button>
        </form>
        
        <?php
        if (isset($_POST['generate'])) {
            $new_password = $_POST['new_password'];
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            
            echo "<div class='result'>";
            echo "<strong>Password:</strong> <code>$new_password</code><br><br>";
            echo "<strong>Hash yang dihasilkan:</strong><br>";
            echo "<code>$new_hash</code>";
            echo "</div>";
            
            echo "<div class='info'>";
            echo "<strong>📝 Cara menggunakannya:</strong><br>";
            echo "1. Copy hash di atas<br>";
            echo "2. Buka phpMyAdmin → database <code>digital_bnb</code> → tabel <code>admin_users</code><br>";
            echo "3. Edit record admin, paste hash baru ke kolom <code>password</code><br>";
            echo "4. Atau jalankan query SQL ini:<br><br>";
            echo "<code>UPDATE admin_users SET password = '$new_hash' WHERE username = 'admin';</code>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="section">
        <h2>🧪 Test Custom Hash</h2>
        <p>Verifikasi apakah suatu password cocok dengan hash-nya:</p>
        
        <form method="POST">
            <label>Password:</label>
            <input type="text" name="test_password" placeholder="Masukkan password..." required>
            
            <label>Hash:</label>
            <input type="text" name="test_hash" placeholder="Masukkan hash..." required>
            
            <button type="submit" name="verify">Verify</button>
        </form>
        
        <?php
        if (isset($_POST['verify'])) {
            $test_password = $_POST['test_password'];
            $test_hash = $_POST['test_hash'];
            
            $is_match = password_verify($test_password, $test_hash);
            
            if ($is_match) {
                echo "<div class='result success'>";
                echo "✓ PASSWORD COCOK!<br>";
                echo "Password <code>$test_password</code> sesuai dengan hash yang diberikan.";
                echo "</div>";
            } else {
                echo "<div class='result error'>";
                echo "✗ PASSWORD TIDAK COCOK<br>";
                echo "Password <code>$test_password</code> tidak sesuai dengan hash yang diberikan.";
                echo "</div>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>💡 Rekomendasi</h2>
        <div class="info">
            <strong>Opsi 1: Generate Hash Baru</strong><br>
            1. Gunakan form "Generate Hash Baru" di atas dengan password <code>admin123</code><br>
            2. Copy hash yang dihasilkan<br>
            3. Update di database menggunakan query SQL<br><br>
            
            <strong>Opsi 2: Buat User Baru via phpMyAdmin</strong><br>
            1. Generate hash untuk password yang kamu mau<br>
            2. Insert manual di tabel <code>admin_users</code><br><br>
            
            <strong>Opsi 3: Buat Script Registrasi</strong><br>
            Buat file PHP sementara untuk register admin baru, lalu hapus setelah selesai.
        </div>
    </div>

</body>
</html>
