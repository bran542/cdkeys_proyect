

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
                            <textarea class="form-control" name="txtDescription" id="txtDescription" rows="2" placeholder="Enter product description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="txtPrice">Price:</label>
                            <input type="text" class="form-control" name="txtPrice" id="txtPrice" placeholder="Enter product price">
                        </div>

                        <div class="form-group">
                            <label for="txtStock">Stock:</label>
                            <input type="number" class="form-control" name="txtStock" id="txtStock" placeholder="Enter product stock">
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