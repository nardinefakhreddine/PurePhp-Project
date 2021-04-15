<?php 
session_start();
$title="Home Page";
 include 'init.php';
?>
<div class="container">
<h1 class="text-center"> </h1>

 <div class="row">

<?php
//get all items in database order by ID
$allitems=getAllfrom('*','items','where approve=1','','item_ID');
?>
<div class="owl-carousel">
<?php
foreach($allitems as $item){
 
    echo'<div class="thumbnail item-box">';
    echo'<span class="price-tag">$'.$item['price'].'</span>';
           echo"<img  class='img-responsive'style='width:200px; height:200px;' src='uploads/items/".$item['image']."' alt=''/>";
          echo'<div class="caption">';
          echo'<div><a href="items.php?itemid='.$item['item_ID'].'">'.$item['Name'].'</a></div>';
          echo'<p>'.$item['description'].'</p>';
           echo'<p>'.$item['date_ad'].'</p>';
  
  
          echo'</div>';//caption
    echo'</div>';//thumbnail
  
  }
?>
</div>

<div class="quote">

Shop here ! buy all the products you need for the best prices in the market

</div>

</div>


</div>
<?php
  include $tpl."footer.php";


 ?>