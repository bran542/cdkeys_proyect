<?php
    //if something exists through POST we save it in the new variable
    //otherwise the variable will be empty
    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtName = (isset($_POST['txtName']))?$_POST['txtName']:"";
    $txtDescription = (isset($_POST['txtDescription']))?$_POST['txtDescription']:"";
    $txtPrice = (isset($_POST['txtPrice']))?$_POST['txtPrice']:"";
    $txtStock = (isset($_POST['txtStock']))?$_POST['txtStock']:"";
    $txtImage = (isset($_FILES['txtImage']['name']))?$_FILES['txtImage']['name']:"";
    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    
    //session_start();
    include('configuration/db.php');

    if (isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare('SELECT * FROM users WHERE id = :id');
        //replace
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = null;
        if (count($result) > 0) {
            $user = $result;
        }
    }

    switch ($accion) {
        case 'Add':
            //add products
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image, users_idusers)
                                                VALUES (:name, :description, :price, :stock, :image, :id);");
            //replace
            $stmt->bindParam(':name', $txtName);
            $stmt->bindParam(':description', $txtDescription);
            $stmt->bindParam(':price', $txtPrice);
            $stmt->bindParam(':stock', $txtStock);
            

            //upload instruction for date
            $date = new  DateTime();
            //if an image exists, we also add the time to the image name
            //otherwise, the empty image variable will be left with the name 'image.jpg'
            $filename = ($txtImage!="")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"image.jpg";
            //we store temporary images, it is the original image in a variable
            $tmpImage = $_FILES["txtImage"]["tmp_name"];
            //If this variable is occupied, move it to the following folder
            if ($tmpImage!="") {
                move_uploaded_file($tmpImage,"img/".$filename);
            }

            $stmt->bindParam('image', $filename);
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();
            header('Location: /cdkeys_proyect/view_administrator.php');

            break;
    }
?>

<?php include("templates/header.php") ?>

    <div class="row">
        <div class="col-md-3">

            <div class="card">
                <div class="card-header">
                    Product data
                </div>

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                
                        <div class="form-group">
                            <label for="txtID">ID</label>
                            <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="txtName">Name</label>
                            <input type="text" class="form-control" name="txtName" id="txtName" placeholder="Enter product name" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="txtDescription">Description:</label>
                            <textarea class="form-control" name="txtDescription" id="txtDescription" rows="2" placeholder="Enter product description" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="txtPrice">Price:</label>
                            <input type="text" class="form-control" name="txtPrice" id="txtPrice" placeholder="Enter product price" required>
                        </div>

                        <div class="form-group">
                            <label for="txtStock">Stock:</label>
                            <input type="number" class="form-control" name="txtStock" id="txtStock" placeholder="Enter product stock" required>
                        </div>

                        <div class="form-group">
                            <label for="txtImage">Image:</label>
                            <input type="file" class="form-control" name="txtImage" id="txtImage">
                        </div><br>

                        <div class="btn-group" role="group">
                            <button type="submit" name="accion" value="Add" class="btn btn-primary">Add</button>
                            <button type="submit" name="accion" value="Modify" class="btn btn-warning">Modify</button>
                            <button type="submit" name="accion" value="Cancel" class="btn btn-secondary">Cancel</button>
                        </div>
                        <?php echo $user['id'];?>
                    </form>
                </div>
            </div>

            
        </div>

        <div class="col-md-9">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Created at</th>
                        <th>Image</th>
                        <th>Created by</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>id</td>
                        <td>name</td>
                        <td>description</td>
                        <td>price</td>
                        <td>stock</td>
                        <td>created at</td>
                        <td>image</td>
                        <td>users_idusers</td>
                        <td>
                            <form action="" method="POST">
                                <input type="submit" name="txtID" id="txtID" value="id">
                                <input type="submit" name="accion" value="Select" class="btn btn-success">
                                <input type="submit" name="accion" value="Delete" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php include("templates/footer.php") ?>