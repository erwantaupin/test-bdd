<?php 
session_start();
include("db.php");
?>
<?php
$msg = ""; 
if(isset($_POST['submitBtnLogin'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $role = trim($_POST['id_role']);
  if($username != "" && $password != "") {
    try {
      $query = "select * from `user` where `nom_user`=:username and `password_user`=:password and 'id_role'=:role";
      $stmt = $db->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->bindValue('id_role', $role, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row)) {
        /******************** Your code ***********************/
        $_SESSION['sess_user_id']   = $row['id_user'];
        $_SESSION['sess_user_name'] = $row['nom_user'];
        $_SESSION['sess_id_role'] = $row['id_role'];
        // $_SESSION['sess_name'] = $row['nom_user'];
       header("location: home.php");
      } else {
        $msg = "Invalid username and password!";
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }
}
?>