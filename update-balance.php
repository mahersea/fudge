<?php
    require 'database.php';
    $id = 1;
    if ( !empty($_POST['balance'])) {
        $balance = $_POST['balance'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE balance set current = ? WHERE id = ?";
        $pdo->prepare($sql)->execute([$balance,1]);
        Database::disconnect();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
 
<body>
<?php
echo $balance;
?>
  </body>
</html>