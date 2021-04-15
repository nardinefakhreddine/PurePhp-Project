<?php 
session_start();
$title="Profile";
 include 'init.php';

if(isset($_SESSION['user'])){
$getuser=$con->prepare("SELECT * FROM users WHERE Username=?");
$getuser->execute(array($sessionUser));
$info=$getuser->fetch();
$userid=$info['UserID'];
?>
<h2 class="text-center">My Profile</h2>
<div class="information block">
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel panel-heading">My Informations</div>
         <div class="panel panel-body">
           <ul class="list-unstyled">
           	<li><i class="fa fa-unlock-alt fa-faw"></i>
           		<span>Login Name</span> : <?php echo $info['Username'];?>
           	</li>

            <li><i class="fa fa-envelope-o fa-faw"></i>
           	    <span>Email</span> : <?php echo $info['Email'];?>
           	</li>

           	<li><i class="fa fa-user fa-faw"></i>
           	    <span>FullName</span> : <?php echo $info['FullName'];?>
           	</li>
            <li><i class="fa fa-calendar fa-faw"></i>
           	    <span>Register Date</span> :<?php echo $info['Date'];?>
           	</li>
            <li><i class="fa fa-tags fa-faw"></i>
            	<span>Fav Category</span>:
            </li> 
           		  	</ul>
           	<a href="#" class="btn  btn-default"> Edit Information</a>
           		   </div>
           	</div>
       </div>
</div>




  <div id="my-ads" class="my-ads block">
      <div class="container">
           <div class="panel panel-primary">
            	<div class="panel panel-heading">My Items</div>
           		   <div class="panel panel-body">
           		  	<?php
   $myItems=getAllfrom("*","items","where Member_ID= $userid","","item_ID");
     
           		  	//$test=getItems1('Member_ID',$info['UserID']);
           		  	if(!empty($myItems)){
           		  		echo'<div class="row">';
						foreach($myItems as $item){

						echo'<div class="col-sm-6 col-md-3">';
							echo'<div class="thumbnail item-box">';
							if($item['approve']==0){echo'<span class="app">Waiting approved</span>';}
							echo'<span class="price-tag">$'.$item['price'].'</span>';
						   echo"<img  class='img-responsive'style='width:200px; height:200px;' src='uploads/items/".$item['image']."' alt=''/>";
						        echo'<div class="caption">';
						        echo'<h3><a href="items.php?itemid='.$item['item_ID'].'">'.$item['Name'].'</a></h3>';
						        echo'<p>'.$item['description'].'</p>';
						         echo'<div class="date">'.$item['date_ad'].'</div>';


						        echo'</div>';//caption
							echo'</div>';//thumbnail
						echo'</div>';//col

						} //fin foreach
						echo'</div>';
					}//fin condition empty query
					else{
						echo'<i>Sorry there no Ads To Show Create</i> <a href="newad.php"><b>New Ad</b></a>';
                     
					}
   


?>

           		   </div>
           	</div>
       </div>
</div>


<div class="my-comments block">
      <div class="container">
           <div class="panel panel-primary">
            	<div class="panel panel-heading"> Lasted Comments</div>
           		   <div class="panel panel-body">
           		 <?php

 $mycomments=getAllfrom("comment","comments","where user_id=$userid","","c_id");

                     $stmt=$con->prepare("SELECT comment
                                           FROM comments

                                         where user_id=?     


                                                   ");

if(!empty($mycomments)){
foreach($mycomments as $mycomment){
echo'<p>'.$mycomment['comment'].'</p>';

}


}else{

	echo" <i>there is No Comments to show</i>";
}

	?>
           		   </div>
           	</div>
       </div>
</div>










<?php

}
else{
header('Location:index.php');
exit();


}


include $tpl."footer.php";
 ?>