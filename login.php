
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
<div class="cotainer mt-5">
<?php 
session_start();
    if (isset($_SESSION['success'])): ?>
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
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white text-center fs-4 py-3 rounded-top">
            <span id="formTitle">Login Form</span>
        </div>
        <div class="card-body p-4">
            <!-- Login Form -->
            <form id="loginForm" action="actions/authenticate/login.php" method="POST" style="display: block;">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>

            <!-- Register Form -->
            <form id="registerForm" action="actions/authenticate/register.php" method="POST" onsubmit="return validatePasswords()" style="display: none;">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control form-control-lg" id="repassword" name="repassword" placeholder="Re-password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
            </form>

            <!-- Toggle Button -->
            <div class="d-flex justify-content-end">
                <button id="toggleButton" class="btn btn-secondary mt-3" onclick="toggleForms()">Register</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function toggleForms() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const formTitle = document.getElementById("formTitle");
    const toggleButton = document.getElementById("toggleButton");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        formTitle.textContent = "Login Form";
        toggleButton.textContent = "Register";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        formTitle.textContent = "Register Form";
        toggleButton.textContent = "Login";
    }
}

function validatePasswords() {
    const password = document.getElementById("password").value;
    const repassword = document.getElementById("repassword").value;

    if (password !== repassword) {
        alert("Passwords do not match. Please re-enter.");
        return false;
    }
    return true;
}
</script>
<script src="bootstrap/bootstrap.bundle.min.js"></script>

</body>
</html>