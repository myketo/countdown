<?php
    $conn = mysqli_connect("localhost", "root", "", "count");

    if(isset($_POST['reset'])){
        mysqli_query($conn, "TRUNCATE countup;");
        header("Location: ".$_SERVER['PHP_SELF']);
    }

    $select = mysqli_query($conn, "SELECT * FROM countup;");
    if(!mysqli_num_rows($select)){
        $time = time();
        mysqli_query($conn, "INSERT INTO countup VALUES($time);");
    }else{
        echo "<form method='POST'><button type='submit' name='reset'>reset</button></form>";
    }

    foreach($select as $row){
        $time = $row['timestamp'];
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
        var stampTime = <?php echo $time; ?>;
        var result = document.getElementById("result");

        function countdown(){
            var currTime = Math.floor(Date.now() / 1000);
            var passedTime = currTime - stampTime;
            var passedHours = Math.floor(passedTime / 3600);
            var passedMins = Math.floor(passedTime / 60);
            var passedSecs = passedTime % 60;

            if(passedMins >= 60) passedMins = 0;
            if(passedHours<10) passedHours = "0" + passedHours;
            if(passedMins<10) passedMins = "0" + passedMins;
            if(passedSecs<10) passedSecs = "0" + passedSecs;
            
            result.innerHTML = "Czas jaki upłynął od timestampu:<br>" + passedHours + " : " + passedMins + " : " + passedSecs;
        }

        countdown();
        window.setInterval(countdown, 1000);
    </script>
</body>
</html>