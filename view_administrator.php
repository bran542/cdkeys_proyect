<?php
    //session_start();
    include('configuration/db.php');

    //validation that no user is connected
    if (empty($_SESSION['user_id'])) {
        header('Location: /cdkeys_proyect/login.php');
    }

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



    //if something exists through POST we save it in the new variable
    //otherwise the variable will be empty
    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtName = (isset($_POST['txtName']))?$_POST['txtName']:"";
    $txtDescription = (isset($_POST['txtDescription']))?$_POST['txtDescription']:"";
    $txtPrice = (isset($_POST['txtPrice']))?$_POST['txtPrice']:"";
    $txtStock = (isset($_POST['txtStock']))?$_POST['txtStock']:"";
    $txtImage = (isset($_FILES['txtImage']['name']))?$_FILES['txtImage']['name']:"";
    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    

    switch ($accion) {
        case 'Add':
            //add product
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

        case 'Cancel':
            header('Location: /cdkeys_proyect/view_administrator.php');

            break;

        case 'Modify':
            //update product data
            $stmt = $conn->prepare("UPDATE products SET name=:name, description=:description, price=:price, stock=:stock WHERE id = :id");
            $stmt->bindParam(':name', $txtName);
            $stmt->bindParam(':description', $txtDescription);
            $stmt->bindParam(':price', $txtPrice);
            $stmt->bindParam(':stock', $txtStock);
            $stmt->bindParam(':id', $txtID);
            $stmt->execute();

            //if the image variable has a name we assign it otherwise we use the default name
            if ($txtImage!="") {
                $date = new DateTime();
                $filename = ($txtImage!="")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"image.jpg";
                $tmpImage = $_FILES["txtImage"]["tmp_name"];

                move_uploaded_file($tmpImage,"img/".$filename);


                $stmt = $conn->prepare("SELECT image FROM products WHERE id = :id");
                $stmt->bindParam(':id', $txtID);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_LAZY);

                //If there is an image with a unique name, we delete it from the /img folder.
                if (isset($product['image']) && ($product['image']!="image.jpg")) {

                    if (file_exists("img/".$product["image"])) {

                        unlink("img/".$product["image"]);
                    }
                }

                //update product image
                $stmt = $conn->prepare("UPDATE products SET image = :image WHERE id = :id");
                $stmt->bindParam(':image', $filename);
                $stmt->bindParam(':id', $txtID);
                $stmt->execute();
            }

            header('Location: /cdkeys_proyect/view_administrator.php');
            
            break;

        case 'Select':
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
            //replace
            $stmt->bindParam(':id', $txtID);
            $stmt->execute();
            //fetch to load the data 1 to 1
            //FETCH_LAZY to fill in the select fields
            $product = $stmt->fetch(PDO::FETCH_LAZY);
            $txtID = $product['id'];
            $txtName = $product['name'];
            $txtDescription = $product['description'];
            $txtPrice = $product['price'];
            $txtStock = $product['stock'];
            $txtImage = $product['image'];
            break;

        case 'Delete':
            //query to find image with related id
            $stmt = $conn->prepare("SELECT image FROM products WHERE id = :id");
            //replace
            $stmt->bindParam(':id', $txtID);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_LAZY);
            //delete the image from the /img folder
            if (isset($product['image']) && ($product['image']!="image.jpg")) {
                //we search if it exists in the /img folder
                if (file_exists("img/".$product["image"])) {
                    //if it exists we delete it
                    unlink("img/".$product["image"]);
                }
            }
            
            //delete product
            $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $txtID);
            $stmt->execute();
            header('Location: /cdkeys_proyect/view_administrator.php');
            
            break;
    }
    //print products
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $list_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("templates/header.php") ?>

    Welcome <?php echo $user['email']?> <a href="logout.php">Logout</a>

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
                            <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID; ?>" placeholder="ID" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="txtName">Name</label>
                            <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo $txtName; ?>" placeholder="Enter product name" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="txtDescription">Description:</label>
                            <textarea class="form-control" name="txtDescription" id="txtDescription" rows="2" placeholder="Enter product description" required><?php echo $txtDescription; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="txtPrice">Price:</label>
                            <input type="text" class="form-control" name="txtPrice" id="txtPrice" value="<?php echo $txtPrice; ?>" placeholder="Enter product price" required>
                        </div>

                        <div class="form-group">
                            <label for="txtStock">Stock:</label>
                            <input type="number" class="form-control" name="txtStock" id="txtStock" value="<?php echo $txtStock; ?>" placeholder="Enter product stock" required>
                        </div>

                        <div class="form-group">
                            <label for="txtImage">Image:</label>

                            <?php if ($txtImage!="") { ?>
                                <img class="img-thumbnail rounded" src="img/<?php echo $txtImage; ?>" width="50" alt="" srcset="">
                            <?php } ?>
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
                    <?php foreach ($list_products as $product) {?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td><?php echo $product['created_at']; ?></td>
                        <td>
                            <img class="img-thumbnail rounded" src="img/<?php echo $product['image']; ?>" width="50" alt="" srcset="">
                        </td>
                        <td><?php echo $product['users_idusers']; ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $product['id']; ?>">
                                <input type="submit" name="accion" value="Select" class="btn btn-success">
                                <input type="submit" name="accion" value="Delete" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include("templates/footer.php") ?>