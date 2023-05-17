<?php
session_start();

// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location:admin-confirm.php");
//     exit;
// }

$formComplete=true;
$errorMsg=[];

if(isset($_POST["submit"]) && $_POST["submit"] === "submit"){
    $name=htmlspecialchars($_POST["name"] ?? "", ENT_QUOTES);
    $where=htmlspecialchars($_POST["where"] ??"", ENT_QUOTES);
    $date=htmlspecialchars($_POST["date"] ??"", ENT_QUOTES);
    $duration=htmlspecialchars($_POST["duration"] ??"", ENT_QUOTES);
    $feedback=nl2br(htmlspecialchars($_POST["feedback"] ??"", ENT_QUOTES));

    // Validate inputs
    if(trim($name)===""){
        $formComplete=false;
        array_push($errorMsg,"Please input your name");
    }

    if(!in_array($where, ["halifax", "breton", "yarmouth","peggy"])){
        $formComplete=false;
        array_push($errorMsg, "Please pick the trip destination");
    }

    if($date===""){
        $formComplete=false;
        array_push($errorMsg, "Please pick the starting date");
    }

    if(!in_array($duration, [1,3,7])){
        $formComplete=false;
        array_push($errorMsg, "Please pick the trip duration");
    }

    if(trim($feedback)===""){
        $formComplete=false;
        array_push($errorMsg, "Please input your general feedback");
    }

    // Check if the form is completed

if(!$formComplete){
    echo "<h3>Errors:</h3><ul>";
    foreach($errorMsg as $errorMsg){
        echo "<li>$errorMsg</li>";
    }
    echo "</ul>";
} else {
    $_SESSION["loggedin"] = true;
    $_SESSION["name"] = $name;
    header("location:admin-confirm.php");
    // Import data to database
    
    try{
        error_log("Connecting to DB\n", 0);
        $servername = 'localhost';
        $username = 'root';
        $password ="";
        $dbname = "skill4hire";
        
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
        $sql = "INSERT INTO `trips` (`name`,`destination`,`date`,`duration`, `feedback`) VALUES (?, ?, ?, ?, ?)";
        $stml = $pdo->prepare($sql);
        
        $pdo->beginTransaction();
        $stml->execute([$name, $where, $date, $duration, $feedback]);
        $pdo->commit();
        
        echo "<p style='color:green'>Your information is successfully recorded</p>";
    } catch (Exception $e) {
        echo "Error: ". $e->getMessage() . "<br>";
        error_log("Cannot connect to DB\n", 0);
        echo "<p style='color:red'>Technical errors. Please contact system admin</p>";
    }
}

// $_SESSION["name"] = $name;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add your adventure</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="title">Admin - Add Adventure</h1>
        <hr></hr>
        <div class="container-main">

            <h2 class="sub-title">Input details about the trip you have guided</h2>
            <form action="admin-confirm.php" method='post' class="form-container">
                <div class="form-component">
                    <label for="name" class="form-label">Your name:</label>
                    <input type="text" name="name" id="name" placeholder="first & last name">
                </div>
                <div class="form-component">
                    <label for="where" class="form-label">Destination:</label>
                    <select name="where" id="where">
                        <option value="">-</option>
                        <option value="halifax">Downtown Halifax</option>
                        <option value="breton">Cape Breton county</option>
                        <option value="yarmouth">Yarmouth Fishery Village</option>
                        <option value="peggy">Peggy Cove</option>
                    </select><br>
            </div>
            <div class="form-component">
                <label for="date" class="form-label">Starting date:</label>
                <input type="date" name="date" id="date">
            </div>
            <div class="form-component">
                <label for="duration" class="form-label">Duration:</label>
                <input type="radio" name="duration" value="1">Single day
                <input type="radio" name="duration" value="3">3 days
                <input type="radio" name="duration" value="7">7 days
            </div>
            <div class="form-component">
                <label for="feedback" class="form-label">Feedback:</label><br>
                <textarea name="feedback" id="feedback"></textarea>
            </div>
            <div class="buttons">
                <input type="submit" name="submit" value="submit" id="submit">
                <input type="submit" formaction="all-adventures.php" formtarget="_blank" name="" value="Check out reviews!" id="review">
            </div>
        </form>
        
    </div>
</div>
</body>
</html>