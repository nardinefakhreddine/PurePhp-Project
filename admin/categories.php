<?php 
//Categories page
session_start();
$title="Categories";
if(isset($_SESSION['Username'])){

include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';

if($do=='manage'){
	$sort='ASC';
	$srt=array('ASC','DESC');
	if(isset($_GET['sort'])&&in_array($_GET['sort'],$srt)){
		$sort=$_GET['sort'];
	}
$stmt=$con->prepare("SELECT * from categories where parent=0 ORDER BY ordering $sort ");
$stmt->execute();
$row=$stmt->fetchAll();
if(!empty($row)){
?>
<h1 class="text-center"> Manage Categories</h1>
<div class="container categories">
  <div class="panel panel-default">	<!--title du panel-->
  <div class="panel-heading"><i class="fa fa-edit"></i> Manage Categories
<div class="ordering pull-right">
<i class="fa fa-sort"></i>Ordering:[
<a class="<?php if($sort =='ASC'){ echo 'active';} ?>"href="?sort=ASC" >ASC</a> |
<a  class="<?php if($sort =='DESC'){ echo 'active';} ?>"href="?sort=DESC">DESC</a>]
</div>
  </div>
<div class="panel-body">

	<?php 
	foreach($row as $res){
		echo"<div class='catg'>";
		echo"<div class='hidden-buttons'>";
		echo"<a href='categories.php?do=edit&catgid=" .$res['ID'] ."'class=' btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
		echo"<a href='categories.php?do=delete&catgid=" .$res['ID'] ."' class=' confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
		 echo"</div>";
		echo "<h3>".$res['name']."</h3>";
		echo "<p>";
		if($res['description']==''){echo 'this category has no description';}
		 else{echo $res['description'];}
			echo"</p>";
		 if($res['visibility']==1){
		echo '<span class="vis"><i class="fa fa-eye"></i>Hidden</span>';}
	
 if($res['allow_coment']==1){
		echo '<span class="cmt"><i class="fa fa-close"></i>comment disable</span>';}
        if($res['allow_ads']==1){
		echo '<span class="ads"><i class="fa fa-close"></i>Ads disable</span>';}
		//Get Child Categories
$childCats=getAllfrom("*","categories","where parent={$res['ID']}" ,"","ID","ASC");
	if(!empty($childCats)){
		echo"<h4 class='child-head'><b> Child Category</b></h4>";
		echo"<ul class='list-unstyled child-cats'>";
  foreach($childCats as $c){
  	echo "<li class='child-c'>
  	<a href='categories.php?do=edit&catgid=" .$c['ID'] ."'>".$c['name']."</a>
  	<a href='categories.php?do=delete&catgid=" .$c['ID'] ."' class='color-del confirm pull-right' style='color:red;'><i>Delete</i></a>
  	</li>";
       }
     echo"</ul>";
}
		echo"<hr>";

		echo"</div>"; 

}//fin foreach

	 ?>
 </div>

  </div>
<a  class="add-catg btn btn-primary"href="categories.php?do=add"><i class="fa fa-plus"></i>Add New Category </a>

</div><?php
}
else{	echo'<br>';
echo'<div class="container">';
echo'<div class="alert alert-info">No Records To Show</div>';
echo'<a  class="add-catg btn btn-primary"href="categories.php?do=add"><i class="fa fa-plus"></i>Add New Category </a>';
echo'</div>';}

}
// Add Category
elseif($do=='add'){ ?>

<h1 class="text-center"> Add New Category</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=insert" method="POST">	
		<!-- name categorie-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Name</label>
			<div class=" col-md-6" >
				<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="name of the Category" />
			</div>
		</div>
		<!-- description-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10 col-md-6" >
				
				<textarea name="description" class="form-control" placeholder="describe your category"></textarea>	
			</div>
		</div>
		<!-- start ordering Field-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Ordering</label>
			<div class="col-sm-10 col-md-6" >
				<input type="text" name="ordering"class="form-control"  placeholder="number to arrang the category"/>
			</div>
		</div>
		<!-- End Ordering Field-->
		<!-- start Category Field-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Parent of</label>
			<div class="col-sm-10 col-md-6" >
				<select  class="form-control" name="parent">
					<option value="0">None</option>
					<?php  
               $allCats=getAllfrom("*","categories","where parent=0","","ID","ASC");
                      foreach($allCats as $cat){
                      echo"<option value='".$cat['ID']."'>".$cat['name']."</option>";

                      }
					 ?>
					
				</select>
			</div>
		</div>  

        <!--End Category Field-->
	     <!-- Visibility-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Visible</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="vis-yes"type="radio" name="visibility" value="0" checked/>
				<label for="vis-yes"> yes</label>
			</div>
			<div>
				<input  id="vis-no"type="radio" name="visibility" value="1"/>
				<label for="vis-no"> No</label>
			   </div>
			</div>
		</div>
		<!-- allow-comment-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Allow commenting</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="com-yes"type="radio" name="commenting" value="0" checked/>
				<label for="com-yes"> yes</label>
			</div>
			<div>
				<input  id="com-no"type="radio" name="commenting" value="1"/>
				<label for="com-no"> No</label>
			   </div>
			</div>
		</div>

		<!-- allow-ads-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Allow Ads</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="ads-yes"type="radio" name="ads" value="0" checked/>
				<label for="ads-yes"> yes</label>
			</div>
			<div>
				<input  id="ads-no"type="radio" name="ads" value="1"/>
				<label for="ads-no"> No</label>
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


elseif($do=='insert'){
if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Insert Member</h1>";
echo"<div class='container'>";

$name=$_POST['name'];
$desc=$_POST['description'];
$parent=$_POST['parent'];
$order=$_POST['ordering'];
$visible=$_POST['visibility'];
$comment=$_POST['commenting'];
$ads=$_POST['ads'];



$check=checkitem('name','categories',$name);

if($check==1){
$msg='<div class="alert alert-danger"> Sorry name category  <strong> is exist</strong></div>';
redirectHome1($msg,'back');
}

elseif(!empty($name)){
$stmt=$con->prepare("INSERT INTO categories (name, description,parent, ordering, visibility, allow_coment, allow_ads)VALUES(:zname, :zdesc,:zparent, :zorder, :zvis, :zcmt, :zads)");

$stmt->execute(array(
'zname' =>$name,
'zdesc' =>$desc,
'zparent'=>$parent,
'zorder' =>$order,
'zvis' =>$visible,
'zcmt' =>$comment,
'zads'=> $ads
));
echo"<div class='container'>";
$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records inserts</div>';
 redirectHome2($ms,'categories.php?do=manage');
echo"</div>";

}//fin else

}//fin condition server post 

else{
echo"<div class='container'>";
		$msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	 redirectHome1($msg,'back');
echo"</div>";

}
}//fin insert


elseif($do=='edit'){
$catgid=isset($_GET['catgid'])&&is_numeric($_GET['catgid'])?intval($_GET['catgid']):0;
		//select all data depend this id
	$stmt=$con->prepare("SELECT *
                               
                      FROM  
                           categories
                      WHERE
                            ID=?
                     
                    ");
//execute query
$stmt->execute(array($catgid));
//fetch the data
$row=$stmt->fetch();
//row count check if data found
$count=$stmt->rowCount();
//show the form if such id
if($count>0)
{ 
	$_SESSION['namecat']=$row['name'];
 ?>
<h1 class="text-center">Edit Category</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=update" method="POST">
			
		<!-- name categorie-->
		<div class="form-group form-group-lg"><!-- input with lable-->
		<label class="col-sm-2 control-label">Name</label>
			<div class=" col-md-6">
			<input type="hidden" name="id" value="<?php echo $catgid ?>"/>
			<input type="text" name="name" class="form-control"  required="required" placeholder="name of the Category" value="<?php echo $row['name']?>" />
			</div>
		</div>
		<!-- description-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10 col-md-6" >
				
				<textarea name="description" class="form-control"  placeholder="decribe the Category" value="<?php echo $row['description']?>" ></textarea>
				
			</div>
		</div>
		<!-- start ordering-->
	    <div class="form-group form-group-lg">
	    <label class="col-sm-2 control-label">Ordering</label>
		<div class="col-sm-10 col-md-6" >
		<input type="text" name="ordering"class="form-control"  placeholder="number to arrang the categories"
		value="<?php echo $row['ordering']?>"/>
		</div>
		</div>
		<!--start parent field-->
			<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Parent of</label>
			<div class="col-sm-10 col-md-6" >
				<select  class="form-control" name="parent">
					<option value="0">None</option>
					<?php  
               $allCats=getAllfrom("*","categories","where parent=0","","ID","ASC");
                      foreach($allCats as $c){

                      echo"<option value='".$c['ID']."'";
                      if($row['parent']==$c['ID']){echo 'selected';}
                      echo">".$c['name']."</option>";

                      }
					 ?>
					
				</select>
			</div>
		</div>
	<!-- Visibility-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Visible</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="vis-yes"type="radio" name="visibility" value="0" <?php if($row['visibility']==0) {echo 'checked';} ?>/>
				<label for="vis-yes">yes</label>
			</div>
			<div>
				<input  id="vis-no"type="radio" name="visibility" value="1" <?php if($row['visibility']==1) echo 'checked'; ?>/>
				<label for="vis-no"> No</label>
			   </div>
			</div>
		</div>
		<!-- allow-comment-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Allow commenting</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="com-yes"type="radio" name="commenting" value="0" <?php if($row['allow_coment']==0) echo 'checked';?>/>
				<label for="com-yes"> yes</label>
			</div>
			<div>
				<input  id="com-no"type="radio" name="commenting" value="1"  <?php if($row['allow_coment']==1) echo 'checked';?>/>
				<label for="com-no"> No</label>
			   </div>
			</div>
		</div>

		<!-- allow-ads-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">Allow Ads</label>
			<div class="col-sm-10 col-md-6" >
			<div>
				<input  id="ads-yes"type="radio" name="ads" value="0"  <?php if($row['allow_ads']==0){ echo 'checked';}?>/>
				<label for="ads-yes"> yes</label>
			</div>
			<div>
				<input  id="ads-no"type="radio" name="ads" value="1" <?php if($row['allow_ads']==1) echo 'checked';?>/>
				<label for="ads-no"> No</label>
			   </div>
			</div>

			<!-- submit-->
		<div class="form-group form-group-lg">
			<div class=" col-sm-offset-2 col-sm-10" >
				<input type="submit" value="Save Category" class="btn btn-primary btn-lg"/>
			</div>
		</div>
		</form>
		</div	
<?php

}//fin if count
else
	{echo"<div class'container'>";

$msgg="<div class='alert alert-danger'>not available ID</div>";
redirectHome1($msgg,'back');
echo"</div>";
}

}//fin edit


elseif($do=='update'){
if($_SERVER['REQUEST_METHOD']=='POST'){
echo"<h1 class='text-center'> Update Categories</h1>";
echo"<div class='container'>";

$idd=$_POST['id'];
$name=$_POST['name'];
$desc=$_POST['description'];
$parent=$_POST['parent'];
$order=$_POST['ordering'];
$visible=$_POST['visibility'];
$comment=$_POST['commenting'];
$ads=$_POST['ads'];

$check=checkitem('name','categories',$name);
if($check<1 or $name=$_SESSION['namecat']){

$stmt=$con->prepare("UPDATE categories SET name= ?, description= ?,parent=? , ordering= ?, visibility= ? , allow_coment= ?, allow_ads= ?
                      WHERE
                        ID=?
                     
                      ");

//execute query
 $stmt->execute(array($name,$desc,$parent,$order,$visible,$comment,$ads,$idd));
 echo"<div class='container'>";
$ms="<div class='alert alert-success'>".$stmt->rowCount() .'records updates</div>';

 redirectHome2($ms,'categories.php');
 echo"</div>";
 

}else{

 echo"<div class='container'>";
	$msg='<div class="alert alert-danger">sorry the name categorie is exist</div>';
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

elseif($do=='delete'){
	echo"<h1 class='text-center'> Delete Category</h1>
		<div class='container'>";

$id=isset($_GET['catgid'])&&is_numeric($_GET['catgid'])?intval($_GET['catgid']):0;
		//select all data depend this id
$count=checkitem('ID','categories',$id);
if($count>0){
$stmt=$con->prepare("DELETE FROM categories WHERE ID=?");
$stmt->execute(array($id));
$count=$stmt->rowCount();
echo"<div class='container'></div>";
	$ms= "<div class='alert alert-success'>".$stmt->rowCount() .'records Deteted</div>';

 redirectHome1($ms,'back');
	echo"</div>";
}else{
echo"<div class='container'>";
   $mss="<div class='alert alert-danger'>this id not exist</div>";
   redirectHome1($mss,'back');
   echo"</div>";

}


}//fin do


include $tpl.'footer.php';
}//fin condition session


else {
header('Location:index.php');
exit();

  }
  ?>
