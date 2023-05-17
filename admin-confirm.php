<?php

session_start();

$name = $_SESSION["name"];

echo "<h1>Admin - Confirm</h1>";

echo "Hey $name, your information has been successfully recorded<br>";

echo "<img style='margin-top:30px; margin-bottom:30px' src='https://images.unsplash.com/photo-1500259571355-332da5cb07aa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=688&q=80' height='500'></br>";

echo "<a style=
'text-decoration:none;
font-size:20px;
font-weight:500;
color:#766153'
 target='_blank' href='all-adventures.php'>Check out all the reviews!!</a>";
?>
