<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out reviews!</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="reset.css">
</head>
<body>
    <h1 class="title">Let's hear from our customers!!</h1>
    <div class="review-list">
            <?php
            try{
                error_log("Connecting to DB\n", 0);
                $servername = 'localhost';
                $username = 'root';
                $password='';
                $dbname='skill4hire';
                
                $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                $query="SELECT `destination`, `date`, `duration`, `feedback` FROM `trips` ORDER BY `addedDate` DESC LIMIT 6";

                $stml=$pdo->prepare($query);
                $stml->execute();
                $stml->bindColumn('destination', $where);
                $stml->bindColumn('date', $date);
                $stml->bindColumn('duration', $duration);
                $stml->bindColumn('feedback', $feedback);

                while($row = $stml->fetch(PDO::FETCH_BOUND)){
                    $destination='';
                    $image="";

                    if($where==="breton"){
                        $destination = "Cape Breton";
                        $image="https://images.unsplash.com/photo-1548304988-2ba732bfa449?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80";
                    } if ($where === "halifax") {
                        $destination = "Downtown Halifax";
                        $image="https://images.unsplash.com/photo-1570902128092-950ebe50a3da?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1614&q=80";
                    } if($where==="yarmouth") {
                        $destination = "Yarmouth";
                        $image="https://images.unsplash.com/photo-1653997271447-9ae61234f448?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1684&q=80";
                    } if($where==="peggy"){
                        $destination="Peggy Cove";
                        $image="https://plus.unsplash.com/premium_photo-1664302879100-651f879db6c7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1724&q=80";
                    }

                    echo "<div class='review'><h2  class='where-name'>$destination</h2>";
                    echo "<img class='image' src='$image' height='250'><br>";
                    echo "<span class='form-label'>Duration:</span> $duration days <br>";
                    echo "<span class='form-label'>Date:</span> $date <br>";
                    echo "<span class='form-label'>Feedbacks:</span> $feedback <br><br><br></div>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage() . "<br>";
                error_log("Cannot connect to DB\n", 0);
                die();
            }
            
            ?>
    </div>


</body>
</html>