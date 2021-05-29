<!-- database connection with project folder -->
<?php

  $db = mysqli_connect("localhost","root","","newstoday");
  if($db){
    //echo "Database connection established!";
  }
  else{
    echo "Database connection error!";
  }

  ob_start();

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- custorm css file link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>News Today!</title>
  </head>
  <body>
    <center class="mt-5 mb-5">
      <h1>CRUD operation in PHP</h1>
    </center>
    <div class="container">
      <div class="row">
        <!-- form (create operation) -->
        <div class="col-md-6">
          <form method="POST">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Add New Category</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Category Name" name="cat_name">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Category Description</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="cat_desc"></textarea>
            </div>
            <button type="submit" class="btn btn-md btn-primary" value="Add Category" name="add_cat">Add Category</button>
          </form>
          <!-- Update Operation -->

          <?php
            if(isset($_GET['update_id'])){
              $update_id = $_GET['update_id'];

              //Read all info of that id

              $sql4 = "SELECT * FROM category WHERE c_id='$update_id'";
              $result = mysqli_query($db,$sql4);
              while($row = mysqli_fetch_assoc($result)){
                $c_id = $row['c_id'];
                $c_name = $row['c_name'];
                $c_desc = $row['c_desc'];
              }
          ?>

          <h1 class="mt-5">Update Information</h1>
          <form method="POST">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Add New Category</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Category Name" name="cat_name" value="<?php echo $c_name;?>">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Category Description</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="cat_desc">
                <?php echo $c_desc;?>
              </textarea>
            </div>
            <button type="submit" class="btn btn-md btn-primary" value="Add Category" name="update_cat">Add Category</button>
          </form>

          <?php
            }
          ?>

        </div>
        <?php
          //create operation
          if(isset($_POST['add_cat'])){
            $cat_name = $_POST['cat_name'];
            $cat_desc = $_POST['cat_desc'];
            //echo $cat_name." ".$cat_desc;

            //Total 3 step to send value to database
            //1.Write query language
            //2.sql > database
            //3. database feedback

            $sql = "INSERT INTO category(c_name, c_desc) VALUES('$cat_name', '$cat_desc')";
            $result = mysqli_query($db, $sql);
            if($result){
              //echo "Value Inserted!";
            }
            else{
              echo "Insertion Error!";
            }
          }

          //Update Operation
          if(isset($_POST['update_cat'])){
            $cat_name = $_POST['cat_name'];
            $cat_desc = $_POST['cat_desc'];

            $sql5 = "UPDATE category SET  c_name = '$cat_name', c_desc = '$cat_desc' WHERE c_id = '$update_id'";
            $result3 = mysqli_query($db, $sql5);
            if($result3){
              //echo "Update Successfully!";
              header('Location: index.php');
            }else{
              echo "Update Error!";
            }
          }

        ?>
        <!-- table (read operation) -->
        <div class="col-md-6">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- //read operation
              //Total 3 step to read data from database
              //1.query Language
              //2.sql > database
              // database feedback
 -->
              <?php
                $count = 0;
                $sql2 = "SELECT * FROM category";
                $result = mysqli_query($db, $sql2);
                while($row = mysqli_fetch_assoc($result)){
                  $c_id = $row['c_id'];
                  $c_name = $row['c_name'];
                  $c_desc = $row['c_desc'];
                  $count++;
              ?>

              <tr>
                <th scope="row"><?php echo $count++;?></th>
                <td><?php echo $c_name; ?></td>
                <td><?php echo $c_desc; ?></td>
                <td>
                  <a href="index.php?update_id=<?php echo $c_id;?>" class="badge bg-warning"><span>Edit</span></a>
                  <a href="index.php?delete_id=<?php echo $c_id;?>" class="badge bg-danger"><span>Delete</span></a>
                </td>
              </tr>
              <?php
                }
              ?>
              
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php 
      //delete operation

      if(isset($_GET['delete_id'])){
        $delete_id = $_GET['delete_id'];
      
      //delete query
      $sql3 = "DELETE FROM category WHERE c_id = '$delete_id'";
      $result2 = mysqli_query($db, $sql3);
      if($result2){
        //echo "Successfully deleted!";
        //To auto redirect page after delete operation
        header('Location: index.php');

      }
      else{
        echo "Delete Operation Error!";
      }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <?php 

      ob_end_flush();

    ?>
  </body>
</html>