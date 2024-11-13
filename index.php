<?php
include "inc/header.php";

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit;
}
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php 
        echo $_SESSION['success']; 
        unset($_SESSION['success']);
        ?>
    </div>
<?php elseif(isset($_SESSION['error'])):?>
    <div class="alert alert-danger">
        <?php 
        echo $_SESSION['error']; 
        unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>
<div class="d-flex justify-content-end">
    <a href="actions/logout.php">logout</a>
</div>
<div class="card">
    <div class="card-header bg-primary text-white text-center fs-4">
        PHP CRUD
    </div>
    <div class="card-body">
        <form action="actions/saveDetails.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="name">
            </div>
            <div class="form-group">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="d-flex justify-content-end p-1">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="card m-3">
    <div class="card-header bg-primary text-white text-center">
        Details Table
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Image</th>
                <th>Created_At</th>
                <th>Action</th>
            </tr>
            <?php
                $sql = "SELECT * FROM details"; 
                $res = $conn->query($sql);

                // Debugging: Check if the query is successful
                if ($res === false) {
                    // If the query fails, display the error
                    echo "<tr><td colspan='6' class='text-center'>Query failed: " . $conn->error . "</td></tr>";
                } else {
                    if ($res->num_rows > 0) {
                        $sno = 0;
                        while ($row = $res->fetch_array()) {
                            $sno++;
                            echo "<tr>"; 
                            echo "<td>" . $sno . "</td>"; 
                            echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>"; // Sanitize name
                            echo "<td><img src='uploads/" . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') . "' alt='Image' width='100' height='100'></td>";
                            echo "<td>" . htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') . "</td>"; 
                            echo "<td>
                                    <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' 
                                            data-id='" . $row['id'] . "' 
                                            data-name='" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "' 
                                            data-image='" . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') . "'>
                                        Edit
                                    </button>";
                            echo "<form action='actions/deleteDetails.php' method='POST'>
                                        <input type='hidden' name='delete' value='" . $row['id'] . "'>
                                        <button class='btn btn-danger'>Delete</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        // No data returned by query
                        echo "<tr><td colspan='6' class='text-center'>No Data Found</td></tr>";
                    }
                }
                ?>
        </table>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/updateDetails.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group mb-3">
                        <label for="edit-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="edit-image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            // Extract info from data-* attributes
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var image = button.getAttribute('data-image');

            // Update the modal's input fields
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-image').value = image;
        });
    });
</script>


<?php include "inc/footer.php"?>
    
