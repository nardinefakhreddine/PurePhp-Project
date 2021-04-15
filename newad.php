<?php 
session_start();
$title="Create New Item";
 include 'init.php';
 if(isset($_SESSION['user'])){
  if($_SERVER['REQUEST_METHOD']=='POST'){
  $formErrors=array();
  $userid=$_SESSION['userid'];
$name=filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$description=filter_var($_POST['description'], FILTER_SANITIZE_STRING);
$price=filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
$country=filter_var($_POST['country'], FILTER_SANITIZE_STRING);

$status=filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);// ZERO BY DEFAULT
$category=filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
$tags=filter_var($_POST['tags'], FILTER_SANITIZE_STRING);


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

 if(empty($name) or empty($description) or empty($country) or empty($price)or empty($status)or empty($category)){
$formErrors[]="please ensure your empty field ";
}
if(strlen($name)<3){
$formErrors[]="Item name must be at least 3 characters";
 }
 if(strlen($description)<5){
$formErrors[]="Item description must be at least 5 characters";
 }
 if(strlen($country)<2){
$formErrors[]="Item country must be at least 2 characters";
 }
 if(!is_numeric($price)){
$formErrors[]="Item price must be Integer";

 }
 if(! empty($avatarName) &&! in_array($avatarextension, $avatarAllowedExtension)){
$formError[] ='This Extension Is Not<strong> Allowed</strong>';
}
if(empty($avatarName)){
$formError[] ='Avatar Is<strong> Required</strong>';
}
if($avatarSize>4194304){
$formError[] ='Avatar Cant be Larger than<strong>4MB</strong>';
}

if(empty($formError)){
$avatar=rand(0,10000000).'_'.$avatarName;
move_uploaded_file($avatarTmp, "uploads\items\\".$avatar);

//insert data
$stmt=$con->prepare("INSERT INTO items (Name, description,price, country_made,status,image, Cat_ID,Member_ID,date_ad,tags)VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus,:zimage,:zcat,:zuser,now(),:ztags) " );

$stmt->execute(array(
'zname'=>$name,
'zdesc'=>$description,
'zprice'=>$price,
'zcountry'=>$country,
'zstatus'=>$status,
'zimage'=>$avatar,
'zcat'=>$category,
'zuser'=>$userid,
'ztags'=>$tags

));


if($stmt){
$msg="<div class='alert alert-success'>Items has been added</div>";
 
   }






}//fin empty error

}//fin post



?>

<h2 class="text-center"><?php echo $title ?></h2>
<div class="create-ad block">
    <div class="container">
      <div class="panel panel-primary">
        <div class=" panel-heading"><?php echo $title ?></div>
         <div class=" panel-body">

          <div class="row">
              <div class="col-md-8">

           <form class="form-horizontal main-form" action="<?php  echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
      
    <!-- name item-->
    <div class="form-group form-group-lg"><!-- input with lable-->
    <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10 col-md-9" >
        <input type="text" name="name" class="form-control live-name" autocomplete="off"  placeholder="name of the item" />
      </div>
    </div>
    <!-- description-->
    <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10 col-md-9" >
        <input type="text" name="description" class="form-control live-desc"required="required"  placeholder="descripe the item"  />
        
      </div>
    </div>
  <!-- Avatar-->
    <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label"> Avatar</label>
    <div class="col-sm-10 col-md-9" >
        <input type="file" class="form-control" name="avatar" required="required" style="margin-right:20px;"/>
      </div>
    </div>
    
    <!-- price-->
    <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">price</label>
      <div class="col-sm-10 col-md-9" >
        <input type="text" required="required"name="price"class="form-control live-price"  placeholder="price of item"/>
      </div>
    </div>
    <!-- country-->
        <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Country </label>
      <div class="col-sm-10 col-md-9" >
        <input type="text" name="country" required="required"class="form-control"  placeholder="country of made"/>
      </div>
    </div>
    <!-- status-->
        <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Status </label>
      <div class="col-sm-10 col-md-9" >
      <select class="form-control" name="status">
        <option value="">...</option>
        <option value="1">New</option>
        <option value="2">Like New</option>
        <option value="3">Used</option>
        <option value="4">Old</option>
      </select>
      </div>
    </div>

    <!--start Category field-->
      <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Category </label>
      <div class="col-sm-10 col-md-9" >
      <select class="form-control" name="category">
        <option value="">...</option>
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
      <div class="col-sm-10 col-md-9" >
        <input type="text" name="tags" class="form-control"  placeholder="Separate your tag with Comma(,)"/>
      </div>
    </div>

    

  
      <!-- submit-->
    <div class="form-group form-group-lg">
      <div class=" col-sm-offset-2 col-sm-10" >
        <input type="submit" value="Add Category" name="submit" class="btn btn-primary btn-lg"/>
      </div>
    </div>
    </form>






              </div><!--panel com md 8-->








              <div class="col-md-4">
              <div class="thumbnail item-box live-preview">
              <span class="price-tag">0</span>
              <img  class="img-responsive" src="img.jpg" alt=""/>
              <div class="caption">
              <h3>Title</h3>
              <p>Description</p>
              </div>
              </div>
              </div><!--div col md 4-->










             </div><!--panel body-->
             <!-- Start lopping through Errors-->
             <?php
             if(!empty($formErrors)){
              foreach  ($formErrors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
               
              }
              header('refresh:3;newad.php');

             }
             if(isset($msg)){

               redirectHome2($msg,'newad.php');
             }

             ?>

             <!-- end lopping through Errors-->

           </div><!--panel heading-->
         </div><!--panel primary-->
       </div><!--panel container-->

     </div><!--panel block-->





<?php
}else{
  header('Location:login.php');
  exit();
}
include $tpl."footer.php";
 ?>