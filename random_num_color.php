<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Random Number color</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>
 .big{
        font-size:50px;
        font-weight:bold;
        color: white;
        
    }
    .small{
        font-size:25px;
        color: white;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="row text-center mt-5">
            <div class="col p-3 bg-primary">
                <?php
                $a =  rand(0, 100);
                $b =  rand(0, 100);

                if ($a > $b) {
                    echo "<span class=\"big\">";
                    echo $a;
                    echo "</span>";
                } else {
                    echo "<span class=\"small\">";
                    echo $a;
                    echo "</span>";
                }
                ?>
            </div>
            <div class="col p-3 bg-secondary">
                <?php

                if ($a < $b) {
                    echo "<span class=\"big\">";
                    echo $b;
                    echo "</span>";
                } else {
                    echo "<span class=\"small\">";
                    echo $b;
                    echo "</span>";
                }
                ?>
            </div>
        </div>


</body>
</html>