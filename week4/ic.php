<!DOCTYPE html>
<html lang="en">

<head>
    <title>ic</title>
       <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <div class="row justify-content-center p-5">
        <div class="col-2">
            

        

            <?php
            $ic = ("010430-16-5463");
            echo "$ic <br>";
            $DOB = substr($ic, 0, 6);
            ?>
            
            
            <?php
            $gender = substr($ic, -1);
            if ($gender % 2 == 0) {
                echo "Mrs. <br>";
            } else {
                echo "Mr. <br>";
            }
            ?>

            <?php
            $icDOB = date_create_from_format("ymd", $DOB);
            echo date_format($icDOB, "M d, Y");
            echo "<br>";
            ?>

            

            

            <?php
            $day = substr($ic, 4, 2);
            $month = substr($ic, 2, 2);
            function sign($day, $month)
            {

                if (($month == 3 || $month == 4) && ($day > 22 || $day < 21)) {
                    echo "<img src='img/aries.jpg'/>". "<br>";
                    $sign = "Aries";

                } elseif (($month == 4 || $month == 5) && ($day > 22 || $day < 22)) {
                    echo "<img src='img/taurus.jpg'/>". "<br>";
                    $sign = "Taurus";

                } elseif (($month == 5 || $month == 6) && ($day > 23 || $day < 22)) {
                    $sign = "Gemini";
                    echo "<img src='img/gemini.jpg'/>". "<br>";

                } elseif (($month == 6 || $month == 7) && ($day > 23 || $day < 23)) {
                    $sign = "Cancer";
                    echo "<img src='img/cancer.jpg'/>". "<br>";

                } elseif (($month == 7 || $month == 8) && ($day > 24 || $day < 22)) {
                    $sign = "Leo";
                    echo "<img src='img/leo.jpg'/>". "<br>";

                } elseif (($month == 8 || $month == 9) && ($day > 23 || $day < 24)) {
                    $sign = "Virgo";
                    echo "<img src='img/virgo.jpg'/>". "<br>";

                } elseif (($month == 9 || $month == 10) && ($day > 25 || $day < 24)) {
                    $sign = "Libra";
                    echo "<img src='img/libra.jpg'/>". "<br>";

                } elseif (($month == 10 || $month == 11) && ($day > 25 || $day < 23)) {
                    $sign = "Scorpio";
                    echo "<img src='img/scorpio.jpg'/>". "<br>";

                } elseif (($month == 11 || $month == 12) && ($day > 24 || $day < 23)) {
                    $sign = "Sagittarius";
                    echo "<img src='img/sagi.jpg'/>". "<br>";

                } elseif (($month == 12 || $month == 1) && ($day > 24 || $day < 21)) {
                    $sign = "Capricorn";
                    echo "<img src='img/capri.jpg'/>". "<br>";

                } elseif (($month == 1 || $month == 2) && ($day > 22 || $day < 20)) {
                    $sign = "Aquarius";
                    echo "<img src='img/aquarius.jpg'/>". "<br>";

                } elseif (($month == 2 || $month == 3) && ($day > 21 || $day < 21)) {
                    $sign = "Pisces";
                    echo "<img src='img/pisces.jpg'/>". "<br>";
                }
                return $sign;
            }
            echo sign($day, $month);
            ?>

</body>

</html>