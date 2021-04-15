<?php 
session_start();
$title='dashboard';

if(isset($_SESSION['Username'])){
include 'init.php';
//start dashborad page
?>
<div class="container home-stats text-center">
<h1> Dashboard</h1>
 <div class="row">
<div class="col-md-3">
<div class="stat st-members">
	<i class="fa fa-users"></i>
	<div class="info">
	Totals Members
	<span>
	<a href="users.php"><?php  echo countItems("UserID","users") ?></a>   </span>
    </div><!--fin div info-->

</div>
</div><!--fin div col-->
<div class="col-md-3">
<div class="stat st-pending">
	<i class="fa fa-user-plus"></i>
	<div class="info">
	pending Members<span>
		<a href="users.php?do=manage&page=pending"><?php echo countitem1('RegStatus','users',0)?></a></span>
	</div></div>
</div>
<div class="col-md-3">
<div class="stat st-items">
<i class="fa fa-tag"></i>
	<div class="info">
	totalitems<span><a href="items.php"><?php echo countItems("item_ID","items")?></a></span>
</div></div>
</div>
<div class="col-md-3">
<div class="stat st-comments">
	<i class="fa fa-comments"></i>
	<div class="info">total comments<span><a href="comments.php"><?php echo countItems("c_id","comments")?></a></span>
	</div></div>
</div>
</div><!--fin div row-->
</div><!--fin din container-->

<div class="container latest">
    <div class="row">
	    <div class="col-sm-6">
           <div class="panel panel-default">

	         <?php  $latestuser=5;?>
             <div class="panel-heading">
              	<i class="fa fa-users"></i>latest  <?php echo $latestuser ;?> Registerd users
              	<span class="toggle-info pull-right">
              		<i class="fa fa-plus fa-lg"></i>
              	</span>
             
             </div><!--heading-->

<div class="panel-body">
<ul class="list-unstyled latest-users">
<?php $row=getLatest('users','UserID',$latestuser);
if(!empty($row)){
foreach ($row as $res){
echo '<li>';
echo $res['Username'];
echo '<a href="users.php?do=edit&userid='.$res['UserID'].'">';
echo'<span class="btn btn-success pull-right">';
echo'<i class="fa fa-edit"></i>Edit';
if($res['RegStatus']==0){
echo"<a href='users.php?do=Activate&userid=".$res['UserID']."'class='btn btn-info pull-right activate'><i class='fa fa-close'></i>Activate</a>";
}
echo'</span>';
echo '</a>';
echo'</li>';
}
}
else{ echo'No Record To Show';}
 ?>

</ul>
</div><!--fin body-->	

</div><!--fin default-->
</div><!--fin col-->




<div class="col-sm-6">
<div class="panel panel-default">
	<?php  $latestitem=5;?>
<div class="panel-heading"><i class="fa fa-tag"></i>latest <?php echo $latestitem ;?> Registerd items
	<span class="toggle-info pull-right">
              		<i class="fa fa-plus fa-lg"></i>
              	</span>
 
</div>
<div class="panel-body">
<ul class="list-unstyled latest-users">
<?php $row=getLatest('items','item_ID',$latestitem);
if(!empty($row)){
foreach ($row as $res){

echo '<li>';
echo $res['Name'];
echo '<a href="items.php?do=edit&itemid='.$res['item_ID'].'">';
echo'<span class="btn btn-success pull-right">';
echo'<i class="fa fa-edit"></i>Edit';
if($res['approve']==0){
echo"<a href='items.php?do=approve&itemid=".$res['item_ID']."'class='btn btn-info pull-right activate'><i class='fa fa-close'></i>Activate</a>";
}
echo'</span>';
echo '</a>';
echo'</li>';

}
}
else{ echo ' No Record To Show';}
?>
 
</ul></div>	<!--fin body-->


</div><!--fin default-->	
</div><!--fin col-->


</div><!--fin row-->
<!--start latest comment-->
 <div class="row">

	    <div class="col-sm-6">
           <div class="panel panel-default">

             <div class="panel-heading">
              	<i class="fa fa-comments-o"></i>latest Comments
              	<span class="toggle-info pull-right">
              		<i class="fa fa-plus fa-lg"></i>
              	</span>
      
             </div><!--heading-->

<div class="panel-body">
<?php 

	$stmt=$con->prepare("SELECT comments.*, users.Username

	                       FROM comments

	                       
	                          INNER JOIN 
	                               users
	                                On users.UserID=comments.user_id    
                            limit 5

	                       ");
	$stmt->execute();
	//assign to variable
	$cmts=$stmt->fetchAll();
	if(!empty($cmts)){
	foreach($cmts as $cmt){
echo'<div class="comment-box">';
echo '<span class="member-n">'. $cmt['Username'] . '</span>';
echo '<p class="member-c">'. $cmt['comment'] . '</p>';
echo'</div>';


	}
}else{ echo ' No Record To Show';}



	 ?>
</div><!--fin body-->	
</div><!--fin default-->
</div><!--fin col-->
<!--End latest comment-->



<div class="col-sm-6">
<div class="panel panel-default">

<div class="panel-heading"><i class="fa fa-tag"></i>latest <?php echo $latestitem ;?> Comments items
	<span class="toggle-info pull-right">
              		<i class="fa fa-plus fa-lg"></i>
              	</span>
 
</div>
<div class="panel-body">

<?php 

	$stmt=$con->prepare("SELECT comments.*, items.Name

	                       FROM comments

	                       
	                          INNER JOIN 
	                               items
	                                On items.item_ID=comments.item_id    

                            limit 5
	                       ");
	$stmt->execute();
	//assign to variable
	$cmts=$stmt->fetchAll();
	if(!empty($cmts)){
	foreach($cmts as $cmt){
echo'<div class="comment-box">';
echo '<span class="member-n">'. $cmt['Name'] . '</span>';
echo '<p class="member-c">'. $cmt['comment'] . '</p>';
echo'</div>';


	}

}else{ echo ' No Record To Show';}


	 ?>



</div>	<!--fin body-->


</div><!--fin default-->	
</div><!--fin col-->


</div><!--fin row-->






</div><!--fin latest-->




<?php
include $tpl."footer.php";
}

else{//if session username not exist


	header('Location:index.php');
	exit();
}
