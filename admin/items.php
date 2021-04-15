<?php

//itesm page
session_start();
$title='Items';
if(isset($_SESSION['Username'])){
include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';
if($do=='manage'){//debut manage

$stmt=$con->prepare("SELECT items.*,
                            categories.Name AS category_name,
	                         users.Username 
 
                      FROM 
                           items
                      INNER JOIN
                           categories
                       ON   
                          categories.ID=items.Cat_ID
                       INNER JOIN
                           users
                       ON   
                          users.UserID=items.Member_ID");              

$stmt->execute();

$items=$stmt->fetchAll();
if(!empty($items)){

	?>
<h1 class="text-center"> Manage Items</h1>
<div class="container">
	<div class="table-responsive">
		<table class=" items main-table text-center table table-bordered">
		<tr>
			<td>#ID</td>
			<td>Name</td>
			
			<td>Description</td>
			<td>Price</td>
			<td>Adding Date</td>
			<td>Category</td>
			<td>UserName</td>
			<td>Control</td>
			</tr>
			<?php

			foreach($items as $item){
				echo"<tr>";
				echo"<td>".$item['item_ID']."</td>";
				echo"<td>".$item['Name']."</td>";
				echo"<td>".$item['description']."</td>";
				echo"<td>".$item['price']."</td>";
				echo"<td>".$item['date_ad']."</td>";
				echo"<td>".$item['category_name']."</td>";
				echo"<td>".$item['Username']."</td>";
				echo"<td>
<a href='items.php?do=edit&itemid=".$item['item_ID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
<a href='items.php?do=delete&itemid=".$item['item_ID']."'class='confirm btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
if($item['approve']==0){
echo"<a href='items.php?do=approve&itemid=".$item['item_ID']."'class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";

}


				echo"</td>";
                echo"</tr>";

			}


			
			?>


		</table>

	</div>
<a href="items.php?do=add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> new item</a>
</div>
<?php 
	}else{echo'<br>';
echo'<div class="container">';
echo'<div class="alert alert-info">No Records To Show</div>';
echo'<a href="items.php?do=add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> new item</a>';
echo'</div>';

}
}//fin manage
elseif($do=='add'){?>
<h1 class="text-center"> Add New Item</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=insert" method="POST">
			
		<!-- name item-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Name</label>
			<div class=" col-md-6" >
				<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="name of the item" />
			</div>
		</div>
		<!-- description-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="description" class="form-control"required="required"  placeholder="descripe the item"  />
				
			</div>
		</div>
		<!-- price-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">price</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" required="required"name="price"class="form-control"  placeholder="price of item"/>
			</div>
		</div>
		<!-- country-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Country </label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="country" required="required"class="form-control"  placeholder="country of made"/>
			</div>
		</div>
		<!-- status-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Status </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="status">
				<option value="0">...</option>
				<option value="1">New</option>
				<option value="2">Like New</option>
				<option value="3">Used</option>
				<option value="4">Old</option>
			</select>
			</div>
		</div>
		<!--start user field-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">User </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="user">
				<option value="0">...</option>
				<?php
				$stmt=$con->prepare("SELECT * FROM users");
				$stmt->execute();
				$users=$stmt->fetchAll();
				foreach($users as $user)
				echo"<option value='".$user['UserID']."' >".$user['Username']."</option>";
				?>
			</select>
			</div>
		    </div>

		<!--start Category field-->
			<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Category </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="catg">
				<option value="0">...</option>
				<?php
				$allCats=getAllfrom("*","categories","where parent=0","","ID");
				foreach($allCats as $cat){
				echo"<option value='".$cat['ID']."' >".$cat['name']."</option>";
                 $childCats=getAllfrom("*","categories","where parent={$cat['ID']}","","ID");
                  foreach($childCats as $child){
                  	echo"<option value='".$child['ID']."' >---".$child['name']."</option>";
                  }

                }
				?>
	
			</select>
			</div>
		</div>
	  	<!-- Tags-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Tags</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="tags" class="form-control"  placeholder="Separate your tag with Comma(,)"/>
			</div>
		</div>
	
			<!-- submit-->
		<div class="form-group form-group-lg">
			<div class=" col-sm-offset-2 col-sm-10" >
				<input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
			</div>
		</div>
		</form>
		</div>	


<?php
}
//debut insert
elseif($do=='insert'){
if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Insert Item</h1>";
echo"<div class='container'>";
$name=$_POST['name'];
$desc=$_POST['description'];
$price=$_POST['price'];
$country=$_POST['country'];
$status=$_POST['status'];
$tags=$_POST['tags'];
$cat=$_POST['catg'];
$user=$_POST['user'];
if($status == 0 ){ 
echo"<div class='container'>";
$ms="<div class='alert alert-danger'>You Must choose the status</div>";
redirectHome1($ms,'back');
echo"</div>";
}
else{
$stmt=$con->prepare("INSERT INTO items (Name, description, price,country_made,status, 
Cat_ID,Member_ID,date_ad,tags)VALUES(:zname,:zdescription,:zprice,:zcountry,:zstatus,:zcat,:zuser,now(),:ztags)");

$stmt->execute(array(
'zname'=>$name,
'zdescription'=>$desc,
'zprice'=>$price,
'zcountry'=>$country,
'zstatus'=>$status,
'ztags'=>$tags,
'zcat'=>$cat,
'zuser'=>$user
));

echo"<div class='container'>";
$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records inserts</div>';
 redirectHome2($ms,'items.php');
echo"</div>";
}//fin else


}//fin condition server post 


else{
echo"<div class='container'>";
		$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg);
echo"</div>";

}

}//fin insert

