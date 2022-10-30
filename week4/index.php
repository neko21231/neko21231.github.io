<!DOCTYPE html>
<html>
    <body>
        <?php
       
        date_default_timezone_set("Asia/Kuala_Lumpur");

        $t=date("12");
        echo $t. "<br>";

        if($t >= "06" AND $t< "12") {
            echo "Good Morning";
        }
        
            else if($t >= "12" AND $t <"18" ){

                echo "Good Evening " ;

                if($t == "12"){
                
                    echo  "Its Lunch Time ";
                
                
                    }
                    else{

                        echo "Good Night";
                    }
                
            }
            \
        
        
           

        
         ?>
    </body>
</html>