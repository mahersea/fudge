<?php
    require 'database.php';

    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
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
            $notesError = 'Please enter notes';
            $valid = false;
        }
        if (empty($frequency)) {
            $frequencyError = 'Please enter Frequency';
            $valid = false;
        }
        if (empty($due_date)) {
            $due_dateError = 'Please enter initial Due Date';
            $valid = false;
        }
        if (empty($amount)) {
            $amountError = 'Please enter Amount';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE transactions set name = ?, notes = ?, frequency = ?, due_date = ?, amount = ? WHERE id = ?";
            $pdo->prepare($sql)->execute([$name,$notes,$frequency,$due_date,$amount,$id]);
            Database::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM transactions where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $notes = $data['notes'];
        $frequency = $data['frequency'];
        $due_date= $data['due_date'];
        $amount= $data['amount'];
        Database::disconnect();
    }
?>
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
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update Transaction</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
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
                        <label class="control-label">Notes</label>
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
                            <input name="due_date" type="text"  placeholder="due_date" value="<?php echo !empty($due_date)?$due_date:'';?>">
                            <?php if (!empty($due_dateError)): ?>
                                <span class="help-inline"><?php echo $due_dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($amountError)?'error':'';?>">
                        <label class="control-label">Amount</label>
                        <div class="controls">
                            <input name="amount" type="text"  placeholder="amount" value="<?php echo !empty($amount)?$amount:'';?>">
                            <?php if (!empty($amountError)): ?>
                                <span class="help-inline"><?php echo $amountError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>