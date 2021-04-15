<!DOCTYPE html>
<html>

<meta charset="UTF-8"/>
<title><?php echo getTitle()?></title>
 
<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css"/>

<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css"/>

<link rel="stylesheet" href="<?php echo $css; ?>owl.carousel.min.css"/>

<link rel="stylesheet" href="<?php echo $css; ?>owl.theme.default.min.css"/>

<link rel="stylesheet" href="<?php echo $css; ?>front-end.css"/>
</head>
<body>
<div class="upper-bar">
	<div class="container"> 
    <?php 
    if(isset($_SESSION['user'])){ 
      $avatar=$_SESSION['avatar'];
      if(!empty($avatar)){
      echo"<img  class='img-thumbnail img-circle myimg' src='uploads/users/".$avatar."' alt=''/>";
   }else{
  echo'<img class=" img-thumbnail img-circle myimg"  src="img.jpg" alt=""/>';
}
?>
   <div class="btn-group my-info">

        <span class="btn dropdown-toggle" data-toggle="dropdown">
        <?php   echo $_SESSION['user'] ?>
        <span class="caret"></span>
       </span>
        <ul class="dropdown-menu">
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="newad.php">New Item</a></li>
         
          <li><a href="logout.php">Logout</a></li>
        </ul>
       </div>

      <?php
     


    



   }else { ?>

     
 <a href="login.php">
     	<span class="pull-right">
     		Login/SignUp
     	</span></a>
 
   <?php   }

?>
    
  
	</div>
</div>

	
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>

   
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
      	<?php
      	foreach(getAllfrom('*','categories','where parent=0','','ID','ASC') as $cat){
          echo'<li>
          <a href="categories.php?pageid='.$cat['ID'].'">
          '. $cat['name'].'
          </a>
          </li>';
              
            }

             ?>

      </ul>
    </div>
  </div>
</nav>

</body>
