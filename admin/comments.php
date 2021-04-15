<?php
//from user only
//comments page
session_start();
$title='Comments';
if(isset($_SESSION['Username'])){
include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';


if($do=='manage'){

$stmt=$con->prepare("SELECT comments.*,
                            items.Name,
	                         users.Username 
 
                      FROM 
                           comments
                      INNER JOIN
                           items
                       ON   
                          items.item_ID=comments.item_id
                       INNER JOIN
                           users
                       ON   
                          users.UserID=comments.user_id");              

$stmt->execute();

$cmts=$stmt->fetchAll();
if(!empty($cmts)){

	?>
<h1 class="text-center"> Manage Comments</h1>
<div class="container">
	<div class="table-responsive">
		<table class=" items main-table text-center table table-bordered">
		<tr>
			<td>#ID</td>
			<td>Comment</td>
			<td>Item</td>
			<td>User</td>
			<td>Adding Date</td>
			<td>Control</td>
			</tr>
			<?php

			foreach($cmts as $cmt){
				echo"<tr>";
				echo"<td>".$cmt['c_id']."</td>";
				echo"<td>".$cmt['comment']."</td>";
				echo"<td>".$cmt['Name']."</td>";
				echo"<td>".$cmt['Username']."</td>";
				echo"<td>".$cmt['comment_date']."</td>";
				echo"<td>
<a href='comments.php?do=edit&cmtid=".$cmt['c_id']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>


<a href='comments.php?do=delete&cmtid=".$cmt['c_id']."'class='confirm btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
if($cmt['status']==0){
echo"<a href='comments.php?do=approved&cmtid=".$cmt['c_id']."'class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";

}


				echo"</td>";
                echo"</tr>";

			}


			
			?>


		</table>

	</div>

<?php 
	}
	else{echo'<br>';
echo'<div class="container">';
echo'<div class="alert alert-info">No Records To Show</div>';

echo'</div>';
}
}//fin manage
if($do=='edit'){

$cmtid=isset($_GET['cmtid'])&&is_numeric($_GET['cmtid'])?intval($_GET['cmtid']):0;

		//select all data depend this id
$stmt=$con->prepare("SELECT *
                               
                      FROM  
                           comments
                      WHERE
                            c_id=?
                     
                     ");
//execute query
$stmt->execute(array($cmtid));
//fetch the data
$row=$stmt->fetch();
//row count check if data found
$count=$stmt->rowCount();
//show the form if such id
if($count>0)
{
 ?>
		<h1 class="text-center"> Edit Comments</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $cmtid ?>"/>
		<!-- comment-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Comment</label>
			<div class=" col-md-7" >
				<textarea name="comment"class="form-control" required="required" ><?php echo $row['comment']; ?></textarea>
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
else
	{
		echo"<div class'container'>";

$msgg="<div class='alert alert-danger'>not available ID</div>";
redirectHome1($msgg,'back');
echo"</div>";
}

}//fin edit


elseif($do=='update'){

if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Update Comment</h1>";
echo"<div class='container'>";
$idd=$_POST['userid'];
$cmt=$_POST['comment'];
$check=checkitem('c_id','comments',$idd);
//validate the form
if($check==1){
$stmt=$con->prepare("UPDATE comments SET comment=? 
                      WHERE   c_id=? ");

//execute query
 $stmt->execute(array($cmt,$idd));
 echo"<div class='container'>";
$ms="<div class='alert alert-success'>".$stmt->rowCount() .'records updates</div>';

 redirectHome2($ms,'comments.php');
 echo"</div>";
 }//end condition error
else{

 echo"<div class='container'>";
	$msg='<div class="alert alert-danger">No Id Exist</div>';
	 redirectHome1($msg,'back');
	 echo"</div>";

}




}//end post condition

else{//if server request method not posr
	 echo"<div class='container'>";
	$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg,'back');
	 echo"</div>";
}


echo "</div>";


}//fin update

if($do=='delete'){

$cmtid=isset($_GET['cmtid'])&&is_numeric($_GET['cmtid'])?intval($_GET['cmtid']):0;

$check=checkitem('c_id','comments',$cmtid);
if($check==1){

$stmt=$con->prepare("DELETE FROM comments WHERE c_id=?");
	
	$stmt->execute(array($cmtid));
	echo"<div class='container'></div>";
	$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records Deteted</div>';

 redirectHome1($ms,'back');
	echo"</div>";


} else{
	 echo"<div class='container'>";
		$msg='<div class="alert alert-danger">No Id Exist</div>';
		 redirectHome1($msg,'back');
		 echo"</div>";
	}


}//fin delete

if($do=='approved'){
$cmtid=isset($_GET['cmtid'])&&is_numeric($_GET['cmtid'])?intval($_GET['cmtid']):0;

$check=checkitem('c_id','comments',$cmtid);
if($check==1){
$stmt=$con->prepare("UPDATE comments SET status=1
                      WHERE   c_id=? ");

//execute query
 $stmt->execute(array($cmtid));
 echo"<div class='container'>";
$ms="<div class='alert alert-success'>".$stmt->rowCount() .'comment approved </div>';

 redirectHome1($ms,'back');
 echo"</div>";
 }//end condition error



}//fin approved



include $tpl.'footer.php';
}


//fin isset
else{
header('Location:index.php');
exit();

}

?>