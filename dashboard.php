<?php 
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') { 
    header("Location: ../login.php"); 
    exit; 
}

include("../config_local.php"); 

echo "<h1>Admin Dashboard</h1>";
echo "<a href='../add_recipe.php'>Add Recipe</a> | 
     
      <a href='../logout.php'>Logout</a><hr>";

$sql = "SELECT r.id, r.title, u.username 
        FROM recipes r 
        JOIN users u ON r.user_id = u.id";
$result = $con->query($sql);
 
            
          </div>";
}

$con->close();
?>
