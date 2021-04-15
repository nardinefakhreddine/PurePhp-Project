<?php

session_start();
include 'init.php';

?>
<div class="container">
	<div class="row">
		<?php
		if(isset($_GET['name'])){
			$tag =$_GET['name'];

			echo "<h1 class='text-center'>".$_GET['name']."</h1>";
			$getall=$con->prepare("SELECT * From items WHERE tags   LIKE'%$tag%'  AND approve=1 order by item_ID DESC");
               $getall->execute();
               $all=$getall->fetchAll();
			foreach($all as $tagitem){
				echo '<div class="col-sm-6 col-md-3">';
				echo'<div class="thumbnail item-box">';
				echo'<span class="price-tag">'.$tagitem['price'].'</span>';
				echo"<img  class='img-responsive'style='width:200px; height:200px;' src='uploads/items/".$tagitem['image']."' alt=''/>";
				echo'<div class="caption">';
				echo'<h3><a href="items.php?itemid='.$tagitem['item_ID'].'">'.$tagitem['Name'].'</a></h3>';
				echo'<p>'.$tagitem['description'].'</p>';
                echo'<p>'.$tagitem['date_ad'].'</p>';


        echo'</div>';//caption
	echo'</div>';//thumbnail
echo'</div>';//col


}


		










		}else{

			echo"you Must Enter tag Name";
		}

		?>