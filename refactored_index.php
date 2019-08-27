<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <style>
        body {
            background-color:#cccccc;
        }
        table, th, td {
            border: 1px solid black;
            background-color: #afc6d1;
        }
        .table { 
            display: table; 
        }
        .row { 
            display: table-row; 
        }
        .cell { 
            display: table-cell; 
        }
        .thisrow {
            width:100%; 
            background-color=green;
        }
        div.columntotals{
            border:solid; border-width:.5px; width: 50px; height: 50px; padding: 0em; background:white; float:left;
        }
        div#header-date { 
            border:solid; background-color:#cfe0c0; width: 50px; height: 50px; padding: 0em; float:left; border-width:thin; border-color:red; 
            }
        #notdraggable { 
            border:solid; border-width:.5px; width: 50px; height: 50px; padding: 0em; background:#fdffea; float:left; 
            }
        #columntotal { 
            border:solid; border-width:.5px; width: 50px; height: 50px; padding: 0em; background:white; float:left; 
            }
        #balance {
            padding: 10px;
        }
    </style>
</head>
 
<body> 
  <div style="background-color:#cccccc" id="content">
   <div>
    <div style="padding:20px">
    
                <h2>FUDGE</h2>
                <p style="font-size:24px"><u>F</u>inancial <u>U</u>tility to <u>D</u>etermine <u>G</u>eneral <u>E</u>xpenses</p>
                <br/>
                <br/>
                <p>
                    <a href="income.php" class="btn btn-success">+ Add Income</a>
                    <a href="expense.php" class="btn btn-danger">+ Add Expense</a>
                </p>
                
                        <table>
               <tr>
                <form>
                <?php


                    /**
                    * Create date collection between two dates
                    *
                    * <code>
                    * <?php
                    * # Example 1
                    * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
                    *
                    * # Example 2. you can use even time
                    * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
                    * </code>
                    *
                    * @param string since any date, time or datetime format
                    * @param string until any date, time or datetime format
                    * @param string step
                    * @param string date of output format
                    * @return array
                    */
                    function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

                        $dates = array();
                        $current = strtotime($first);
                        $last = strtotime($last);

                        while( $current <= $last ) {

                            $dates[] = date($output_format, $current);
                            $current = strtotime($step, $current);
                        }

                        return $dates;
                    }

                    if ( !empty($_GET['start'])) {
                        $datestart = $_REQUEST['start'];
                    }else{
                        $datestart="2017-11-22";
                    }
    
                    if ( !empty($_GET['end'])) {
                        $dateend = $_REQUEST['end'];
                    }else{
                        $dateend="2017-12-08";    
                    }
                    echo '<form><input type=text name=start value="'.$datestart.'" size="10"><input type=text name=end value="'.$dateend.'"><input type=submit action=get value="Change Date Range"></form>';
                    echo '<p style="font-size:22px">From <b>'.$datestart.'</b> to <b>'.$dateend.'</b><p>';
                    echo '<td width="120">  </td><td></td><td>';
                    foreach (date_range($datestart,$dateend, "+1 day", "m/d") as $dates) {
                        echo '<div id="header-date" style="border:solid;border-width:.5px;background-color:#bfeaff"><p style="font-size:16px;font-weight:bold" align="center">';
                        //echo '<div id="header-date" style="border:solid;border-width:.5px;background-color:#cfe0c0"><p style="font-size:16px;font-weight:bold" align="center">';
                        echo '<br>'.$dates;    
                        echo '</p></div>';
                    }
                    echo "</td></tr>";

                    $balance=0;
                    include 'database.php';
                    $pdo = Database::connect();
                    $sql0 = 'SELECT * FROM balance WHERE id = 1';
                    foreach ($pdo->query($sql0) as $row) {
                        $balance = $row['current'];
                    }

                    $sql = 'SELECT * FROM transactions ORDER BY id DESC';
                    $j = 0;
                    $rowsarray = array();
                    $cellsarray = array();
                    foreach ($pdo->query($sql) as $row) {
                        ++$j;                                
                                echo '<tr>';
                                echo '<td nowrap align="center">';
                                echo '<a href="update.php?id='.$row['id'].'">Edit</a> | ';
                                echo '<a href="delete.php?id='.$row['id'].'">Delete</a>';
                                echo '</td><td align="center" style="background-color:#bfeaff;" nowrap>';
                                echo '&nbsp;<a href=read.php?id='.$row['id'].' style="font-size:18px; color:black; font-weight:bold">'. $row['name'] . '</a>&nbsp;</td>';
                                echo '<td style="background-color:#ffffff" nowrap><div style="border:thin;border-width:.5px;background-color:green">';
                    
                                $sql2 = 'SELECT * FROM payments WHERE trans_id = '.$row['id'].' ORDER BY scheduledate ASC';
                                $i=0;
                                foreach (date_range($datestart,$dateend, "+1 day", "Y-m-d") as $dates) {
                                    ++$i;
                                    $match="false";
                                    foreach ($pdo->query($sql2) as $column) {                                   
                                        if($dates == $column['scheduledate']){
                                            if($column['amount'] < 0){ 
                                                echo '<style>#draggable'.$row['id'].'-'.$column['scheduledate'].' { width: 50px; height: 50px; padding: 0em; background:#ff7777; float:left; border:solid; border-width:.5px; border-color:#000000 }</style>';
                                            }else{
                                                echo '<style>#draggable'.$row['id'].'-'.$column['scheduledate'].' { width: 50px; height: 50px; padding: 0em; background:#82c46b; float:left; border:solid; border-width:.5px; border-color:#000000 }</style>';
                                            } 
                                            ?>
                                            <script>
                                            $(function() {
                                              $( "#draggable<?= $row['id']?>-<?= $column['scheduledate']?>" ).draggable({
                                                  containment:'parent',axis:'x',
                                                  grid: [51.5,51.5],
                                                  start: function(){
                                                    var offset = $(this).offset();
                                                    var xPos = offset.left;
                                                    $('#posX').text(xPos);
                                                  },
                                                  stop: function(){
                                                    var offsetstop = $(this).offset();
                                                    var stopPos = offsetstop.left;
                                                    $('#posXstop').text(stopPos);
                                                    var posX = document.getElementById("posX"); 
                                                    var startPos = posX.innerHTML;
                                                    var travel1 = parseInt(stopPos.valueOf(),10);
                                                    var travel2 = parseInt(startPos.valueOf(),10);
                                                    travel = travel1 - travel2;
                                                    $("#travel").text(travel);
                                                    dayChange = parseInt(travel/51);            // compute new date after drag
                                                    var theDate = new Date("<?= $column['scheduledate']?>");
                                                    theDate.setDate(theDate.getDate() + (dayChange + 1));
                                                    var y = theDate.getFullYear(),
                                                        m = theDate.getMonth() + 1,
                                                        d = theDate.getDate();
                                                    var pad = function(val) { var str = val.toString(); return (str.length < 2) ? "0" + str : str};
                                                    dateString = [y, pad(m), pad(d)].join("-");
                                                    reloadContent("<?= $column['id'] ?>",dateString);
                                                  }
                                              });
                                            });
                                            </script>

                                    <?php
                                            echo '<div id="draggable'.$row['id'].'-'.$column['scheduledate'].'" class="ui-widget-content"><input type=hidden id="'.$j.'-'.$i.'" value="'.$column['amount'].'"><p align=center style="font-size:16px;"><br><font color=white><b>'.$column['amount'].'</b></font></font></p></div>';
                                     
                                            $match="true";
                                            $cellarray[$i] = $column['amount'];
                                        }else{         
                                        }
                                    }
                                    if($match=="true"){
                                    }else{
                                            echo '<div id="notdraggable"><input type=hidden name="'.$j.'-'.$i.'" value="0"></div>'; 
                                            $cellarray[$i] = "0";
                                    }
                                }
                                echo '</div></td></tr>';
                                $rowsarray[$j] = $cellarray;
                    }
                    echo '<tr><td></td><td></td><td style="background-color:white">';
                    $t=0;
                    $columnTotal=0;
                    $runningTotal = $balance;
                    for($column = 1; $column <= $i; $column++) {
                        for($k = 1; $k <= 7; ++$k) {
                            $columnTotal = $columnTotal + $rowsarray[$k][$column];
                            //echo $rowsarray[1][1];
                        }
                        $runningTotal = $runningTotal + $columnTotal;
                        if($columnTotal==0){
                            echo '<div id="columntotal'.$j.'" class="columntotals"><p align=right>&nbsp;</p><p align=right><b>$'.$runningTotal.'</b></p></div>';
                        }else{
                            echo '<div id="columntotal'.$j.'" class="columntotals"><p align=right style="color:red">'.$columnTotal.'</p><p align=right><b>$'.$runningTotal.'</b></p></div>';
                        }
                        $columnTotal=0;
                    } 
                    
                    Database::disconnect(); 
                    echo ''; ?>
                    </form>
                </td>
            </tr>
        </table>

        </div>
    </div>



<script>
    function reloadContent(id,due_date){
        $.ajax({
            type: "POST",
            url: "update-payment.php",
            data: {"id" : id, "due_date" : due_date},
            error: function (xhr, status, error) {
                alert("Error: dang, AJAX didn't work" + xhr.responseText);
            },
            success: function (responseData) {

                $('#content').html(responseData);
                $('#content').show();
            }
        });
    }

</script>
<br>
<div id="balance">
<form action="update-balance.php" method="POST">
<p style="font-size:22px;">Enter Today's Balance: <input type="text" name="balance" id="balance" value="<?php echo $balance; ?>">
<input type="submit">
</p>
</form>
</div>
  <div id="posX"></div>
  <div id="posXstop"></div>
  <div id="travel"></div>
  <br><br><br><br><br><br>
  <br><br><br><br><br><br>
  <br><br><br><br><br><br>
  </div>
  
  </body>
</html>