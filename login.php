<?php
session_start();
include 'includes/db_connect.php';

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Traffic Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: var(--secondary-color);
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-form {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        
        .login-form h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-form .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-form .logo img {
            height: 60px;
        }
        
        .login-form .form-group {
            margin-bottom: 20px;
        }
        
        .login-form .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .login-form .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 1rem;
        }
        
        .login-form .error {
            color: var(--danger-color);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .login-form button {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            margin-top: 10px;
        }
        
        .login-form .register-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="logo">
                <img src="assets/img/logo.svg" alt="TrafficSafe">
            </div>
            
            <h1>Traffic Management Login</h1>
            
            <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Log In</button>
            </form>
            
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
</body>
</html>
