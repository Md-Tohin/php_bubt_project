<?php include "pages/includes/header.php" ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="account-content">
            
            <div class="container">            
                
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Login</h3>
                        <p class="account-subtitle">Access to our dashboard</p>
                        
                        <!-- Account Form -->
                        <form action="index.html">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Password</label>
                                    </div>                                    
                                </div>
                                <input class="form-control" type="password">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Login</button>
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
	