<!doctype html>
<html lang="en">

<head>
<style>
    .line1{
         color:green;
         font-weight:italic;
    }
    .line2{
        color:blue;
        font-weight:italic;
    }
    .line3{
        color:red;
        font-weight:bold;
    }
    .line4{
        color:black;
        font-weight:bold;
        font-style:italic;

    }
   
</style>
</head>
    <body> 
<?php 
$ran1=rand(100,200);
$ran2=rand(100,200);

echo"<span class=\"line1\">"; 
echo $ran1 ;
echo"</span> <br>";



echo"<span class=\"line2\">";
echo $ran2;
echo"</span> <br>";



echo"<span class=\"line3\">";
echo ($ran1+$ran2);
echo"</span> <br>";


echo"<span class=\"line4\">";
echo ($ran1*$ran2);
echo"</span> <br>";
 ?>
    </body>

</html>