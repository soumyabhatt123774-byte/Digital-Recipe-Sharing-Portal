<?php
session_start();
include("config_local.php"); 

if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps       = mysqli_real_escape_string($conn, $_POST['steps']);
    $user_id     = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    
    $image = "default.jpg";

    
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "assets/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $image;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image = "default.jpg";
        }
    }

    $sql = "INSERT INTO recipes (title, ingredients, steps, image, user_id) 
            VALUES ('$title','$ingredients','$steps','$image'," . ($user_id ? "'$user_id'" : "NULL") . ")";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Recipe added successfully!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit a Recipe</title>
    <style>
        body {margin:0;font-family:Arial,sans-serif;background:url('assets/foodbg.jpg') no-repeat center center fixed;background-size:cover;}
        .navbar {background-color: rgba(255,255,255,0.9);text-align:center;padding:15px;}
        .navbar a {text-decoration:none;margin:0 25px;color:#000;font-size:18px;font-weight:bold;}
        .form-wrapper {background: rgba(255,255,255,0.96);max-width:600px;margin:60px auto;padding:30px;border-radius:10px;box-shadow:0 8px 16px rgba(0,0,0,0.25);}
        h2 {text-align:center;margin-bottom:20px;}
        input[type="text"], textarea {width:100%;padding:12px;margin:12px 0;border:1px solid #ccc;border-radius:6px;font-size:15px;}
        input[type="file"] {margin:12px 0;}
        input[type="submit"] {background-color:#000;color:#fff;padding:12px;width:100%;border:none;border-radius:6px;font-weight:bold;cursor:pointer;margin-top:10px;}
        input[type="submit"]:hover {background-color:#333;}
        .error {color:red;text-align:center;margin-top:10px;}
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

<div class="form-wrapper">
    <h2>Share Your Recipe</h2>
    <?php if (!empty($error)) echo '<div class="error">'.$error.'</div>'; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Enter recipe title" required>
        <textarea name="ingredients" rows="5" placeholder="List all ingredients..." required></textarea>
        <textarea name="steps" rows="6" placeholder="Write preparation steps..." required></textarea>
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Submit Recipe">
    </form>
</div>

</body>
</html>
