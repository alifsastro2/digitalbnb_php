<?php
/**
 * SCRIPT REGISTRASI ADMIN SEMENTARA
 * Upload ke folder digital_bnb, akses sekali, lalu HAPUS file ini!
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Setup Admin - Digital BnB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a2e;
            color: #eee;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }
        .box {
            background: #16213e;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #00d4ff;
        }
        h1 { color: #00d4ff; margin-top: 0; }
        .success { 
            background: #00ff88; 
            color: #000; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0;
            font-weight: bold;
        }
        .error { 
            background: #ff4444; 
            color: #fff; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0;
        }
        .info {
            background: #0f3460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #00d4ff;
        }
        code {
            background: #000;
            padding: 2px 6px;
            border-radius: 3px;
            color: #00ff88;
        }
        button {
            background: #00d4ff;
            color: #000;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover { background: #00a8cc; }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #0f3460;
            border: 1px solid #00d4ff;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #00d4ff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class='box'>
        <h1>🔧 Setup Admin User</h1>";

// Cek apakah form sudah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        echo "<div class='error'>❌ Username dan password harus diisi!</div>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Cek apakah username sudah ada
        $check_stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update password yang sudah ada
            $update_stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_password, $username);
            
            if ($update_stmt->execute()) {
                echo "<div class='success'>";
                echo "✅ Password untuk user <code>$username</code> berhasil diperbarui!<br><br>";
                echo "<strong>Login credentials:</strong><br>";
                echo "Username: <code>$username</code><br>";
                echo "Password: <code>$password</code><br><br>";
                echo "Hash: <code>$hashed_password</code>";
                echo "</div>";
                
                echo "<div class='info'>";
                echo "🎯 <strong>Sekarang kamu bisa:</strong><br>";
                echo "1. Login ke <a href='login.php' style='color: #00d4ff;'>login.php</a><br>";
                echo "2. <strong style='color: #ff4444;'>HAPUS file register_admin.php ini!</strong> (penting untuk keamanan)";
                echo "</div>";
            } else {
                echo "<div class='error'>❌ Gagal update password: " . $conn->error . "</div>";
            }
        } else {
            // Insert user baru
            $insert_stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $username, $hashed_password);
            
            if ($insert_stmt->execute()) {
                echo "<div class='success'>";
                echo "✅ Admin user berhasil dibuat!<br><br>";
                echo "<strong>Login credentials:</strong><br>";
                echo "Username: <code>$username</code><br>";
                echo "Password: <code>$password</code><br><br>";
                echo "Hash: <code>$hashed_password</code>";
                echo "</div>";
                
                echo "<div class='info'>";
                echo "🎯 <strong>Sekarang kamu bisa:</strong><br>";
                echo "1. Login ke <a href='login.php' style='color: #00d4ff;'>login.php</a><br>";
                echo "2. <strong style='color: #ff4444;'>HAPUS file register_admin.php ini!</strong> (penting untuk keamanan)";
                echo "</div>";
            } else {
                echo "<div class='error'>❌ Gagal membuat user: " . $conn->error . "</div>";
            }
        }
    }
}

// Tampilkan daftar admin yang ada
echo "<h2>👥 Admin Users Saat Ini:</h2>";
echo "<div class='info'>";
$result = $conn->query("SELECT id, username, created_at FROM admin_users");
if ($result->num_rows > 0) {
    echo "<table style='width: 100%; color: #fff;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Created At</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><code>" . $row['username'] . "</code></td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada admin user.";
}
echo "</div>";

?>

        <h2>➕ Buat/Update Admin User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" value="admin" required>
            
            <label>Password:</label>
            <input type="text" name="password" value="admin123" required>
            
            <div class="info" style="margin-top: 20px;">
                ℹ️ Jika username sudah ada, password akan di-update.<br>
                Jika belum ada, user baru akan dibuat.
            </div>
            
            <button type="submit" name="create_admin">Buat/Update Admin</button>
        </form>

    </div>
</body>
</html>

<?php
$conn->close();
?>
