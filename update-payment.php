<?php
    require 'database.php';
    $id = null;
    if ( !empty($_POST['id'])) {
        $id = $_POST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $due_dateError = null;
         
        // keep track post values
        $due_date = $_POST['due_date'];

        // validate input
        $valid = true;
        if (empty($due_date)) {
            $due_dateError = 'Please enter initial Due Date';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE payments set scheduledate = ? WHERE id = ?";
            $pdo->prepare($sql)->execute([$due_date,$id]);
            Database::disconnect();
            
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM payments where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $due_date= $data['scheduledate'];
        Database::disconnect();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update Payment</h3>
                    </div>
             
                    <form class="form-horizontal" action="update-payment.php?id=<?php echo $id?>" method="post">
                      
                      <div class="control-group <?php echo !empty($due_dateError)?'error':'';?>">
                        <label class="control-label">Due Date</label>
                        <div class="controls">
                            <input name="due_date" type="text"  placeholder="due_date" value="<?php echo !empty($due_date)?$due_date:'';?>">
                            <?php if (!empty($due_dateError)): ?>
                                <span class="help-inline"><?php echo $due_dateError;?></span>
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