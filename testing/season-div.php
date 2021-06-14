<?php 
$num = 3; //calculate season num

for ($x = 1; $x <= $num; $x++){
    $season_num = $x;
    echo '
    <div style="border: 1px blue solid;">
        <h1 style= "text-align: center;">Season '.$season_num.' </h1>
    </div>
    <div style="border: 1px rebeccapurple solid;">
        <h1 style= "text-align: center;">Season '.$season_num.' </h1>
    </div>
    <div style="margin-bottom: 2%"></div>';
}

?>