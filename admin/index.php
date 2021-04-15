<?php 
session_start();
$title='Login';

if(isset($_SESSION['Username'])){
header('Location:dashboard.php');

}
$navbar='';
include 'init.php';

//check if user coming from http post request
if($_SERVER['REQUEST_METHOD']=="POST"){
$username=$_POST['user'];
$password=$_POST['password'];
$hashedpass=sha1($password);
//check if user exist in data base
$stmt=$con->prepare("SELECT
                           UserID, Username,Password
                      FROM  
                            users
                      WHERE
                            Username=? 
                      AND  
                            Password=? 
                      AND   
                            GroupID=1
                      LIMIT 1");

$stmt->execute(array($username,$hashedpass));
$row=$stmt->fetch();//get row a from array
$count=$stmt->rowCount();//get number row 
//if count>0 contain record
if($count>0){
$_SESSION['Username']=$username;//Register session name
$_SESSION['ID']=$row['UserID'];
header('Location:dashboard.php');
exit();
}
}
?>

 <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
<h4 class="text-center"> <i>Admin Login</i></h4>
 	<input type="text" class="form-control " name="user" placeholder="Username" autocomplete="off">
  <!--.form-control have a width of 100%. Vertical form (this is default)-->
 	<input type="password" class="form-control " name="password" placeholder="Password" autocomplete="new-password"><!-- use to don't remembre password used-->
 	<input class="btn btn-primary btn-block" type="submit" value="Login"/>

</form>

<?php include $tpl."footer.php";?><!--using for javascript and jqueryb only-->