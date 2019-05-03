<?php
    $conn = mysqli_connect("localhost", "root", "", "count");

    if(isset($_POST['reset'])){
        mysqli_query($conn, "TRUNCATE countdown;");
        header("Location: ".$_SERVER['PHP_SELF']);
        die();
    }

    if(isset($_POST['submit'])){
        $finish = time() + $_POST['length'];
        mysqli_query($conn, "INSERT INTO countdown VALUES($finish);");
    }

    $select = mysqli_query($conn, "SELECT * FROM countdown;");
    if(!mysqli_num_rows($select)){
        echo "<form method='POST'><input type='number' name='length' placeholder='Time in secs' required><button type='submit' name='submit'>start</button></form>";
    }else{
        echo "<form method='POST'><button type='submit' name='reset'>reset</button></form>";
    }

    foreach($select as $row){
        $finish = $row['finish'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2 id='result'></h2>
    <script>
        var finishTime = <?php echo $finish; ?>;
        var result = document.getElementById("result");

        function countdown(){
            var currTime = Math.floor(Date.now() / 1000);
            var ramainTime = finishTime - currTime;
            var ramainHours = Math.floor(ramainTime / 3600);
            var ramainMins = Math.floor(ramainTime / 60);
            var ramainSecs = ramainTime % 60;

            if(ramainMins >= 60) ramainMins = 0;
            if(ramainHours < 10) ramainHours = "0" + ramainHours;
            if(ramainMins < 10) ramainMins = "0" + ramainMins;
            if(ramainSecs < 10) ramainSecs = "0" + ramainSecs;

            if(currTime >= finishTime){
                result.innerHTML = "Ukończono.";
                clearInterval(interval);
            }else{
                result.innerHTML = "Koniec odliczania za:<br>" + ramainHours + " : " + ramainMins + " : " + ramainSecs;
            }
        }

        countdown();
        interval = window.setInterval(countdown, 1000);
    </script>
</body>
</html>