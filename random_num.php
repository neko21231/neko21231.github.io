<!doctype html>
<html lang="en">

<head>
<style>
    .line1{
         color:green;
         font-style:italic;
    }
    .line2{
        color:blue;
        font-style:italic;
    }
    .line3{
        color:red;
        font-style:bold;
    }
    .line4{
        color:black;
        font-style:bold,italic;

    }
   
</style>
</head>
    <body> 
<?php 
$ran1="rand(100,200)";
$ran2="rand(100,200)";
echo "$ran1"."<span class=\"line1\">";
echo "$ran2"."<span class=\"line2\">";
echo "$ran1+ $ran2"."<span class=\"line3\">";
echo "$ran1*$ran2"."<span class=\"line4\">";

 ?>
    </body>

</html>