<?php 
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "recipe_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM recipes ORDER BY id DESC";
$result = $conn->query($sql);
?>

<html>
<head>
    <title>Recipes</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('assets/foodbg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .navbar {
            text-align: center;
            padding: 15px;
            background: rgba(255,255,255,0.9);
            font-weight: bold;
        }
        .navbar a {
            margin: 0 30px;
            text-decoration: none;
            color: black;
            font-size: 18px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 250px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.2);
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .card h2 {
            margin-top: 10px;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="add_recipe.php">Add Recipe</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <?php 
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
                ?>
                <div class="card">
                    <a href="view_recipe.php?id=<?php echo $row['id']; ?>">
                        <?php 
                            $title = strtolower($row['title']);
                            $imagePath = "assets/default.jpg"; 

                            if ($title == "pizza") $imagePath = "assets/pizza.jpg";
                            else if ($title == "burger") $imagePath = "assets/burger.jpg";
                            else if ($title == "cake") $imagePath = "assets/cake.jpg";
                            else if ($title == "noodles") $imagePath = "assets/noodles.jpg";
                            else if ($title == "dal bati") $imagePath = "assets/dalbati.jpg";

                            
                            if (!empty($row['image']) && file_exists("assets/".$row['image'])) {
                                $imagePath = "assets/".$row['image'];
                            }

                            echo '<img src="'.$imagePath.'" alt="'.htmlspecialchars($row['title']).'">';
                        ?>
                        <h2><?php echo strtoupper(htmlspecialchars($row['title'])); ?></h2>
                    </a>
                </div>
                <?php 
            } 
        } else {
            echo "<p style='color:white; font-size:20px; text-align:center;'>No recipes found.</p>";
        }
        ?>
    </div>
</body>
</html>
