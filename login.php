<?php
session_start();
include("config_local.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql); 
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt); 		
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No account found with that username.";
    }

    mysqli_stmt_close($stmt);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: url('assets/foodbg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .navbar {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
        }

        .navbar a {
            margin: 0 25px;
            text-decoration: none;
            color: #000;
            font-size: 18px;
            font-weight: bold;
        }

        .form-box {
            max-width: 420px;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.96);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 14px rgba(0,0,0,0.25);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            background: #000;
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background: #333;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Home</a>
        <?php if (!empty($_SESSION['username'])): ?>
            <a href="add_recipe.php">Add Recipe</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </div>

    <div class="form-box">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <input type="submit" value="Login">
        </form>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

</body>
</html>
