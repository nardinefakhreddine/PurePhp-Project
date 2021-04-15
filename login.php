<?php
session_start();
$title="Login";
if(isset($_SESSION['user'])){
header('Location:index.php');
}
include 'init.php';
//check if user coming from http request
if($_SERVER['REQUEST_METHOD']=='POST'){

if(isset($_POST['login'])){
$user=$_POST['username'];
$pass=$_POST['password'];
$hashpass=sha1($pass);
//check if user exist in database(table users)
$stmt=$con->prepare("SELECT  *
                     FROM users
                     WHERE Username =? 
                     AND Password =? limit 1");
$stmt->execute(array($user,$hashpass));
$row=$stmt->fetch();
$count=$stmt->rowCount();
if($count>0){
$_SESSION['user']=$user;
$_SESSION['userid']=$row['UserID'];
$_SESSION['avatar']=$row['avatar'];
//register user id
header('Location:index.php');//redirect to home page
exit();
    }else{
    	$errorLogin="Invalid User Or Password";
    }


  }//fin condition login
  

  else{//if sign up
  	$formErrors=array();
  	$user=$_POST['username'];
  	$pass=$_POST['password'];
  	$fullname=$_POST['fullname'];
  	$hashpass=sha1($pass);
  	$email=$_POST['email'];
    
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





  	if(isset($user)){
  		$filteruser=filter_var($user,FILTER_SANITIZE_STRING);
      if(strlen($filteruser)<4){
      	$formErrors[]="Username Must Be Larger than 4 characters";
      }
  	}


    if(isset($pass)&&isset($_POST['password-again'])){
    	if(empty($pass)){
        $formErrors[]="Sorry Password Cant Be Empty";
    	}
    	$pass1=sha1($pass);	
    	$pass2=sha1($_POST['password-again']);


    	if($pass1!==$pass2){
         	$formErrors[]="Sorry Password Is Not Match";
    	}
  	}

    if(isset($fullname)){
  		$filtername=filter_var($fullname,FILTER_SANITIZE_STRING);
      if(strlen($filtername)<4){
      	$formErrors[]="Fullname Must Be Larger than 4 characters";
      }
  	}


  if(isset($email)){
  		$filteremail=filter_var($email,FILTER_SANITIZE_EMAIL);
     if(filter_var($filteremail,FILTER_VALIDATE_EMAIL)!=true){
     	$formErrors[]="this Email is not Valid";

     }
  	}
if(! empty($avatarName) &&! in_array($avatarextension, $avatarAllowedExtension)){
$formErrors[] ='This Extension Is Not<strong> Allowed</strong>';
}
//if(empty($avatarName)){
//$formError[] ='Avatar Is<strong> Required</strong>';
//}
if($avatarSize>4194304){
$formErrors[] ='Avatar Cant be Larger than<strong>4MB</strong>';
}

  	//check user name if exist in database
$check=checkItem('Username','users',$user);
if($check==1){
$formErrors[]=" sorry this user is exist";
}

if(empty($formErrors)){
$avatar='';
if(!empty($_FILES['avatar'])){
$avatar=rand(0,10000000).'_'.$avatarName;
move_uploaded_file($avatarTmp, "uploads\users\\".$avatar);
}
//insert info into data base
$stmt=$con->prepare("INSERT INTO users (Username, Password, Email, FullName,RegStatus, Date,avatar)VALUES(:zuser,:zpass,:zemail,:zname,0,now(),:zavatar) " );

$stmt->execute(array(
'zuser'=>$user,
'zpass'=>$hashpass,
'zemail'=>$email,
'zname'=>$fullname,
'zavatar'=>$avatar
));
//echo message succes
$succes="Congrats You are now registerd User ";
}


}



}


?>

<div class="container login-page">
<h1 class="text-center">
	<span class="selected" data-class="login">Login</span> | 
	<span data-class="signup">SignUp</span></h1>

<!--start login form-->	
<form  class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<div class="input-container">
		<input 
		class="form-control"
		 type="text" 
		 name="username"
		  autocomplete="off"
		   placeholder=" type your user name"
		   required/>
	</div>
	<div class="input-container">
	<input 
	class="form-control"
	 type="password"
	 name="password"
	 autocomplete="new-password"
	 placeholder="Type a complex password" required/>
	 	</div>
	<input  class="btn btn-primary btn-block" name="login" type="submit" value="login"/>
</form>
<!--End login form-->
<!--start Signup form-->
<form method="post" class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
	<div class="input-container">
	<input 
	pattern=".{4,}"
	title="Username Must Be 4 characters"
	class="form-control"
	 type="text" 
	 name="username"
	  autocomplete="off"
	  placeholder=" type your user name" required/></div>
	  <div class="input-container">
	<input 
	 minlength="4" 
	 class="form-control"
	 type="password"
	 name="password"
	 autocomplete="new-password"
	 placeholder="Type a complex password" required/></div>
	 <div class="input-container">
	 	<input 
	class="form-control"
	 type="password"
	 name="password-again"
	 autocomplete="new-password"
	 placeholder="Type a password again" required/></div>
	 	<div class="input-container">
	<input 
	pattern=".{4,}"
	title="Fullname Must Be 4 characters"
	class="form-control"
	type="text" 
	name="fullname"
	autocomplete="off"
	placeholder=" type your full name" required/></div>
    <div class="input-container">
	<input 
	class="form-control"
	 type="email"
	 name="email"
	 placeholder="Type your valid email" required/></div>
	 <input 
	class="form-control"
	 type="file"
	 name="avatar"
	 placeholder="Optionnel" 
	 />
	
	<input  class="btn btn-success btn-block" name="signup" type="submit" value="SignUp"/>
	 
</form>
<!--End Signup form-->
<div class="the-errors text-center">
	<?php
		   if(!empty($formErrors)){
           	foreach($formErrors as $t){
                 echo $t.'<br>'; 

           	}

           }
      if(isset($succes)){
       echo'<div class="msg success">'.$succes.'</div>';

      } 
   
      if(isset($errorLogin)){
      	 echo'<div class="msg success">'.$errorLogin.'</div>';

      }
	?>


</div>
</div>
</div>  

<div class="quote" style=" background-color: #f4f4f4; height: 300px;">



</div>
<?php
include $tpl.'footer.php';

  ?>