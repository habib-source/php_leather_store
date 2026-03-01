<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../src/Models/user.class.php');
$user=new User();
$user->id=$_GET["id"];
$user_data=$user->get();
require_once(__DIR__.'/static/header.php');
?>
<h1>Account informations:</h1>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
<form action="../src/Controllers/admin_update_profile.php" method="post" enctype="multipart/form-data">
	<label for="id">ID: <?php echo $user_data["id"]?></label><br>
	<input  type="hidden" id="id" name="id" <?php echo "value='".$user_data["id"]."'"?> ><br>

	<label for="active">Active:</label><br>
	<input  type="checkbox" id="active" name="active" <?php if($user_data["active"]) echo "checked"?> ><br>

	<label for="admin">Admin:</label><br>
	<input  type="checkbox" id="admin" name="admin" <?php if($user_data["admin"])  echo "checked"?> ><br>

	<label for="user_name">User name:</label><br>
	<input type="text" id="user_name" name="user_name" <?php if(!empty($user_data["user_name"])) echo "value='".$user_data["user_name"]."'"?>><br>
	<label for="first_name">First name:</label><br>
	<input type="text" id="first_name" name="first_name" <?php if(!empty($user_data["first_name"])) echo "value='".$user_data["first_name"]."'"?>><br>
	<label for="last_name">Last name:</label><br>
	<input type="text" id="last_name" name="last_name" <?php if(!empty($user_data["last_name"])) echo "value='".$user_data["last_name"]."'"?>><br>
	<label for="email">Email:</label><br>
	<input type="email" id="email" name="email" <?php if(!empty($user_data["email"])) echo "value='".$user_data["email"]."'"?>><br>
	<fieldset>
		<legend>Sex:</legend>
		<input type="radio" id="hom" name="user_sex" value="M" <?php if ($user_data["user_sex"]=="M") echo "checked" ?> >
		<label for="hom">Male</label><br>
		<input type="radio" id="fem" name="user_sex" value="F" <?php if ($user_data["user_sex"]=="F") echo "checked" ?>>
		<label for="fem">Female</label><br>
	</fieldset>
	<label for="birthday">Birthday:</label><br>
	<input type="date" id="birthday" name="birthday" min="1000-01-01" max="2200-01-01" <?php if(!empty($user_data["birthday"])) echo "value='".$user_data["birthday"]."'"?>><br>
	<label for="photo">Profile Picture:</label><br>
	<?php if(isset($user_data["img_path"])) echo "<img id='photo' width='300' src='../media/".$user_data["img_path"]."'><br>"?>
	<label for="photo">Change your profile Picture:</label><br>
	<input type="file" id="photo" name="photo"><br>
	<input type="submit" value="Update"><br>
</form>
