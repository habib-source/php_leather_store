<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../src/Models/order.class.php');
$order=new Order();
$order->id=$_GET["id"];
$order_data=$order->get();
require_once('../src/Models/user.class.php');
$user=new user();
$user_name=$user->dynamic_get("user_name", array("id" => $order_data['user_id']));
require_once(__DIR__.'/static/header.php');
?>
<h1>Update Order Status:</h1>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
<form action="../src/Controllers/admin_modify_order_status.php" method="post">
	<label for="id">ID: <?php echo $order_data["id"]?></label><br>
	<input  type="hidden" id="id" name="id" <?php echo "value='".$order_data["id"]."'"?> >
	<p> Custemer name: <?php echo $user_name ?></label><br>
	<fieldset>
		<legend>Status:</legend>
		<input type="radio" id="pending" name="status" value="pending" <?php if ($order_data["status"]=="pending") echo "checked" ?>>
		<label for="pending">Pending</label><br>
		<input type="radio" id="processing" name="status" value="processing" <?php if ($order_data["status"]=="processing") echo "checked" ?>>
		<label for="processing">Processing</label><br>
		<input type="radio" id="shipped" name="status" value="shipped" <?php if ($order_data["status"]=="shipped") echo "checked" ?>>
		<label for="shipped">Shipped</label><br>
		<input type="radio" id="delivered" name="status" value="delivered" <?php if ($order_data["status"]=="delivered") echo "checked" ?>>
		<label for="delivered">Delivered</label><br>
		<input type="radio" id="cancelled" name="status" value="cancelled" <?php if ($order_data["status"]=="cancelled") echo "checked" ?>>
		<label for="cancelled">Cancelled</label><br>
	</fieldset>
	<input type="submit" value="Update"><br>
</form>
