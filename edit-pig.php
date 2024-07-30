<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php
if (!$_GET['id'] or empty($_GET['id']) or $_GET['id'] == '') {
	header('location: manage-pig.php');
} else {

	$pigno = $weight = $gender = $remark = $arr = $bname = $b_id = $f_id =  $c_id = $v_id = $health = $img = "";
	$id = (int)$_GET['id'];
	$query = $db->query("SELECT * FROM pigs WHERE id = '$id' ");
	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

	foreach ($fetchObj as $obj) {
		$pigno = $obj->pigno;
		$weight = $obj->weight;
		$gender = $obj->gender;
		$remark = $obj->remark;
		$arr = $obj->arrived;
		$b_id = $obj->breed_id;
		$c_id = $obj->classification_id;
		$f_id = $obj->feed_id;
		$v_id = $obj->vitamins_id;
		$health = $obj->health_status;
		$img = $obj->img;
		$month = $obj->month;

		$k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
		$k = $db->query("SELECT * FROM classification WHERE id = '$c_id' ");
		$k = $db->query("SELECT * FROM feed WHERE id = '$f_id' ");
		$k = $db->query("SELECT * FROM vitamins WHERE id = '$v_id' ");
		$ks = $k->fetchAll(PDO::FETCH_OBJ);
		foreach ($ks as $r) {
			$bname = $r->name;
			$fname = $r->name;
			$cname = $r->name;
			$vname = $r->name;
		}
	}
}

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">

			<div class="col-md-6">

				<?php
				if (isset($_POST['submit'])) {
					$n_pigno = $_POST['pigno'];
					$n_weight = $_POST['weight'];
					$n_arrived = $_POST['arrived'];
					$n_breed = $_POST['breed'];
					$n_classification = $_POST['classification'];
					$n_feed = $_POST['feed'];
					$nvitamins = $_POST['vitamins'];
					$n_remark = $_POST['remark'];
					$n_status = $_POST['status'];
					$n_month = $_POST['month'];

					$n_id = $_GET['id'];

					$update_query = $db->query("UPDATE pigs SET pigno = '$n_pigno',weight = '$n_weight',arrived = '$n_arrived', breed_id = '$n_breed',classification_id = '$n_classification',   feed_id = '$n_feed', remark = '$n_remark',health_status = '$n_status', month = '$n_month' WHERE id = '$n_id' ");

					if ($update_query) { ?>

						<script>
							const Toast = Swal.mixin({
								toast: true,
								position: "top-end",
								showConfirmButton: false,
								timer: 1500,
								timerProgressBar: true,
								didOpen: (toast) => {
									toast.onmouseenter = Swal.stopTimer;
									toast.onmouseleave = Swal.resumeTimer;
								}
							});

							Toast.fire({
								icon: "success",
								title: "Pig updated successfully"
							}).then(function(){
								window.location.href = "edit-pig.php?id=<?= $n_id ?>"
							});
						</script>
					<?php
					} else { ?>
						<div class="alert alert-danger alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error updating pig data. Please try again <i class="fa fa-times"></i></strong>
						</div>
				<?php
					}
				}

				?>




				<h2>Edit Pig</h2>
				<form method="post">
					<div class="form-group">
						<label class="control-label">Pig No.</label>
						<input type="text" name="pigno" class="form-control" value="<?php echo $pigno; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Pig Weight</label>
						<input type="text" name="weight" class="form-control" value="<?php echo $weight; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Month</label>
						<select name="month" class="form-control" required>
							<?php
							for ($i = 1; $i <= 1000; $i++) {
								if ($month == $i) {
									?>
								<option selected value="<?= $i ?>"><?= $i ?> month</option>
							<?php
								}else{
									?>
								<option value="<?= $i ?>"><?= $i ?> month</option>
							<?php
								}
							}
							?>

						</select>
					</div>

					<div class="form-group date" data-provide="datepicker">
						<label class="control-label">Arrival date</label>
						<input type="text" name="arrived" class="form-control" value="<?php echo $arr; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Health Status</label>
						<input type="text" name="status" class="form-control" value="<?php echo $health; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Breed</label>
						<select name="breed" class="form-control">
							<option value="<?php echo $b_id; ?>" selected><?php echo $bname; ?></option>
							<?php
							$getBreed = $db->query("SELECT * FROM breed");
							$res = $getBreed->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $r) { ?>
								<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Classification</label>
						<select name="classification" class="form-control">
							<option value="<?php echo $c_id; ?>" selected><?php echo $r->name; ?></option>
							<?php
							$getClassification = $db->query("SELECT * FROM Classification");
							$res = $getClassification->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $r) { ?>
								<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Feed</label>
						<select name="feed" class="form-control">
							<option value="<?php echo $f_id; ?>" selected><?php echo $r->name; ?></option>
							<?php
							$getFeed = $db->query("SELECT * FROM feed");
							$res = $getFeed->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $r) { ?>
								<option value="<?php echo $r->f_id; ?>"><?php echo $r->name; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Vitamins</label>
						<select name="vitamins" class="form-control">
							<option value="<?php echo $v_id; ?>" selected><?php echo $r->name; ?></option>
							<?php
							$getVitamins = $db->query("SELECT * FROM vitamins");
							$res = $getVitamins->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $r) { ?>
								<option value="<?php echo $r->v_id; ?>"><?php echo $r->name; ?></option>
							<?php
							}
							?>
						</select>
					</div>


					<div class="form-group">
						<label class="control-label">Description</label>
						<textarea class="form-control" name="remark"><?php echo $remark; ?></textarea>
					</div>

					<button name="submit" type="submit" name="submit" class="btn btn-sn btn-default">Update</button>
				</form>
			</div>
			<div class="col-md-4 col-md-offset-2">
				<h2>Pig Photo</h2>
				<img src="<?php echo $img; ?>" width="130" height="120" class="thumbnail img img-responsive">
				<p class="text-justify text-center">
					<?php echo $remark; ?>
				</p>
				<a class="btn btn-danger btn-md" onclick="return confirm('Continue delete pig ?')" href="delete.php?id=<?php echo $id ?>"><i class="fa fa-trash"></i> Delete Pig</a>
			</div>
		</div>
	</div>
</div>


<?php include 'theme/foot.php'; ?>