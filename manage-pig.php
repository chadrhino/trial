<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
  </header>

  <?php #include 'inc/data.php'; 
  ?>


  <div class="w3-container" style="padding-top:22px">
    <div class="w3-row">
      <h2>Manage Pigs</h2>
      <a href="add-pig.php" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add New Pig</a><br><br>
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Photo</th>
              <th>Pig No.</th>
              <th>Breed</th>
              <th>Classification</th>
              <th>Feed</th>
              <th>Vitamins</th>
              <th>Weight</th>
              <th>Month</th>
              <th>Gender</th>
              <th>Health Status</th>
              <th>Arrived</th>
              <th>Remark</th>
              <th>Desc.</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $all_pig = $db->query("SELECT * FROM pigs WHERE status = 1 ORDER BY id DESC ");
            $fetch = $all_pig->fetchAll(PDO::FETCH_OBJ);
            foreach ($fetch as $data) {
              $get_breed = $db->query("SELECT * FROM breed WHERE id = '$data->breed_id'");
              $breed_result = $get_breed->fetchAll(PDO::FETCH_OBJ);
              foreach ($breed_result as $breed)
                $get_classification = $db->query("SELECT * FROM classification WHERE id = '$data->classification_id'");
              $classification_result = $get_classification->fetchAll(PDO::FETCH_OBJ);
              foreach ($classification_result as $classification)
                $get_feed = $db->query("SELECT * FROM feed WHERE id = '$data->feed_id'");
              $feed_result = $get_feed->fetchAll(PDO::FETCH_OBJ);
              foreach ($feed_result as $feed)
                $get_vitamins = $db->query("SELECT * FROM vitamins WHERE id = '$data->vitamins_id'");
              $vitamins_result = $get_vitamins->fetchAll(PDO::FETCH_OBJ);
              foreach ($vitamins_result as $vitamins) {
            ?>
                <tr>
                  <td><?php echo $data->id ?></td>
                  <td>
                    <img width="70" height="70" src="<?php echo $data->img; ?>" class="img img-responsive thumbnail">
                  </td>
                  <td><?php echo $data->pigno ?></td>
                  <td><?php echo $breed->name ?></td>
                  <td><?php echo $classification->name ?></td>
                  <td><?php echo $feed->name ?></td>
                  <td><?php echo $vitamins->name ?></td>
                  <td><?php echo $data->weight ?></td>
                  <td><?= $data->month ?></td>
                  <td><?php echo $data->gender ?></td>
                  <td><?php echo $data->health_status ?></td>
                  <td><?php echo $data->arrived ?></td>
                  <td><?php echo wordwrap($data->remark, 300, '<br>'); ?></td>
                  <td><?php echo $data->description ?></td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
                        <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="edit-pig.php?id=<?php echo $data->id ?>"><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a onclick="return showDelete()"><i class="fa fa-trash"></i> Delete</a></li>
                        <li><a onclick="return showQuarantine()" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Quarantine Pig</a></li>
                        <li><a onclick="return showSold()" style="cursor: pointer;"><i class="fa fa-paper-plane"></i> Sold Pig</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>

<script>
  function showSold() {
    Swal.fire({
      title: "Do you want to sell this pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "sold.php?id=<?php echo $data->id; ?>"
      }
    });
  }

  function showQuarantine() {
    Swal.fire({
      title: "Do you want to add this to quarantine?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "quarantine.php?id=<?php echo $data->id; ?>"
      }
    });
  }

  function showDelete() {
    Swal.fire({
      title: "Do you want to delete this to pig?",
      showDenyButton: true,
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = "delete.php?id=<?php echo $data->id ?>"
      }
    });
  }
</script>


<?php include 'theme/foot.php'; ?>