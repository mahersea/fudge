<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
<?php
    require 'database.php';
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $notesError = null;
        $frequencyError = null;
        $due_dateError = null;
        $amountError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $notes = $_POST['notes'];
        $frequency = $_POST['frequency'];
        $due_date = $_POST['due_date'];
        $amount = $_POST['amount'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($notes)) {
            $notesError = 'Please enter Notes';
            $valid = false;
        }
         
        if (empty($frequency)) {
            $frequencyError = 'Please enter Frequency';
            $valid = false;
        }
       
         
        if (empty($due_date)) {
            $due_dateError = 'Please enter due date';
            $valid = false;
        }
         
         
        if (empty($amount)) {
            $amountError = 'Please enter Amount';
            $valid = false;
        }
        
         
    
        
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO transactions (name,notes,frequency,due_date,amount) values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$notes,$frequency,$due_date,$amount));

            $transid = $pdo->lastInsertId();
            //$transid = 3;
            $newdate = new DateTime($due_date);
            $scheduledate = $newdate->format('Y-m-d');
            
            $sql2 = "INSERT INTO payments (trans_id,amount,scheduledate) values(?, ?, ?)";
            $p = $pdo->prepare($sql2);

            if($frequency=="Weekly"){
                for($i==0; $i < 52; $i++) {
                    //echo $transid.",".$amount.",".$scheduledate."<br>";
                    $p->execute(array($transid,$amount,$scheduledate));
                    $newdate->add(new DateInterval('P7D'));
                    $scheduledate = $newdate->format('Y-m-d');
                }
            }elseif($frequency=="Monthly") {
                for ($i==0; $i < 12; $i++) {
                    //echo $frequency.",".$transid.",".$amount.",".$scheduledate."<br>";
                    $p->execute(array($transid,$amount,$scheduledate));
                    $newdate->add(new DateInterval('P1M'));
                    $scheduledate = $newdate->format('Y-m-d');
                }
            }elseif($frequency=="Annually") {
                for ($i==0; $i < 2; $i++) {
                    //echo $transid.",".$amount.",".$scheduledate."<br>";
                    $p->execute(array($transid,$amount,$scheduledate));
                    $newdate->add(new DateInterval('P1Y'));
                    $scheduledate = $newdate->format('Y-m-d');
                }
            }elseif($frequency=="Once") {
                    //echo $transid.",".$amount.",".$scheduledate."<br>";
                    $p->execute(array($transid,$amount,$scheduledate));
            }else{

            }
            Database::disconnect();
            header("Location: index.php");
        }
    }
    
?>


    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Schedule Income</h3>
                    </div>
             
                    <form class="form-horizontal" action="income.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($notesError)?'error':'';?>">
                        <label class="control-label">notes</label>
                        <div class="controls">
                            <input name="notes" type="text" placeholder="notes" value="<?php echo !empty($notes)?$notes:'';?>">
                            <?php if (!empty($notesError)): ?>
                                <span class="help-inline"><?php echo $notesError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($frequencyError)?'error':'';?>">
                        <label class="control-label">frequency</label>
                        <div class="controls">
                            <select name="frequency" placeholder="Frequency">
                            <?php
                              if($frequency=="Once"){
                                  echo '  <option value="Once" selected>Once</option>';
                              }else{
                                  echo '  <option value="Once">Once</option>';
                              }
                              if($frequency=="Weekly"){
                                  echo '  <option value="Weekly" selected>Weekly</option>';
                              }else{
                                  echo '  <option value="Weekly">Weekly</option>';
                              }
                              if($frequency=="Monthly"){
                                  echo '  <option value="Monthly" selected>Monthly</option>';
                              }else{
                                  echo '  <option value="Monthly">Monthly</option>';
                              }
                              if($frequency=="Annually"){
                                  echo '  <option value="Annually" selected>Annually</option>';
                              }else{
                                  echo '  <option value="Annually">Annually</option>';
                              }
                            ?>
                            </select>
                            <?php if (!empty($frequencyError)): ?>
                                <span class="help-inline"><?php echo $frequencyError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($due_dateError)?'error':'';?>">
                        <label class="control-label">Due Date</label>
                        <div class="controls">
                            <input name="due_date" type="text"  placeholder="Due Date" value="<?php echo !empty($due_date)?$due_date:'';?>">
                            <?php if (!empty($due_dateError)): ?>
                                <span class="help-inline"><?php echo $due_dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($amountError)?'error':'';?>">
                        <label class="control-label">Amount</label>
                        <div class="controls">
                            <input name="amount" type="text"  placeholder="Amount" value="<?php echo !empty($amount)?$amount:'';?>">
                            <?php if (!empty($amountError)): ?>
                                <span class="help-inline"><?php echo $amountError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>