elseif($do=='edit'){

	//check if userid is number and get that 
$itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
		//select all data depend this id
	$stmt=$con->prepare("SELECT *
                               
                      FROM  
                            items
                      WHERE
                            item_ID=?
                     ");
//execute query
$stmt->execute(array($itemid));
//fetch the data
$item=$stmt->fetch();
//row count check if data found
$count=$stmt->rowCount();
//show the form if such id
if($count>0)
{
 ?>

	<h1 class="text-center"> Edit Item</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=update" method="POST">
			
		<!-- name item-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Name</label>
			<div class=" col-md-6" >
				<input type="hidden" name="id" value="<?php echo $itemid ?>"/>
				<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="name of the item" value="<?php echo $item['Name'] ?>" />
			</div>
		</div>
		<!-- description-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="description" class="form-control"required="required"  placeholder="descripe the item" value="<?php echo $item['description'] ?>" />
				
			</div>
		</div>
		<!-- price-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">price</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" required="required"name="price"class="form-control"  placeholder="price of item"value="<?php echo $item['price'] ?>"/>
			</div>
		</div>
		<!-- country-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Country </label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="country" required="required"class="form-control"  placeholder="country of made" value="<?php echo $item['country_made'] ?>"/>
			</div>
		</div>
		<!-- status-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Status </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="status">
				
			<option value="1"<?php if($item['status']==1){echo 'selected';} ?>>New</option>
				<option value="2"<?php if($item['status']==2){echo 'selected';} ?>>Like New</option>
				<option value="3"<?php if($item['status']==3){echo 'selected';} ?>>Used</option>
				<option value="4"<?php if($item['status']==4){echo 'selected';} ?>>Old</option>
			</select>
			</div>
		</div>
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">User </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="user">
				
				<?php
				$stmt=$con->prepare("SELECT * FROM users");
				$stmt->execute();
				$users=$stmt->fetchAll();
				foreach($users as $user){
				echo"<option value='".$user['UserID']."'";
			   if($user['UserID']==$item['Member_ID']){echo 'selected';}    
			   echo">".$user['Username']."</option>";

				} 
				?>
		

			</select>
			</div>
		</div>
			<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Category </label>
			<div class="col-sm-10 col-md-6" >
			<select class="form-control" name="cat">
				
				<?php
				$stmt=$con->prepare("SELECT * FROM categories");
				$stmt->execute();
				$cats=$stmt->fetchAll();
				foreach($cats as $cat){
				echo"<option value='".$cat['ID']."'";
			      if($cat['ID']==$item['Cat_ID']){echo 'selected';}
			echo">".$cat['name']."</option>";
		}

				?>
	
			</select>
			</div>
		</div>
		<!-- Tags-->
        <div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Tags</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="tags" class="form-control"  value="<?php echo $item['tags'] ?>" placeholder="Separate your tag with Comma(,)"/>
			</div>
		</div>
	
			<!-- submit-->
		<div class="form-group form-group-lg">
			<div class=" col-sm-offset-2 col-sm-10" >
				<input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
			</div>
		</div>
		</form>


<?php
$stmt=$con->prepare("SELECT comments.*, users.Username

                       FROM comments

                       
                          INNER JOIN 
                               users
                                On users.UserID=comments.user_id

                           where item_id=?     


                       ");
//execute the statment
$stmt->execute(array($itemid));
//assign to variable
$rows=$stmt->fetchAll();
if(!empty($rows)){

	?>
<h1 class="text-center"> Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
<div class="container">
	<div class="table-responsive">
		<table class=" main-table text-center table table-bordered">
		<tr>
			
			<td>Comment</td>
			<td>User Name</td>
			<td>Added Date</td>
			<td>Control</td>
			</tr>
			<?php

			foreach($rows as $row){
				echo"<tr>";
				
				echo"<td>".$row['comment']."</td>";
				echo"<td>".$row['Username']."</td>";
				echo"<td>".$row['comment_date']."</td>";
				echo"<td>
<a href='comments.php?do=edit&comid=".$row['c_id']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
<a href='comments.php?do=Delete&comid=".$row['c_id']."'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
if($row['status']==0){
echo"<a href='comments.php?do=Approve&comid=".$row['c_id']."'class='btn btn-info activate'><i class='fa fa-close'></i>Approve</a>";
}

				echo"</td>";
                echo"</tr>";

			}//fin foreach
			?>
		</table>
	</div>
		</div>	
<?php


}//fin empty



}//if count <0
else
	{echo"<div class'container'>";

$msgg="<div class='alert alert-danger'>not available ID</div>";
redirectHome1($msgg,'back');
echo"</div>";
}









}//fin edit
elseif($do=='update'){
if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Update Item</h1>";
echo"<div class='container'>";

$idd=$_POST['id'];
$name=$_POST['name'];
$desc=$_POST['description'];
$price=$_POST['price'];
$country=$_POST['country'];
$status=$_POST['status'];
$cat=$_POST['cat'];
$user=$_POST['user'];
$tags=$_POST['tags'];

//update the data base 
$stmt=$con->prepare("UPDATE items SET Name=?, description=?, price=?,country_made=?,status=?,Cat_ID=?,Member_ID=?,tags=?
                      WHERE
                            item_ID=?
                     
                      ");

//execute query
 $stmt->execute(array($name,$desc,$price,$country,$status,$cat,$user,$tags,$idd));
 echo"<div class='container'>";
$ms="<div class='alert alert-success'>".$stmt->rowCount() .'records updates</div>';

 redirectHome2($ms,'items.php');
 echo"</div>";

}//end post condition

else{//if server request method not posr
	 echo"<div class='container'>";
	$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg,'back');
	 echo"</div>";
}


echo "</div>";




}//fin update

elseif($do=='delete'){
echo"<h1 class='text-center'>Delete Items</h1>
		<div class='container'>";

//delete members page
$itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
		//select all data depend this id
$count=checkitem('item_ID','items',$itemid);

if($count>0)
{
	$stmt=$con->prepare("DELETE FROM items WHERE item_ID=:zid");
	$stmt->bindParam(":zid",$itemid);
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

elseif($do=='approve'){

  echo"<h1 class='text-center'> Approve item</h1>
		<div class='container'>";

//delete members page
$itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
		//select all d-ata depend this id
$count=checkitem('item_ID','items',$itemid);

if($count>0)
{
	$stmt=$con->prepare("UPDATE  items set approve = 1 where item_ID=?");
	
	$stmt->execute(array($itemid));
	echo"<div class='container'></div>";
	$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records Approved</div>';

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



}//fin approve




include $tpl.'footer.php';
}
else{
header('Location:index.php');
exit();

}


?>