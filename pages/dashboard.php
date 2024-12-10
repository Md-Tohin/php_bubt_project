<?php 
    require_once "app/classes/Dashboard.php";
    $obj = new Dashboard();
    $data = $obj->dashboard();
    // echo "<pre>";
    // print_r($data);
    // exit();
?>

<!-- Header -->
<?php include "pages/includes/header.php" ?>
<!-- /Header -->

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header top -->
    <?php include "pages/includes/header-top.php" ?>
    <!-- /Header top -->
    
    <!-- Sidebar -->
    <?php include "pages/includes/sidebar.php" ?>
    <!-- /Sidebar -->
    
    <!-- Page Wrapper -->
    <div class="page-wrapper">
    
        <!-- Page Content -->
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome 
                            <?php
                                if (isset($_SESSION['name'])) {
                                    echo $_SESSION['name'];
                                }
                            ?>!
                        </h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
        
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $data['total_student'] ?></h3>
                                <span>Students</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $data['total_teacher'] ?></h3>
                                <span>Teachers</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $data['total_class'] ?></h3>
                                <span>Classes</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $data['total_group'] ?></h3>
                                <span>Groups</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
    
</div>
<!-- /Main Wrapper -->
		
<?php include "pages/includes/footer.php" ?>