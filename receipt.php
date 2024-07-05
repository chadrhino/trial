<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php 
 if(!$_GET['id'] OR empty($_GET['id']) OR $_GET['id'] == '')
 {
 	header('location: manage-pig.php');

 }else{
 	
 	$pigno = $bname = $b_id = $cname = $c_id = $fname = $f_id = $vname = $v_id =$health = "";
 	$id = (int)$_GET['id'];
 	$query = $db->query("SELECT * FROM pigs WHERE id = '$id' ");
 	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

 	foreach($fetchObj as $obj){
		$pid = $obj->id;
       $pigno = $obj->pigno;
	   $b_id = $obj->breed_id;
	   $c_id = $obj->classification_id;
       $f_id = $obj->feed_id;
       $v_id = $obj->vitamins_id;
	   $health = $obj->health_status;

	     $k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
		 $k = $db->query("SELECT * FROM classification WHERE id = '$c_id' ");
         $k = $db->query("SELECT * FROM feed WHERE id = '$f_id' ");
         $k = $db->query("SELECT * FROM vitamins WHERE id = '$v_id' ");
       	 $ks = $k->fetchAll(PDO::FETCH_OBJ);
       	 foreach ($ks as $r) {
       	 	$bname = $r->name;
			$cname = $r->name;
            $fname = $r->name;
            $vname = $r->name;
       	 }
 	}
 }

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container dont-print" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
  </header>
 
 <?php #include 'inc/data.php'; ?>

<style>
    table, tr , tr td{
        border: 1px solid #000;
    }
</style>
 <div class="w3-container" style="padding-top:22px">
	<?php 
        $get = $db->query("SELECT p.weight,p.pigno,s.date_sold,s.reason,s.buyer,s.price,p.id,s.money FROM sold s LEFT JOIN pigs p ON s.pig_id = p.id");
        $res = $get->fetch(PDO::FETCH_OBJ);
    ?>

    <div class="w3-padding text-center" style="border: 1px #000 dashed;">
        <h4 style="font-weight: bolder;">JSV Piggery</h4>
        <p>Date: <?= date('m-d-Y', strtotime($res->date_sold)) ?></p>
        <p>Buyer: <?= $res->buyer ?></p>
        <table class="w3-table w3-border w3-border-black w3-margin-top">
            <tr>
                <td>PIG NO.</td>
                <td>WEIGHT</td>
                <td>PRICE</td>
            </tr>
            <tr>
                <td><?= $res->pigno ?></td>
                <td><?= $res->weight ?></td>
                <td><?= number_format($res->price, 2) ?></td>
            </tr>
        </table>

        <div style="text-align: right; width: 100%;">
            <h4>Total: <?= number_format($res->price) ?></h4>
            <h4>Money: <?= number_format($res->money) ?></h4>
            <h3>CHANGE: <?= number_format($res->money - $res->price) ?></h3>
        </div>
    </div>
    
    <button type="button" onclick="print()" class="btn btn-primary dont-print w3-margin-top" style="float: right;"><i class="fa fa-print"></i> Print</button>
</div>

</div>

<?php include 'theme/foot.php'; ?>