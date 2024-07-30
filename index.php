<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>

<div class="container">
	<div class="row" style="margin-top: 10%">

		<h1 class="text-center"><?php echo NAME_X; ?></h1><br>
   <div class="col-md-2 col-md-offset-2">
     <img src="img/pig.png" class="img img-responsive">
   </div>
		<div class="col-md-4">
			<form method="post" autocomplete="off">
				<div class="form-group">
				   <label class="control-label">Admin user</label>
				   <input type="email" name="username" class="form-control input-sm" required>
			    </div>

			    <div class="form-group" >
				   <label class="control-label">Admin Password</label>
				   <div style="position: relative;">
           <input type="password" name="password" class="form-control input-sm" required>
           <i class="fa fa-eye" id="showPass" style="position: absolute; top: 7px; right:10px;cursor: pointer;"></i>
           </div>
			    </div>
                
			    <div style="display: flex; gap: 20px; justify-content: space-between; align-items: center;">
          <button name="submit" type="submit" class="btn btn-md btn-dark">Log in</button>
          <a href="forgot.php">Forgot Password</a>
          </div>
			</form>

			<?php
              if (isset($_POST['submit'])) {
              	$username = trim($_POST['username']);
              	$password = $_POST['password'];

              	$hash = sha1($password);
                
                $q = $db->query("SELECT * FROM admin WHERE username = '$username' AND password = '$hash' LIMIT 1 ");

                $count = $q->rowCount();
                $rows = $q->fetchAll(PDO::FETCH_OBJ);

                if($count > 0){
                   foreach($rows as $row){
                     $user_id = $row->id;
                     $user_name = $row->name;
                     $user = $row->username;

                     $_SESSION['id'] = $user_id;
                     $_SESSION['name'] = $user_name;
                     $_SESSION['user'] = $user;

                     header('location: dashboard.php');
                   }
                }else{
                	$error = 'incorrect login details';
                }

              }


            if(isset($error)){ ?>
            <br><br>
               <div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><?php echo $error; ?>.</strong>
              </div>
            <?php }
			?>


		</div>
	</div>
</div>

<script>
  let password = document.querySelector("input[name='password']")
  let showPass = document.getElementById("showPass")

  showPass.onclick = () =>{
    if (password.getAttribute("type") == 'password') {
      password.setAttribute("type", "text")
      showPass.classList.replace("fa-eye", "fa-eye-slash")
    }else{
      password.setAttribute("type", "password")
      showPass.classList.replace("fa-eye-slash","fa-eye")
    }
  }

</script>


<?php include 'theme/foot.php'; ?>
