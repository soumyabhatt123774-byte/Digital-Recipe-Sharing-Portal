<?php
session_start();
include("config_local.php"); 

$recipe_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$result = mysqli_query($conn, "SELECT * FROM recipes WHERE id=$recipe_id");

if (!$result || mysqli_num_rows($result) < 1) {
    echo "No recipe found for this ID.";
    exit;
}

$recipe = mysqli_fetch_assoc($result);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    <style>
        body {margin:0;font-family:Arial,sans-serif;background:url('assets/foodbg.jpg') no-repeat center center fixed;background-size:cover;}
        .navbar {background-color: rgba(255,255,255,0.92);padding:15px;text-align:center;}
        .navbar a {text-decoration:none;color:#000;margin:0 20px;font-weight:600;}
        .content-box {width:90%;max-width:850px;margin:50px auto;background: rgba(255,255,255,0.96);padding:30px;border-radius:10px;box-shadow:0 8px 15px rgba(0,0,0,0.25);}
        img {width:100%;border-radius:10px;margin-bottom:25px;}
        h2 {text-align:center;margin-bottom:20px;}
        h3 {margin-top:25px;}
        p {white-space: pre-line;line-height:1.6;}
        .delete-btn {background:#d9534f;color:white;border:none;padding:10px 15px;border-radius:5px;cursor:pointer;margin-top:20px;}
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <?php if (!empty($_SESSION['username'])): ?>
        <a href="add_recipe.php">Post Recipe</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Sign In</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>

<div class="content-box">
    <h2><?php echo strtoupper(htmlspecialchars($recipe['title'])); ?></h2>

    <?php if (!empty($recipe['image']) && file_exists("assets/".$recipe['image'])): ?>
        <img src="assets/<?php echo $recipe['image']; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
    <?php endif; ?>

    <h3>Ingredients</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

    <h3>Steps to Prepare</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>
</div>

</body>
</html>
