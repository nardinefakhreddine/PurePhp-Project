<?php
//manage/Insert/Add/edit/Update/Delete/Activate
session_start();
$title="Users";
//you can add/edit / delete users from here/

if(isset($_SESSION['Username'])){
include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage'; 
//start manage page

if($do=='manage')

{
$query='';
if(isset($_GET['page'])&& $_GET['page']=='pending'){
$query='AND RegStatus = 0';//only not activate
} 
//select all user except admin
$stmt=$con->prepare("SELECT * FROM users WHERE GroupID!=1 $query");
//execute the statment
$stmt->execute();
//assign to variable
$rows=$stmt->fetchAll();
if(!empty($rows)){

	?>
<h1 class="text-center"> Manage Members</h1>
<div class="container">
	<div class="table-responsive">
		<table class=" main-table manage-members text-center table table-bordered">
		<tr>
			<td>#ID</td>
			
			<td>UserName</td>
			<td>Email</td>
			<td>FullName</td>
			<td>Registered Date</td>
			<td>Control</td>
			</tr>
			<?php

			foreach($rows as $row){
				echo"<tr>";
				echo"<td>".$row['UserID']."</td>";
				//echo"<td>";
				//if(empty($row['avatar'])){
					//echo "<img style='width:50px; height:50px;' src='uploads/avatars/img.jpg' alt=''/>";
				//}else{
				// echo "<img style='width:50px; height:50px;' src='uploads/avatars/".$row['avatar']."' alt=''/>";
			//}
				//echo"</td>";
				echo"<td>".$row['Username']."</td>";
				echo"<td>".$row['Email']."</td>";
				echo"<td>".$row['FullName']."</td>";
				echo"<td>".$row['Date']."</td>";
				echo"<td>
<a href='users.php?do=edit&userid=".$row['UserID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
<a href='users.php?do=Delete&userid=".$row['UserID']."'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
if($row['RegStatus']==0){
echo"<a href='users.php?do=Activate&userid=".$row['UserID']."'class='btn btn-info activate'><i class='fa fa-close'></i>Activate</a>";


}

				echo"</td>";
                echo"</tr>";

			}//fin foreach
			?>
		</table>

</div>
<a href="users.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> new member</a>
</div>
<?php 
 }//fin empty
else{
	echo'<br>';
echo'<div class="container">';

echo'<div class="alert alert-info">No Records To Show</div>';
echo'<a href="users.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> new member</a>';
echo'</div>';
}
 }//fin manage




elseif($do=='Insert'){
if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Insert Member</h1>";
echo"<div class='container'>";

//upload variables
$avatarName=$_FILES['avatar']['name'];
$avatarSize=$_FILES['avatar']['size'];
$avatarTmp=$_FILES['avatar']['tmp_name'];
$avatarType=$_FILES['avatar']['type'];
//list of allowed File Typed To Upload
$avatarAllowedExtension=array("jpeg","png","gif","jpg");
//get avatar extension
$avatarextension=explode('.', $avatarName);

$avatarextension=end($avatarextension);
$avatarextension=strtolower($avatarextension);

$user=$_POST['username'];
$pass=$_POST['password'];
$email=$_POST['email'];
$full=$_POST['full'];
$hashpass=sha1($_POST['password']);
$check=checkitem('Username','users',$user);


//validate the form
$formError=array();
if($check==1){

$formError[]='<div class="alert alert-danger">user name <strong>not available</strong></div>';
}
if(strlen($user)<4){
$formError[] ='<div class="alert alert-danger">user name cant be <strong>less 4 characters</strong></div>';
}
if(strlen($user)>20){
$formError[] ='user name cant be more than<strong> 20 characters</strong>';

}
if(! empty($avatarName) &&! in_array($avatarextension, $avatarAllowedExtension)){
$formError[] ='This Extension Is Not<strong> Allowed</strong>';
}
//if(empty($avatarName)){
//$formError[] ='Avatar Is<strong> Required</strong>';
//}
if($avatarSize>4194304){
$formError[] ='Avatar Cant be Larger than<strong>4MB</strong>';
}

if(empty($user)){
$formError[] ='user name cant be<strong> empty</strong>';

}
if(empty($pass)){
$formError[] ='Password cant be<strong> empty</strong>';

}
if(empty($full)){
$formError[] ='Full name cant be<strong> empty</strong>';

}
if(empty($email)){
$formError[] ='user email cant be <strong>empty</strong>';
 
}
foreach($formError as $error){
$msg='<div class="alert alert-danger">'.$error.'</div>';
	redirectHome2($msg,'users.php');
}
if(empty($formError)){
$avatar=rand(0,10000000).'_'.$avatarName;
move_uploaded_file($avatarTmp, "uploads\avatars\\".$avatar);




//insert info into data base
$stmt=$con->prepare("INSERT INTO users (Username, Password, Email, FullName,RegStatus, Date,avatar)VALUES(:zuser,:zpass,:zemail,:zname,1,now(),:zavatar) " );//1 car by admin active by default

$stmt->execute(array(
'zuser'=>$user,
'zpass'=>$hashpass,
'zemail'=>$email,
'zname'=>$full,
'zavatar'=>$avatar
));
echo"<div class='container'>";
$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records inserts</div>';
 redirectHome2($ms,'users.php');
echo"</div>";
}//fin condition empty error


}//fin condition server post 

else{
echo"<div class='container'>";
		$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg);
echo"</div>";

}
	
}//fin condtion do=insert










