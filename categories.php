<?php 
session_start();
$title="Categories";
include 'init.php';
if(isset($_GET['pageid'])){
$stmt=$con->prepare("SELECT name from categories where ID=? ");
$stmt->execute(array($_GET['pageid']));
$row=$stmt->fetch();
$count=$stmt->rowCount();
if($count>0){
	

?>



<div class="container">
<h1 class="text-center"><?php echo $row['name'];?> </h1>
 <div class="row">

<?php
}else{

	
	header('Location:index.php');
}



//function return items approved
$allitems=getAllfrom("*","items","where Cat_ID={$_GET['pageid']}","AND approve=1","item_ID");
foreach($allitems as $item){
echo'<div class="col-sm-6 col-md-3 box">';
	echo'<div class="thumbnail item-box">';
	echo'<span class="price-tag">$'.$item['price'].'</span>';
        echo"<img  class='img-responsive'style='width:200px; height:200px;' src='uploads/items/".$item['image']."' alt=''/>";
        echo"<div class='caption'>";
        echo'<div><a href="items.php?itemid='.$item['item_ID'].'">'.$item['Name'].'</a></div>';
        echo'<p>'.$item['description'].'</p>';
         echo'<p>'.$item['date_ad'].'</p>';


        echo'</div>';//caption
	echo'</div>';//thumbnail
echo'</div>';//col

}

}
else{

	
		header('Location:index.php');
}

?> 

  </div><!--fin row-->
</div><!--fin container-->







<?php  include $tpl."footer.php"; ?>