<?php include "pages/includes/header.php" ?>

<?php 
if (isset($_SESSION['email'])) {
    header("Location: ?page=dashboard");
    exit();
}
require_once "app/classes/Authentication.php";

$auth = new Authentication();

$error = '';

if (isset($_POST['login_btn'])) {
   $error =  $auth->login($_POST);
}

?>



    <!-- Main Wrapper -->
    <div class="main-wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="account-content">
            
            <div class="container">            
                
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Login</h3>
                        <p class="account-subtitle">Access to our dashboard</p>

                        <?php if($error) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo $error ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } ?>
                        <!-- Account Form -->
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" name="email" placeholder="Enter Email.." type="email">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Password</label>
                                    </div>                                    
                                </div>
                                <input class="form-control" name="password" placeholder="Enter Password.." type="password">
                            </div>
                            <div class="form-group text-center">
                                <button name="login_btn" class="btn btn-primary account-btn" type="submit">Login</button>
                            </div>                            
                        </form>
                        <!-- /Account Form -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

<?php include "pages/includes/footer.php" ?>
	