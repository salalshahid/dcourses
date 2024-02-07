<?php 
 if(!isset($_SESSION['activeuser']))
 {
   $_SESSION['activeuser'] = 1;
   
 }
?>
<section class="">
      <?php
     
      // db table info
      $stmt = $db->query("DESCRIBE ". $ctable);
      $stmt->execute();
      $tablecol = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // Delete single row with image from folder
      if (!empty($_GET["did"])) {
      $d_id = $_GET["did"];

        foreach($tablecol as $col){
      if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img"
      || $col["Field"] == "Photo" || $col["Field"] == "Image") {
      $myimgstmt = $db->query("SELECT * FROM $ctable where id = $d_id");
      $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
      $delimg = $imgrow[$col["Field"]];
      unlink($delimg);
      }}
      $stmt = $db->query("DELETE FROM $ctable where id = $d_id ");
      $stmt->execute();
      header("location:".$ctable.".php?s=Row number $d_id has been deleted successfully.");
      ob_end();

      }
      // Delete bulk rows with images from folder
    if (isset($_POST["alldelete"])) {

        if(empty($_POST["check"])){
          $checks = $_POST["check"];
          header("Location: ".$ctable.".php?err=Must select at least one check box for delete from table.");
      ob_end();
        }else{

        $checkbox = $_POST["check"];
        $tr =  count($checkbox);
        for($i=0;$i<=count($checkbox);$i++){
          if (!empty($checkbox[$i])) {
        $id = $checkbox[$i];
          }
        $eid = $_POST["id$id"];

        foreach($tablecol as $col){
      if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img"
      || $col["Field"] == "Photo" || $col["Field"] == "Image") {
      $myimgstmt = $db->query("SELECT * FROM $ctable where id = $eid");
      $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
      $delimg = $imgrow[$col["Field"]];
      unlink($delimg);
      }}

        $stmt = $db->query("DELETE FROM $ctable where id = $eid ");
        $stmt->execute();

      header("Location: ".$ctable.".php?s=Total $tr selected record has been deleted successfully.");
        ob_clean();
      }}}
          // record display limit
          if (isset($_POST["limit"]) or isset($_GET["limit"])) {
        if (!empty($_POST["limit"])) {
              $per_page = $_POST["limit"];
          }
            if (!empty($_GET["limit"])) {
            $per_page = $_GET["limit"];
            }

        }else{
      $per_page = 10;
        }
        // Assending Descending
      if (isset($_GET["asds"])) {
      $asds = $_GET["asds"];
      }else{
      $asds = "ASC";
      }

      // Jump page number
      if (isset($_POST["gosubmit"])) {
      header("Location: ".$ctable.".php?start=".$_POST["go"]);
        ob_end();
      }else{
      $start = 0;
      }
      // Pagination php code
        $page_counter = 0;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;

        if(isset($_GET["start"]) ){
        $start = $_GET["start"];
        $page_counter =  $_GET["start"];
        $start = $start *  $per_page;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;
        }

      // Search submit
            if (isset($_POST["search_submit"]) or !empty($_GET["page"])) {
        if (isset($_POST["usearch"])) {
              $usearch = $_POST["usearch"];
              $scol = $_POST["scol"];

            }
              if (!empty($_GET["page"])) {
                $usearch = $_GET["page"];
                $scol = $_GET["scol"];
              }

              $q = "SELECT * FROM $ctable WHERE $scol like  '$usearch'  ORDER BY id $asds LIMIT   $start, $per_page ";

            }else{
              $usearch = "";
              $scol = "";
              if ($_SESSION['activeuser'] != 1) {
                $mid = $_SESSION['activeuser'];

                $q = "SELECT * FROM $ctable where mid = '$mid' ORDER BY id $asds LIMIT $start, $per_page ";
             
              }else{

                $q = "SELECT * FROM $ctable ORDER BY id $asds LIMIT $start, $per_page ";
              }
            }
    // query to get messages from messages table
        $query = $db->prepare($q);
        $query->execute();

        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
          $result = "";
        }

    // count total number of rows in class table
        $count_query = "SELECT * FROM $ctable";
        $query = $db->prepare($count_query);
        $query->execute();
        $count = $query->rowCount();
        // calculate the pagination number by dividing total number of rows with per page.
        $paginations = ceil($count / $per_page);

    // Export DB table as CSV
    if (isset($_POST['esubmit'])) {

    $start_id = $_POST['start_id'];
    $end_id = $_POST['end_id'];
    $elimit = $_POST['elimit'];
    header('location: csv.php?export=1&startid='.$start_id.'&endid='.$end_id.'&ctable='.$ctable.'&limit='.$elimit);
      ob_end();
    }



    // button menu show hide
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'bfeatures' ");
    $fstmt->execute();
    $bfeatures=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'search' ");
    $fstmt->execute();
    $fsearch=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'filter' ");
    $fstmt->execute();
    $ffilter=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'add' ");
    $fstmt->execute();
    $fadd=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'edit' ");
    $fstmt->execute();
    $fedit=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'view' ");
    $fstmt->execute();
    $fview=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'delete' ");
    $fstmt->execute();
    $fdelete=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'export' ");
    $fstmt->execute();
    $fexport=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'print' ");
    $fstmt->execute();
    $fprint=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'sview' ");
    $fstmt->execute();
    $fsview=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'sedit' ");
    $fstmt->execute();
    $fsedit=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'sdelete' ");
    $fstmt->execute();
    $fsdelete=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'checkbox' ");
    $fstmt->execute();
    $fcheckbox=$fstmt->fetch(PDO::FETCH_ASSOC);

    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'pagination' ");
    $fstmt->execute();
    $fpagination=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'header' ");
    $fstmt->execute();
    $fheader=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'sidebar' ");
    $fstmt->execute();
    $fsidebar=$fstmt->fetch(PDO::FETCH_ASSOC);
    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = 'footer' ");
    $fstmt->execute();
    $ffooter=$fstmt->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="" <?php if ($fheader['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>

    </div>


    <div id="gdown" ></div>


    <!-- *********************** Start Alert Messages   ************************ -->

            <?php
            if (!empty($_GET["s"])) {
            ?>
        <div class="form-control  d-block alert alert-secondary alert-dismissible fade show" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </svg>  <?php echo $_GET["s"]; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>



        <?php
      }
      if (!empty($_GET["err"])) {
        ?>
        <div class="form-control  d-block alert alert-secondary alert-dismissible fade show" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill mb-1 me-1" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>  <?php echo $_GET["err"]; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

        <?php
      }
      ?>


    <!-- *********************** Start Main DB Table   ************************ -->

    <!-- *********************** Start Bulk View   ************************ -->
      <?php if (isset($_POST["bulkview"])) {

        if(empty($_POST["check"])){
          $checks = $_POST["check"];
          header("Location: ".$ctable.".php?err=Must select at least single check box for view");
      ob_end();
        }else{

        $checkbox = $_POST["check"];
        $tr =  count($checkbox);
        for($i=0;$i<=count($checkbox) - 1;$i++){
        if(!empty($checkbox[$i])) {
        $id = $checkbox[$i];
          }
        $id = $_POST["id$id"];
        $stmt = $db->query("SELECT * FROM $ctable where id = $id ");
        $stmt->execute();
        $viewrow = $stmt->fetch(PDO::FETCH_ASSOC);

      ?>
      <div class="card mb-1">
        <div class="card-header bg-white">
          view record
        </div>
        <div class="card-body">
          <?php
            foreach($tablecol as $col){
              $ffield = $col["Field"];
                    $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
                    $fstmt->execute();
                    $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
              if ($hresult['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) {

              }else{
                  if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {

                  ?>

                  <?php

    if (empty($viewrow[$col["Field"]])) {
      ?>
      <div class="mb-3 mt-3">


        <div class="input-group">
          <img width='30' height='30' class='img me-1' src="img/photo.png">

    </div></div>
      <?php
    }else{
    ?>
    <div class="mb-3 mt-3">


      <div class="input-group">
        <img width='30' height='30' class='img me-1' src="<?php echo $viewrow[$col["Field"]]; ?>">

    </div></div>
    <?php

    }
                  ?>



                <?php  }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {
                  ?>

                  <p><?php echo "<strong>".$col["Field"].":  </strong>"; echo $viewrow[$col["Field"]]; ?></p>

                  <?php
                  }
        }
    }
        ?>

        </div>
      </div>


      <?php
    }}}
      ?>
    <!-- *********************** End bulk view rows  ************************ -->


    <!-- *********************** Start single view row  ************************ -->
    <?php

    if (isset($_GET["vid"])) {
      $id = $_GET["vid"];

      $stmt = $db->query("SELECT * FROM $ctable where id = $id ");
      $stmt->execute();
      $viewrow = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="card shadow my-1">
      <div class="card-header bg-white">
        view record
      </div>
      <div class="card-body">
    <?php
      foreach($tablecol as $col){
        $ffield = $col["Field"];
              $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
              $fstmt->execute();
              $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
        if ($hresult['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) {

        }else{






      if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {


      ?>
      <?php

    if (empty($viewrow[$col["Field"]])) {
    ?>
    <div class="mb-3 mt-3">


    <div class="input-group">
    <img width='30' height='30' class='img me-1' src="img/photo.png">

    </div></div>
    <?php
    }else{
    ?>
    <div class="mb-3 mt-3">


    <div class="input-group">
    <img width='30' height='30' class='img me-1' src="<?php echo $viewrow[$col["Field"]]; ?>">

    </div></div>
    <?php

    }
        ?>


    <?php  }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {
      ?>

      <p><?php echo "<strong>".$col["Field"].":  </strong>"; echo $viewrow[$col["Field"]]; ?></p>

      <?php
      }
    }
    }

    ?>

    <?php  ?>
    </div></div>
    <?php

    }
    ?>
    <!-- *********************** end single view row  ************************ -->


    <!-- *********************** Start Signle Edit php code   ************************ -->
    <?php

    if (isset($_POST["seditupdate"])) {

      foreach($tablecol as $col){
        if ($col["Field"] == "id") {
          $id = $_POST[$col["Field"]];
          //echo $id;
      

        }else{

          if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img"
          || $col["Field"] == "Photo" || $col["Field"] == "Image") {
            if(empty($_FILES[$col["Field"]]["tmp_name"])
            && !is_uploaded_file($_FILES[$col["Field"]]["tmp_name"])
            && empty($_POST['editimg'.$col["Field"]])) {
            $tbcol = "";
            }else{
    if ($_FILES[$col["Field"]]["size"] < 500000) {

    $tbcol = $col["Field"];

    if (!empty($_POST['editimg'.$col["Field"]])) {
      $myimgstmt = $db->query("SELECT * FROM $ctable where id = '$id'");
      $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
      $delimg = $imgrow[$col["Field"]];
      unlink($delimg);

          $data = file_get_contents($_POST['editimg'.$col["Field"]]);
          $new = 'img/url'.date('_Y-m-d--s_').'.jpg';
          if (file_put_contents($new, $data)) {
        $target_file = $new;
        }

    }else{


      $myimgstmt = $db->query("SELECT * FROM $ctable where id = '$id'");
      $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
      $delimg = $imgrow[$col["Field"]];
      unlink($delimg);

        $target_dir = "img/";
        $target_file = $target_dir.microtime(true).'_'.basename($_FILES[$col["Field"]]["name"]);
        if (move_uploaded_file($_FILES[$col["Field"]]["tmp_name"], $target_file)) {
          //header('location:index.php?img=success');
          //echo $target_file;

        }
    }


    }else{
      header("Location: ".$ctable.".php?err= ".$ti."  file size is large.");
      ob_end();
    }
    }
          }elseif($col["Field"] != "photo"
          || $col["Field"] != "image" || $col["Field"] != "img"
          || $col["Field"] == "Photo" || $col["Field"] == "Image") {

          if (isset($_POST[$col["Field"]])) {
          $colpost = $_POST[$col["Field"]];

          }
          if (isset($col["Field"])) {
          $colname = $col["Field"];
          }



      $stmt = $db->query("UPDATE $ctable SET $colname = '$colpost' where id = '$id' ");
    if (!empty($tbcol)) {
      $editimgstmt = $db->query("UPDATE $ctable SET $tbcol = '$target_file' where id = '$id' ");
      if ($editimgstmt->execute()) {

        }
      }
      if ($stmt->execute()) {

      header("Location: ".$ctable.".php?s=Row number $id has been successfully updated. ");
        ob_clean();
        }
    }}}}


    ?>
    <!-- *********************** end Single Edit php code   ************************ -->

    <!-- *********************** Start Single Edit Form   ************************ -->
    <?php
    if (isset($_GET["eid"])) {
      $id = $_GET["eid"];

      $stmt = $db->query("SELECT * FROM $ctable where id = $id ");
      $stmt->execute();
      $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-muted"><div class="">Edit Row of <?php echo $ctable ?> Table </div></h6>
        </div>
      <div class="card-body text-muted">

    <form class="" action="<?php echo $ctable; ?>.php" method="post" enctype="multipart/form-data">
        <div class="py-2">
    <?php  foreach($tablecol as $col){

      if ($col["Field"] == "id") {
        ?>


          <input class="form-control mt-1" type="hidden" name="<?php echo $col["Field"]; ?>" value="<?php echo $editrow[$col["Field"]];?>" placeholder="id">

        <?php


      }else{

      $ffield = $col["Field"];
            $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
            $fstmt->execute();
            $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
      if ($hresult['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) {

      }else{




      if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {


      ?>
      <div class="mb-3 mt-3">


        <div class="input-group">
          <?php
          if (str_contains($editrow[$col["Field"]], 'png') || str_contains($editrow[$col["Field"]], 'jpg')) {

    ?>
    <img width='35' height='37' class='img me-1' src="<?php echo $editrow[$col["Field"]]; ?>">


    <?php
    }else{
            ?>
      <img width='35' height='37' class='img me-1' src="img/photo.png"><?php
    }
    ?>
            <input  class="form-control  "  type="file" name="<?php echo $col["Field"] ?>">


        </div>
        <input type='text' name='editimg<?php  echo $col["Field"] ?>' class='form-control mt-1' placeholder='<?php   echo $col["Field"] ?> - or img web Link'>

        <label class="form-text">upload only up to 100kb image  </label>

      </div>
    <?php  }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {
      ?>

    <div class="form-text"><?php echo $col["Field"]; ?></div>
      <input class="form-control mt-1" type="text" name="<?php echo $col["Field"]; ?>" value="<?php echo $editrow[$col["Field"]]; ?>" placeholder="<?php echo $col["Field"]; ?>">

    <?php
    }}}}

      ?>

      <input class="btn btn-dark ccolor mt-2" type="submit" name="seditupdate" value="updates">
    </div>
    </form>

    </div></div>
      <?php
    }

      ?>
    <!-- *********************** End Single Edit Form   ************************ -->

    <!-- *********************** Start Bulk Edit php code   ************************ -->
    <?php

    if (isset($_POST["bulkeditupdate"])) {
    $tr = $_POST["tr"];
      for ($i=0; $i <= $tr; $i++) {

      foreach($tablecol as $col){
        if ($col["Field"] == "id") {
          $id = $_POST[$col["Field"].$i];
        }else{

          if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img"
          || $col["Field"] == "Photo" || $col["Field"] == "Image") {
    // start empty image upload check
            if(empty($_FILES[$col["Field"].$i]["tmp_name"])
            && !is_uploaded_file($_FILES[$col["Field"].$i]["tmp_name"])
          && empty($_POST['editimg'.$col["Field"].$i])) {
            $tbcol = "";
            }else{
            $tbcol = $col["Field"];
    // start file size check
    if ($_FILES[$col["Field"].$i]["size"] < 500000) {

      if (!empty($_POST['editimg'.$col["Field"].$i])) {
        $myimgstmt = $db->query("SELECT * FROM $ctable where id = '$id'");
        $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
        $delimg = $imgrow[$col["Field"]];
        unlink($delimg);

            $data = file_get_contents($_POST['editimg'.$col["Field"].$i]);
            $new = 'img/url'.date('_Y-m-d--s_').'.jpg';
            if (file_put_contents($new, $data)) {
          $target_file = $new;
          }

      }else{


        $myimgstmt = $db->query("SELECT * FROM $ctable where id = '$id'");
        $imgrow = $myimgstmt->fetch(PDO::FETCH_ASSOC);
        $delimg = $imgrow[$col["Field"]];
        unlink($delimg);

          $target_dir = "img/";
          $target_file = $target_dir.microtime(true).'_'.basename($_FILES[$col["Field"].$i]["name"]);
          if (move_uploaded_file($_FILES[$col["Field"].$i]["tmp_name"], $target_file)) {
            //header('location:index.php?img=success');
            //echo $target_file;

          }
    }

    }else{
    // redirect break
    }
    }
          }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {

          if (isset($_POST[$col["Field"].$i])) {
          $colpost = $_POST[$col["Field"].$i];
          }
          if (isset($col["Field"])) {
          $colname = $col["Field"];
          }



          $stmt = $db->query("UPDATE $ctable SET $colname = '$colpost' where id = $id ");
    if (!empty($tbcol)) {

          $editimgstmt = $db->query("UPDATE $ctable SET $tbcol = '$target_file' where id = '$id' ");
          if ($editimgstmt->execute()) {
          //  header("Location: ".$ctable.".php?s= Updated successfully");
            }
          }
      if ($stmt->execute()) {

        header("Location: ".$ctable.".php?s= Bulk rows has been successfully updated. ");
          ob_clean();
        }
    }
    }}}}


      ?>
    <!-- *********************** end Bulk Edit php code   ************************ -->

    <!-- *********************** Start bulk edit form   ************************ -->
    <?php if (isset($_POST["editsubmit"])) {
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-muted"><div class="">Edit Row of <?php echo $ctable ?> Table </div></h6>
        </div>
      <div class="card-body text-muted">
    <?php
      if(empty($_POST["check"])){
        $checks = $_POST["check"];
        header("Location:  ".$ctable.".php?err=Must select at least single check box for edit.");
      ob_end();
      }else{

      $checkbox = $_POST["check"];
      $tr =  count($checkbox);
      for($i=0;$i<=count($checkbox) - 1;$i++){
      if(!empty($checkbox[$i])) {
      $id = $checkbox[$i];
        }
      $id = $_POST["id$id"];
      $stmt = $db->query("SELECT * FROM $ctable where id = $id ");
      $stmt->execute();
      $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <form class="" action="<?php echo $ctable; ?>.php" method="post" enctype="multipart/form-data">
    <div class="">
      <?php
      foreach($tablecol as $col){
        if ($col["Field"] == "id") {
          ?>
    <div class="fw-bold py-2 small">Edit Row Number <?php echo $i; ?> </div>
        <input class="form-control mt-1" type="hidden" name="<?php echo $col["Field"].$i;?>" value="<?php echo $editrow[$col["Field"]]; ?>" placeholder="<?php echo $editrow[$col["Field"]]; ?>">
          <?php
    
        }else{
        $ffield = $col["Field"];
              $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
              $fstmt->execute();
              $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
        if ($hresult['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) {
        }else{
        if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {

        ?>

        <div class="mb-3">
          <div class="input-group">
            <?php
            if (str_contains($editrow[$col["Field"]], 'png') || str_contains($editrow[$col["Field"]], 'jpg')) {

          ?>
          <img width='35' height='37' class='img me-1' src="<?php echo $editrow[$col["Field"]]; ?>">


          <?php
          }else{
              ?>
          <img width='35' height='37' class='img me-1' src="img/photo.png"><?php
          }
          ?>

              <input  class="form-control  "  type="file" name="<?php echo $col["Field"].$i; ?>">



          </div>
          <input type='text' value=""
            name='editimg<?php  echo $col["Field"].$i ?>' class='form-control mt-1'
            placeholder='<?php   echo $col["Field"].$i ?> - or img web Link'>
    <label class="form-text">upload only up to 100kb image  </label>

          </div>

        <?php  }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {
        ?>
    <div class="form-text"><?php echo $col["Field"]; ?></div>
    <input class="form-control mt-1" type="text" name="<?php echo $col["Field"].$i; ?>" value="<?php echo $editrow[$col["Field"]]; ?>" placeholder="<?php echo $col["Field"].$i; ?>">



    <?php

    }}}}

    ?>
    <div class="py-2"></div>
    </div>
    <?php
    }


    ?>
    <input class="form-control mt-1" type="hidden" name="tr" value="<?php echo $i; ?>" placeholder="name">

    <input class="btn btn-dark ccolor mt-2" type="submit" name="bulkeditupdate" value="updates">

    </div>
    </form>
    <?php
    }
    ?>
    </div>


    <?php
    }
    ?>
    <!-- *********************** end bulk Edit form   ************************ -->


    <!-- *********************** Start Bulk Add php code   ************************ -->
    <?php

    if (isset($_POST["addbulk"])) {
      $ti =  $_POST["totalinsert"];
    for ($i=1; $i <= $ti; $i++) {

      foreach($tablecol as $col){
      if ($col["Field"] == "id") {
    $id = $col["Field"];
    //echo $id;
      }elseif ( $col["Field"] == "updates") {
        //echo $col["Field"];
      }else{

    if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img"
    || $col["Field"] == "Photo" || $col["Field"] == "Image") {

      // start empty image upload check
      if(empty($_FILES[$col["Field"].$i]["tmp_name"])
      && !is_uploaded_file($_FILES[$col["Field"].$i]["tmp_name"])
      && empty($_POST['img'.$col["Field"].$i])){
    $tbcol = "";
      }else{
        $tbcol = $col["Field"];
    if ($_FILES[$col["Field"].$i]["size"] < 500000) {

      if (!empty($_POST['img'.$col["Field"].$i])) {

            $data = file_get_contents($_POST['img'.$col["Field"].$i]);
            $new = 'img/url'.date('_Y-m-d--s_').'.jpg';
            if (file_put_contents($new, $data)) {
          $imgfile = $new;

          }
      }else{

      $target_dir = "img/";
      $target_file = $target_dir.microtime(true).'_'.basename($_FILES[$col["Field"].$i]["name"]);
      if (move_uploaded_file($_FILES[$col["Field"].$i]["tmp_name"], $target_file)) {
        $imgfile = $target_file;

      }

      }

    }else{
      // header("Location: ".$ctable.".php?err= ".$ti."  image file size is large .");
      // ob_end();
    }
    }

    }elseif($col["Field"] != "photo" || $col["Field"] != "image"
    || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {

    if(!empty($_POST[$col["Field"].$i])) {
        $apost = $_POST[$col["Field"].$i];
      }else{
        $apost = 1;
      }

        if (!empty($col["Field"])) {
        $colname = $col["Field"];
        }

      $stmt = $db->prepare("INSERT INTO $ctable($colname)
      VALUES(:".$apost.")");
      $stmt->bindParam(":$apost", $apost);

    }}}

      if ($stmt->execute()) {

      }else{
        // header("Location: ".$ctable.".php?err= ".$ti." Oops! something goes wrong. Try again.");
        // ob_end();
      }

        foreach($tablecol as $col){
        if ($col["Field"] == "id") {
      $id = $col["Field"];
        }elseif ( $col["Field"] == "updates") {

        }else{



          if (isset($_POST[$col["Field"].$i])) {
          $post = $_POST[$col["Field"].$i];
          }
          if (isset($col["Field"])) {
          $colname = $col["Field"];
          }

        $laststmt = $db->query("SELECT * FROM $ctable ORDER BY id DESC LIMIT 1");
        $lastrow = $laststmt->fetch(PDO::FETCH_ASSOC);
        $lid =  $lastrow["id"];


        $ustmt = $db->query("UPDATE $ctable SET $colname = '$post' where id = '$lid' ");

    if (!empty($tbcol)) {
        $imgstmt = $db->query("UPDATE $ctable SET $tbcol = '$imgfile' where id = '$lid' ");
    }
    }
    }


    }
    // end for loop
    if (!empty($tbcol)) {
    if ($imgstmt->execute()) {
    }
    }
    if ($ustmt->execute()) {
      header("Location: ".$ctable.".php?s= ".$ti."  Rows added successfully.");
      ob_end();
      }
    }
    // end bulk add submit
    ?>
    <!-- *********************** end Bulk Add php code   ************************ -->

    <!-- *********************** Start Bulk add form   ************************ -->

    <?php
    if (isset($_POST["addsubmit"])) {
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-muted">Insert Record</h6>
        </div>
      <div class="card-body text-muted">

    <form class="" action="<?php echo $ctable; ?>.php" method="post" enctype="multipart/form-data">



    <input class="form-control mt-1" type="hidden" name="totalinsert"
    value="<?php echo $_POST["go"]; ?>" placeholder="go">
    <?php
    $go = $_POST["go"];
    for ($i=1; $i <=$_POST["go"]; $i++) {
      ?>
    <div class="py-2 mt-2 mb-2  rounded ">
      <?php
    foreach($tablecol as $col){

    if ($col["Field"] == "id") {
      ?>
      <span class="fw-bold mt-2 mb-2 d-block">Add Row <?php echo $i; ?></span>
      <?php
    }elseif ($col["Field"] == "updates") {
      }else{
      $ffield = $col["Field"];
            $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
            $fstmt->execute();
            $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
      if ($hresult['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) {

      }else{
      if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {
      ?>
      <div class="mb-3 mt-3">

        <div class="mb-0">
          <input  class="form-control mb-1" value="" type="file" name="<?php echo $col["Field"].$i ?>">

          <input type='text' name='img<?php  echo $col["Field"].$i ?>' class='form-control ' placeholder='<?php echo $col["Field"].$i ?> - or img web Link'>

        </div>
        <label class="form-text">upload only up to 500kb image  </label>
          <input type="hidden" name="check<?php  echo $col["Field"].$i ?>" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" >

      </div>
      <?php  }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img" || $col["Field"] != "Photo" || $col["Field"] != "Image") {
    ?>
    <label class="form-text"><?php echo $col["Field"]; ?></label>
    <input class="form-control mt-1" type="text" name="<?php  echo $col["Field"].$i ?>" value="" placeholder="<?php echo $i." ".$col["Field"]; ?>..">
    <?php
    }

    }


    }

    }
    ?>
    <div class="py-2"></div>
    </div>
      <?php
      }
      ?>



      <button  class="btn btn-sm btn-dark ccolor mt-2 mb-2"type="submit" name="addbulk">Insert</button>

        </form>
      </div>
      </div>
      <?php
      }
      ?>
      <!-- *********************** end Bulk Add form   ************************ -->

      <!-- Start export Modal -->
      <div class="modal fade " id="f3"  aria-labelledby="exampleModalLabel" aria-hidden="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Export Table Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
      <form class="" action="<?php echo $ctable; ?>.php" method="post">



            <input type="hidden" name="elimit" value="<?php echo $count; ?>" />

            <div class="form-text">Start Table Row</div>
            <input   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="5" class="form-control btn-sm rounded-start mt-2"  type="text" name="start_id"  placeholder="Start Number Here" data-bs-toggle="tooltip" data-bs-placement="top"  title="Type starting ID number " required>
            <label class="form-text mb-0 mt-1">End Table Row</label>
            <input   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="5" class="form-control btn-sm rounded-start mt-2"  type="text" name="end_id"  placeholder="End Number Here " data-bs-toggle="tooltip" data-bs-placement="top"  title="Type ending ID number" required>

            <button  class="form-control btn btn-dark btn-sm rounded-end me-2 mt-2 mb-3" type="submit" name="esubmit" >
            Export
          </button>
      </form>

          </div>

        </div>
      </div>
        </div>
      <!-- end export model -->

      <div class="card shadow mb-4">
        <div class="card-header bg-white">
          <?php
          // table name and filename with link
          if ($page_counter > 0) {
            ?>
            <a class="btn btn-sm btn-outline-dark rounded-2" href="<?php echo $filename; ?>.php">

          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
          </svg></a>
            <?php
          }else{
            ?>

          <a class="btn btn-sm btn-dark ccolor" href="<?php echo $filename; ?>.php">

          <span class=""><?php echo $filename; ?></span></a>
          <?php
          }
          ?>

      <!-- *********************** Start Button menus   ************************ -->
      <div class="btn-group py-2" <?php if ($bfeatures['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
        <form  id="limitform" class="" action="<?php echo $ctable; ?>.php" method="post" enctype="multipart/form-data">



      <span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Search" <?php if ($fsearch['action']?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
            <a  href="#" class="btn btn-sm btn-light border border-2 rounded py-1" data-bs-toggle="modal" data-bs-target="#exampleModal" >

              <span class="">
              <svg xmlns="http://www.w3.org/2000/svg"
              width="16" height="16" fill="currentColor"
              class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
              </span>Search

            </a></span>

            <!-- Start Search Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <select name="scol"   class="col-xs-1 form-select form-select-sm mt-2 rounded-start select2-container" >

                      <?php
                      foreach($tablecol as $col){

                        $ffield = $col["Field"];
                              $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
                              $fstmt->execute();
                              $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
                        if ($hresult['action'] ?? null != 'hide') {
                    ?>

                      <option value="<?php  echo $col["Field"]; ?>"> <?php  echo $col["Field"]; ?> </option>

                    <?php }} ?>
                    </select>

                  <input class="form-control btn-sm mt-2" type="text" name="usearch" value="" placeholder="search..">
                  <button class="btn btn-sm btn-dark ccolor  text-light rounded-end mt-2" type="submit" name="search_submit" >
                  Search
                </button>
                  </div>

                </div>
              </div>
            </div>
      <!-- end search model -->

    <!-- filter button -->
      <span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Filter Records" <?php if ($ffilter['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
      <a  href="#" class=" btn btn-sm btn-light border border-2 rounded py-1" data-bs-toggle="modal" data-bs-target="#f1" >
        <span class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
          <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
        </svg>
        </span> Filter
      </a>
      </span>
      <!-- Start Filter Modal -->
      <div class="modal fade " id="f1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Display Limit</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
              <select   class="form-select" name="limit" onchange="submitlimitForm();"   id="inlineFormCustomSelect" multiple aria-label="multiple select example">
                <option  value="<?php if (isset($_POST["limit"]) or isset($_GET["limit"]) ) { echo $per_page; }else{ echo "50"; } ?>" selected> <?php if(isset($_POST["limit"]) or isset($_GET["limit"]) ){ echo $per_page; }else{ echo "30"; } ?> </option>
                <option value="10">10</option>
                <option value="30">30</option>
                  <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
                <option value="500">500</option>
                </select>

            </div>

          </div>
        </div>
      </div>
      <!-- end filter model -->
      <!-- View Button -->
      <button   class="rounded btn btn-sm btn-light rounded border border-2 py-1"
              name="bulkview"  type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom"  title="View" <?php if ($fview['action']?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
             <span class="me-1"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
              </svg> View</span>

            </button>
      <span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Insert Record" <?php if ($fadd['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
      <a  class="rounded btn btn-sm bg-success-subtle py-1" href="#" data-bs-toggle="modal" data-bs-target="#f2" >
       <span class=""> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
          <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
        </svg></span> <span class="">Add</span>
      </a>
      </span>
      <!-- Start Insert Modal -->
      <div class="modal fade " id="f2"  aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Insert Bulk Record</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Add Rows Number"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="2" class="form-control btn-sm rounded-start mt-2"  type="text" name="go" value="1" placeholder="rows ">
              <button class="form-control btn btn-dark ccolor text-light btn-sm rounded-end me-2 mt-2 mb-3" type="submit" name="addsubmit">
              ADD
            </button>
            </div>

          </div>
        </div>
      </div>
      <!-- end Insert model -->

    <!-- Edit button -->
  
                <button  class="btn bg-primary-subtle btn-sm rounded border border-1 py-1" type="submit" name="editsubmit" data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Update" <?php if ($fedit['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
                  <span class="me-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                  </svg></span>Edit
              </button>
                  
    <!-- Delete button -->
              <button  onclick="return confirm('Are you sure? You want to delete')"
              class="rounded btn btn-sm bg-danger-subtle border border-1 py-1 " type="submit" name="alldelete" onclick="return confirm("Are you sure? You want to delete")" data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Delete" <?php if ($fdelete['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
              <span class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                  <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
                </svg>
                </span> 
                Delete
                </button>

    <!-- export link -->

    <span  data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Export" <?php if ($fexport['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
       <button class="btn btn-sm btn-light border border-2 rounded-2  py-1" data-bs-toggle="modal" data-bs-target="#f3">
             <span class=""> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                  <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"/>
                </svg></span>
              Export</button>
            </span>



    <!-- Print Button  -->
    <span  data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Print" <?php if ($fprint['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>
      <!-- data-bs-toggle="collapse"  href="#collapse2" role="button" aria-expanded="false" aria-enumencontrols="collapseExample" -->
    <a OnClick="window.print()" class="btn btn-sm btn-light border border-2 rounded-2 py-1 ">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
      </svg> Print</a>


    </span>



        </div>


      <!-- *********************** End Button menus   ************************ -->

        </div>

      <!-- *********************** Start main DB table body  ************************ -->

      <div class="card-body">

    <?php
      // search result info
    if(!empty($scol) && $result > 1 ) {

    echo "<div class='ms-2 mb-2'><span class='small text-muted mb-2'>showing ".count($result)." search result of ".$usearch." by ".$scol."</span></div>";
    }

      ?>


      <div class="responsive">


      <div class="container-fluid ">


      <?php
      if (!empty($result)) {

    ?>
        <div class="table-responsive">
                <table class="table table-borderless table-hover">

      <!-- table header -->
                    <thead class="bg-light mb-2">

                      <th <?php if ($fcheckbox['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1 ) { echo 'hidden'; } ?>> 
                       <input data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Select All" class="form-check-input" type="checkbox" name="select-all" onclick="toggle(this);" /></th>

      <?php


      foreach($tablecol as $col){
      $ffield = $col["Field"];
            $fstmt = $db->prepare("SELECT * FROM settings where option = '$ctable' and features = '$ffield' ");
            $fstmt->execute();
            $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);
      if ($hresult['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) {

      }else{
      if ($col["Field"] == "id" ) {
      ?>
      <th><?php echo $col["Field"]; ?> <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Sort by ACS and DESC" href="<?php echo $ctable; ?>.php?asds=<?php if($asds=="ASC"){ echo "DESC";}else{ echo "ASC"; } ?>&page=<?php echo $usearch; ?>&scol=<?php echo $scol; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
      </svg></a>

      </th>
      <?php
      }else{




      ?>

                    <th><?php echo $col["Field"]; ?></th>


      <?php

        }}}
      ?>
                    <th <?php if ($fsview['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>View</th>
                    <th <?php if ($fsedit['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>Edit</th>

                    <th <?php if ($fsdelete['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>Delete</th>


                    </thead>

        <!-- end table header -->

                    <tbody>
                    <?php

                        foreach($result as $data) {
                          $id = $data["id"];

                            echo "<tr class='text-secondary text-sm'>";
                          ?>
                          <input type="hidden" name="id<?php echo  $id; ?>"  value="<?php echo  $id; ?>" >
      <td   <?php if ($fcheckbox['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>

          <input class="form-check-input" type="checkbox" name="check[]" id="checkbox-<?php echo $id; ?>" value="<?php echo  $id; ?>"> </td>
                          <?php


                          foreach($tablecol as $col){
                            $ffield = $col["Field"];
                                  $fstmt = $db->prepare("SELECT * FROM settings
                                    where option = '$ctable' and features = '$ffield' ");
                                  $fstmt->execute();
                                  $hresult=$fstmt->fetch(PDO::FETCH_ASSOC);

                            if($hresult['action'] ?? null == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) {

                            }else{

                            if ($col["Field"] == "photo" || $col["Field"] == "image" || $col["Field"] == "img" || $col["Field"] == "Photo" || $col["Field"] == "Image") {
                            ?>

                            <td>

                          <?php
                                              if (file_exists($data[$col["Field"]]) and str_contains($data[$col["Field"]], 'png') || file_exists($data[$col["Field"]]) and str_contains($data[$col["Field"]], 'jpg')) {
                          ?>
                          <a target="_blank" class="" href="<?php echo $data[$col["Field"]] ?>">
                          <img  width='30' height='30' class='img myimg' src="<?php echo $data[$col["Field"]]; ?>"></a>
                          <?php
                          }else{
                            ?>
                            <a target="_blank" class="" href="<?php echo $data[$col["Field"]] ?>">
                            <img  width='30' height='30' class='img myimg' src="img/photo.png"></a>
                            <?php
                          }
                          ?>
                            </td>
            <?php

                            }elseif($col["Field"] != "photo" || $col["Field"] != "image" || $col["Field"] != "img") {

                                            echo "<td class=''>".$data[$col["Field"]]."</td>";
                            }}}




                            ?>
                            <td <?php if ($fsview['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>> <a  data-bs-toggle="tooltip"
                             data-bs-placement="bottom"  title="View Record" class="btn bg-success-subtle btn-sm" href="<?php echo $ctable; ?>.php?v=view&vid=<?php echo $id; ?>">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                            </a></td>

                            <td <?php if ($fsedit['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>> <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Update row" class="btn bg-primary-subtle btn-sm" href="<?php echo $ctable; ?>.php?e=edit&eid=<?php echo $id; ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                              </svg>
                              </a>


                            </td>



        <td <?php if ($fsdelete['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1 and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>> <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Delete row" onclick="return confirm('Are you sure? You want to delete')" class="btn btn-danger btn-sm"
                                onclick="return confirm("Are you sure? You want to delete")"
                                class="text-danger" href="<?php echo $ctable; ?>.php?d=delete&did=<?php echo $id; ?>">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                                  <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
                                </svg></a></td>



                            <?php


                            echo "</tr>";
                            }

                            ?>





      </tbody>
      </table>

      </form>
                      <?php
                      if (!empty($result)) {

                        ?>



                        <!-- *********************** Start pagination   ************************ -->

                                              <form class="" action="<?php echo $ctable; ?>.php" method="post">

                        <div class="btn-group small mb-1" style="height:30px; margin-bottom:-15px;" <?php if ($fpagination['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>

                                                  <input data-bs-toggle="tooltip" data-bs-placement="top"  title="Type Page Number"  class="form-control btn-sm " style="width:45px;" type="text" name="go" value="<?php echo $page_counter; ?>">
                                                  <button data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Jump Page" class="btn btn-dark ccolor text-light btn-sm" type="submit" name="gosubmit" >
                                                  Go
                                                </button>


                                              </form>
                                      <?php


                                          if($page_counter == 0){
                                            ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Next Page" class="btn btn-outline-dark btn-sm"  href="?start=<?php echo $next; ?>&page=<?php echo $usearch?>&limit=<?php echo $per_page;?>&asds=<?php echo $asds;?>&scol=<?php echo $scol; ?>">>></a>
                                            <?php
                                          }else{
                                            ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Go Back" class="btn btn-outline-dark btn-sm"  href="?start=<?php echo $previous;?>&limit=<?php echo $per_page;?>&asds=<?php echo $asds;?>&scol=<?php echo $scol; ?>"><<</a>

                        <select data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Page List"  onChange="window.location.href=this.value" style="width:20px;" class="form-select select2-container" aria-label="Default select example">
                        <?php
                                              for($j=0; $j < $paginations; $j+=$per_page + 1) {
                                              if($j == $page_counter) {
                                                  ?>
                        <option value="?start=<?php echo $j; ?>&page=<?php echo $usearch?>&limit=<?php echo $per_page;?>&asds=<?php echo $asds;?>&scol=<?php echo $scol; ?>">


                        <?php echo $j;?></option>
                              <?php
                                              }else{

                        ?>
                        <option value="?start=<?php echo $j;?>&page=<?php echo $usearch; ?>&limit=<?php echo $per_page;?>&asds=<?php echo  $asds?>&scol=<?php echo $scol; ?>">


                        <?php echo $j;?>
                        </option>
                        <?php
                                              }
                                            } // pagination for loop end of select elements

                        ?>
                        </select>

                        <?php
                                            if($j != $page_counter+1)
                                            ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Go Next" class="btn btn-outline-dark btn-sm"  href="?start=<?php echo $next; ?>&page=<?php echo $usearch;?>&limit=<?php echo $per_page;?>&asds=<?php echo $asds;?>&scol=<?php echo $scol; ?>">>></a>


                        <?php
                        }
                        ?>

                          <?php
                        }
                          ?>
                          </div>
                          <small class="text-muted small mb-0" <?php if ($fpagination['action'] ?? null  == 'hide' and $_SESSION['activeuser'] != 1) { echo 'hidden'; } ?>>Total: pages <?php echo $paginations; ?>,rows<?php echo $count; ?>  </small>

                        <!-- *********************** End pagination  ************************ -->

                    <?php
                          }else{

                            ?>
                            <div class="alert-danger py-2 ps-2 rounded  mb-1 small">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill mb-1 me-1" viewBox="0 0 16 16">
                          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg> No more rows </div>

                            <?php
                          }


                    ?>
         </div>
                      
          
    <script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Select Checkbox
    function toggle(source) {
    var checkboxes = document.querySelectorAll("input[type='checkbox']");
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
    }

    function submitlimitForm(){
    document.getElementById("limitform").submit();
    }
    </script>
 
</section>