elseif($do=='Add'){?>

<h1 class="text-center"> Add New Members</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
			
		<!-- username-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Username</label>
			<div class=" col-md-6" >
				<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="user name to login into shop" />
			</div>
		</div>
		<!-- password-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10 col-md-6" >
				
				<input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="password mut be hard and complexe"  required='required'  />
				<i class="show-pass fa fa-eye fa-2x"></i>
			</div>
		</div>
		<!-- email-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10 col-md-6" >
				<input type="email" name="email"class="form-control"  required="required" placeholder="Must  be Valid"/>
			</div>
		</div>
	<!-- fullname-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Fullname</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" class="form-control" name="full" required="required" placeholder="full name is appear in your profile page"/>
			</div>
		</div>
		<!-- Avatar-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">User Avatar</label>
		<div class="col-sm-10 col-md-6" >
				<input type="file" class="form-control" name="avatar"  />
			</div>
		</div>
		<!-- submit-->
		<div class="form-group form-group-lg">
			<div class=" col-sm-offset-2 col-sm-10" >
				<input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
			</div>
		</div>
		</form>
		</div>	





<?php }

//Start Edit page
elseif($do=='edit' )
{
	//pour secret
	//check if userid is number and get that 
$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		//select all data depend this id
	$stmt=$con->prepare("SELECT *
                               
                      FROM  
                            users
                      WHERE
                            UserID=?
                     
                      LIMIT 1");
//execute query
$stmt->execute(array($userid));
//fetch the data
$row=$stmt->fetch();//get data
//row count check if data found
$count=$stmt->rowCount();
//show the form if such id
if($count>0)
{
 ?>
		<h1 class="text-center"> Edit Members</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $userid ?>"/>
		<!-- username-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Username</label>
			<div class=" col-md-6" >
				<input type="text" name="username"value="<?php echo $row['Username']?>" class="form-control" autocomplete="off" required="required" />
			</div>
		</div>
		<!-- password-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10 col-md-6" >
				<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
				<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="optionnel"  />
			</div>
		</div>
		<!-- email-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10 col-md-6" >
				<input type="email" name="email" value="<?php echo $row['Email']?>"class="form-control"  required="required"/>
			</div>
		</div>
	<!-- fullname-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Fullname</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="full"value="<?php echo $row['FullName']?>"class="form-control"  required="required"/>
			</div>
		</div>
		<!-- submit-->
		<div class="form-group form-group-lg">
			<div class=" col-sm-offset-2 col-sm-10" >
				<input type="submit" value="Save" class="btn btn-primary btn-lg"/>
			</div>
		</div>
		</form>
		</div>	
<?php


}//fin if count
else//id n'existe pas
	{echo"<div class'container'>";

$msgg="<div class='alert alert-danger'>not available ID</div>";
redirectHome1($msgg,'back');
echo"</div>";
}//fin edit

}








//update page
elseif($do=='Update'){




if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Update Members</h1>";
echo"<div class='container'>";

$idd=$_POST['userid'];
$user=$_POST['username'];
$email=$_POST['email'];
$full=$_POST['full'];

$pass='';

//password trick
if(empty($_POST['newpassword'])){
$pass=$_POST['oldpassword'];
}else{
$pass=sha1($_POST['newpassword']);
}//check if user name existe
$check=checkitem('Username','users',$user);
//validate the form
$formError=array();
if($check==1){

$formError[] ='user name <strong>not available</strong>';

}
if(strlen($user)<4){
$formError[] ='user name cant be <strong>less 4 characters</strong>';
}
if(strlen($user)>20){
$formError[] ='user name cant be more than<strong> 20 characters</strong>';

}
if(empty($user)){
$formError[] ='user name cant be<strong> empty</strong>';

}
if(empty($full)){
$formError[] ='Full name cant be<strong> empty</strong>';

}
if(empty($email)){
$formError[] ='user email cant be <strong>empty</strong>';
 
}
foreach($formError as $error){
  $m='<div class="alert alert-danger">'.$error.'</div>';
	echo '<div class="alert alert-danger">'.$error.'</div>';
	 redirectHome1($m,'back');
}
//check error if exist
if(empty($formError)){
//update the data base 
$stmt=$con->prepare("UPDATE users SET Username=?, Email=?, FullName=?, Password=?
                      WHERE
                            UserID=?
                     
                      ");

//execute query
 $stmt->execute(array($user,$email,$full,$pass,$idd));
 echo"<div class='container'>";
$ms="<div class='alert alert-success'>".$stmt->rowCount() .'records updates</div>';

 redirectHome1($ms,'back');
 echo"</div>";
 }//end condition error





}//end post condition

else{//if server request method not posr
	 echo"<div class='container'>";
	$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg,'back');
	 echo"</div>";
}


echo "</div>";
}
//fin if ( get edit)
elseif($do=='Delete'){
	echo"<h1 class='text-center'> Delete Members</h1>
		<div class='container'>";

//delete members page
$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		//select all data depend this id
$count=checkitem('UserID','users',$userid);

if($count>0)
{
	$stmt=$con->prepare("DELETE FROM users WHERE UserID=:zuser");
	$stmt->bindParam(":zuser",$userid);
	$stmt->execute();
	echo"<div class='container'></div>";
	$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records Deteted</div>';

 redirectHome1($ms,'back');
	echo"</div>";
}
else{
	echo"<div class='container'>";
   $mss="<div class='alert alert-danger'>this id not exist</div>";
   redirectHome1($mss,'back');
   echo"</div>";

}

echo"</div>";

}//fin delete page
//activate page
elseif($do='Activate'){
echo"<h1 class='text-center'> Activate Members</h1>
		<div class='container'>";

//delete members page
$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		//select all data depend this id
$count=checkitem('UserID','users',$userid);

if($count>0)
{
	$stmt=$con->prepare("UPDATE  users set RegStatus = 1 where UserID=?");
	
	$stmt->execute(array($userid));
	echo"<div class='container'></div>";
	$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records Activated</div>';

 redirectHome1($ms,'back');
	echo"</div>";
}
else{
	echo"<div class='container'>";
   $mss="<div class='alert alert-danger'>this id not exist</div>";
   redirectHome1($mss,'back');
   echo"</div>";

}

echo"</div>";

}







include $tpl."footer.php";

//fin if session user name exist
}
else{


	header('Location:index.php');
	exit();
}
?>