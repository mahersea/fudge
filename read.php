<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM transactions where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
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
                        <h3>Transactions</h3>
                    </div>
                     
                    <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Transaction Name</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['name'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Notes</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['notes'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Frequency</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['frequency'];?>
                            </label>
                        </div>
                      <div class="control-group">
                        <label class="control-label">Initial Date</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['due_date'];?>
                            </label>
                        </div>
                      <div class="control-group">
                        <label class="control-label">Amount</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['amount'];?>
                            </label>
                        </div>
                      <div class="control-group">
                        <label class="control-label">Repeats?</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['repeating'];?>
                            </label>
                        </div>
                      </div>
                        <div class="form-actions">
                          <a class="btn" href="index.php">Back</a>
                       </div>
                     
                      
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>