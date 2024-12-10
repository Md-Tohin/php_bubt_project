<?php

    require_once "app/classes/Student.php";

    // use App\classes\Student;
    $stu = new Student();

    if (isset($_POST['add_studunt_btn'])) {
        $stu->store($_POST);
    }

    if (isset($_POST['update_studunt_btn'])) {
        $stu->update($_POST);
    }

?>

<!-- Header -->
<?php include "pages/includes/header.php" ?>
<!-- /Header -->

<!-- Main Wrapper -->
<div class="main-wrapper">
		
    <!-- Header -->
    <?php include "pages/includes/header-top.php" ?>
    <!-- /Header -->
    
    <!-- Sidebar -->
    <?php include "pages/includes/sidebar.php" ?>
    <!-- /Sidebar -->
    
    <!-- Page Wrapper -->
    <div class="page-wrapper">
    
        <!-- Page Content -->
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Student</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Student</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Student</a>
                        <div class="view-icons">
                            <a href="?page=students" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            <a href="?page=students-list" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <?php
            if (isset($_SESSION['message']) && isset($_SESSION['type'])) {
                echo '<div class="alert alert-' . $_SESSION['type'] . ' alert-dismissible fade show" role="alert">
                        <strong>' . ($_SESSION['type'] == 'success' ? 'Success!' : 'Error!') . '</strong> ' . $_SESSION['message'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';

                // Unset the message after it is displayed
                unset($_SESSION['message']);
                unset($_SESSION['type']);
            }
            ?>
            
            <!-- Search Filter -->
            <form action="?action=student-search" method="post" id="search_student_form">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input name="student_id" type="text" class="form-control floating">
                            <label class="focus-label">Student ID</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input name="student_name" type="text" class="form-control floating">
                            <label class="focus-label">Student Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3"> 
                        <div class="form-group form-focus select-focus">
                            <select name="class_id" class="select floating"> 
                                <option>Select Class</option>
                                <?php
                                    $classes = $stu->get_classes();
                                    while($row = mysqli_fetch_assoc($classes)) { ?>
                                    <option value="<?php echo $row['class_id']?>"><?php echo $row['class_name']?></option>
                                <?php } ?>
                            </select>
                            <label class="focus-label">Class</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <button type="submit" class="btn btn-success btn-block"> Search </button>  
                    </div>
                </div>
            </form>
            <!-- Search Filter -->
            
            <div class="row staff-grid-row" id="student-grid-container">

                <?php
                    $data = $stu->show();
                    $i = 1;
                    while($row = mysqli_fetch_assoc($data)) { ?>
                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="profile.html" class="avatar">
                                        <?php if (isset($row['photo']) && file_exists($row['photo'])) { ?>
                                            <img src="<?php echo $row['photo'] ?>" alt="Image">
                                        <?php } else { ?>
                                            <img src="assets/img/user.jpg" alt="Image">
                                        <?php }?>
                                    </a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" onClick="handleEditBtn(<?php echo $row['st_id']?>, 'student-edit')" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" onClick="handleDeleteBtn(<?php echo $row['st_id']?>, 'student-delete')" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile.html"><?php echo $row['st_name']?></a></h4>
                                <div class="small text-muted"><?php echo $row['email_id']?></div>
                            </div>
                        </div>
                <?php } ?>
            </div>
        </div>
        <!-- /Page Content -->
        
        <!-- Add Student Modal -->
        <div id="add_employee" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Full Name <span class="text-danger">*</span></label>
                                        <input name="full_name" class="form-control" type="text" placeholder="Enter name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input name="email" class="form-control" type="email" placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input name="phone" class="form-control" type="text" placeholder="Enter phone" required>
                                    </div>
                                </div>                                 
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="st_dob" class="form-control datetimepicker" type="text" placeholder="Enter Date of Birth" required></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                    <label class="col-form-label" for="image">Choose Photo <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            placeholder="Enter product image.." onchange="loadFile(event, 'output')" required>
                                        <img class="mt-2" id="output" src="assets/img/user.jpg" alt="Image"
                                                style="width: 90px; height: 85px; border-radius: 5px;">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                        <textarea name="st_address" rows="5" class="form-control" placeholder="Enter address" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                        <select name="st_gender" class="select" placeholder="Enter Gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label class="col-form-label">Admission Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="admission_date" class="form-control datetimepicker" type="text" placeholder="Enter Admission Date" required></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="class_id" class="select" placeholder="Enter Class" required>
                                            <option value="">Select Class</option>
                                            <?php
                                                $classes = $stu->get_classes();
                                                while($row = mysqli_fetch_assoc($classes)) { ?>
                                                <option value="<?php echo $row['class_id']?>"><?php echo $row['class_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Group <span class="text-danger">*</span></label>
                                        <select name="group_id" class="select" placeholder="Enter Group" required>
                                            <option value="">Select Group</option>
                                            <?php
                                                $group = $stu->get_groups();
                                                while($row = mysqli_fetch_assoc($group)) { ?>
                                                <option value="<?php echo $row['group_id']?>"><?php echo $row['group_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                                
                                
                                                                
                            </div>
                            <div class="submit-section">
                                <button name="add_studunt_btn" type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Student Modal -->
        
        <!-- Edit Student Modal -->
        <div id="edit_employee" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="student_id" id="edit-id">
                            <input type="hidden" name="old_image" id="edit-old_image">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" id="edit-full_name" name="full_name" type="text" placeholder="Enter name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input name="email" id="edit-email" class="form-control" type="email" placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input name="phone" id="edit-phone" class="form-control" type="text" placeholder="Enter phone" required>
                                    </div>
                                </div>                                 
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="st_dob" id="edit-st_dob" class="form-control datetimepicker" type="text" placeholder="Enter Date of Birth" required></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                    <label class="col-form-label" for="image">Choose Photo <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            placeholder="Enter product image.." onchange="loadFile(event, 'edit-output')">
                                            <div id="edit-st_photo">
                                                <img class="mt-2" id="edit-output" src="assets/img/user.jpg" alt="Image"
                                                style="width: 90px; height: 85px; border-radius: 5px;">
                                            </div>                                           
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                        <textarea name="st_address" id="edit-st_address" rows="5" class="form-control" placeholder="Enter address" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                        <select name="st_gender" id="edit-st_gender" class="select" placeholder="Enter Gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label class="col-form-label">Admission Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="admission_date" id="edit-admission_date" class="form-control datetimepicker" type="text" placeholder="Enter Admission Date" required></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="class_id" id="edit-class_id" class="select" placeholder="Enter Class" required>
                                            <option value="">Select Class</option>
                                            <?php
                                                $classes = $stu->get_classes();
                                                while($row = mysqli_fetch_assoc($classes)) { ?>
                                                <option value="<?php echo $row['class_id']?>"><?php echo $row['class_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Group <span class="text-danger">*</span></label>
                                        <select name="group_id" id="edit-group_id" class="select" placeholder="Enter Group" required>
                                            <option value="">Select Group</option>
                                            <?php
                                                $group = $stu->get_groups();
                                                while($row = mysqli_fetch_assoc($group)) { ?>
                                                <option value="<?php echo $row['group_id']?>"><?php echo $row['group_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="submit-section">
                                <button name="update_studunt_btn" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Employee Modal -->
        
        <!-- Delete Employee Modal -->
        <div class="modal custom-modal fade" id="delete_employee" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Employee</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="" id="delete_button" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Employee Modal -->
        
    </div>
    <!-- /Page Wrapper -->
    
</div>
<!-- /Main Wrapper -->

<?php include "pages/includes/footer.php" ?>

<script>

    function handleDeleteBtn(id, action){
        $('#delete_button').attr('href', '?action=student-delete&id=' + id);
    }

    function handleEditBtn(id, action){
        $.ajax({
            url: "?action=student-edit&id="+id,
            method: "GET",
            data: { id: id },
            success: function(response) {
                
                var result = JSON.parse(response);
                var {classInfos, groupInfos, studentData} = result;

                if (studentData.error) {
                    alert("Error: " + studentData.error); // If there was an error
                } else {
                    $("#edit-full_name").val(studentData.st_name);
                    $("#edit-email").val(studentData.email_id);
                    $("#edit-phone").val(studentData.cell_no);
                    $("#edit-st_dob").val(studentData.st_dob);
                    $("#edit-st_address").val(studentData.st_address);
                    $("#edit-admission_date").val(studentData.admission_date);
                    $("#edit-id").val(studentData.st_id);
                    $("#edit-old_image").val(studentData.photo);
                    let photoUrl = studentData.photo ? studentData.photo : "assets/img/user.jpg";
                    $("#edit-st_photo").html(`
                        <img class="mt-2" id="edit-output" src="${photoUrl}" alt="Image"
                            style="width: 90px; height: 85px; border-radius: 5px;">
                    `);
                    let genderHTML = `
                        <option value="">Select Gender</option>
                        <option value="Male" ${studentData.st_gender == 'Male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${studentData.st_gender == 'Female' ? 'selected' : ''}>Female</option>
                    `;
                    $('#edit-st_gender').html(genderHTML);

                    let classHtml = '<option value="">Select Class</option>';
                    classInfos.forEach(info => {                        
                        let selected = info.class_id == studentData.class_id ? 'selected' : '';
                        classHtml += `<option value="${info.class_id}" ${selected}>${info.class_name}</option>`;
                    });

                    $('#edit-class_id').html(classHtml);

                    let groupHtml = '<option value="">Select Group</option>';
                    groupInfos.forEach(info => {                        
                        let selected = info.group_id == studentData.group_id ? 'selected' : '';
                        groupHtml += `<option value="${info.group_id}" ${selected}>${info.group_name}</option>`;
                    });
                    $('#edit-group_id').html(groupHtml);
                }
            },
            error: function() {
                alert("There was an error with the AJAX request.");
            }
        });
    }

    $(document).on('submit', '#search_student_form', function(e){
        e.preventDefault();
        const fd = new FormData(this);
        const href = $(this).attr('action');
        $.ajax({
            url: href,
            method: "POST",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(resp){
                var {students} = resp;
                let studentHtml = '';
                students.forEach(student => {                    
                    let photoUrl = student.photo ? student.photo : "assets/img/user.jpg";                 
                    studentHtml += `
                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="profile.html" class="avatar">
                                        <img src="${photoUrl}" alt="Image">
                                    </a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" onClick="handleEditBtn(${student.st_id}, 'student-edit')" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" onClick="handleDeleteBtn(${student.st_id}, 'student-delete')" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile.html">${student.st_name}</a></h4>
                                <div class="small text-muted">${student.email_id}</div>
                            </div>
                        </div>
                    `;
                });
                $('#student-grid-container').html(studentHtml);                
            },
            error: function(err){
                console.log(err);                   
            }
        });
    });


</script>