<?php require('./templates_cms/header_cms.php') ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pending Applications</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>School Name</th>
                        <th>Student Name</th>
                        <th>Specialization</th>
                        <th>Application Date</th>
                        <th>Approval Count</th>
                        <th>GWA</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
               
                    if($_SESSION['role'] == 'SPECIALIST'){
                        $spec_id = $_SESSION['specialist_id'];
                        $specialization = $_SESSION['specialization'];
                        $query = "SELECT * FROM application INNER JOIN student ON application.student_id = student.student_id WHERE application.status = 'PENDING' AND application.specialization = '$specialization'";
                    }else{
                        $query = "SELECT * FROM application INNER JOIN student ON application.student_id = student.student_id WHERE application.status = 'PENDING'";
                    }
                    $result = mysqli_query($conn, $query);
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $app_id = $row['application_id'];
                            $count_approval_query = "SELECT COUNT(*) as total FROM application_approval WHERE application_id=$app_id";
                            $count_result = mysqli_query($conn, $count_approval_query);
                            $count_total = 0;
                            if($count_result->num_rows > 0){
                                $count_row = mysqli_fetch_assoc($count_result);
                                $count_total = $count_row['total'];
                            }
                            $student_id = $row['student_id'];
                            echo "
                            <tr>
                                <td>" . $row['school_name'] . "</td>
                                <td>" . $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'] . "</td>
                                <td>" . $row['specialization'] . "</td>
                                <td>" . $row['application_date'] . "</td>
                                <td>" . $count_total . "</td>
                                <td>" . $row['gwa'] . "</td>
                                <td class='action-td'>
                                    <button class='btn btn-primary btn-circle' data-toggle='modal' data-target='#viewApplicantData' onclick='getData($app_id,$student_id)'><i class='fa fa-eye' aria-hidden='true'></i> </button>
                                    <form action='applications_query.php' method='POST'>
                                    <input type='hidden' name='application_id' value='$app_id'>
                                    <input type='hidden' name='approval_count' value='$count_total'>
                                    <input type='hidden' name='req_method' value='PUT'>";
                            if ($_SESSION['role'] == 'SPECIALIST') {
                                $spec_id = $_SESSION['specialist_id'];
                                echo  "
                                <input type='hidden' name='specialist_id' value='$spec_id'>
                                <button type='submit' class='btn btn-success btn-circle'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";
                            }
                            echo "</form>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="viewApplicantData" tabindex="-1" role="dialog" aria-labelledby="viewApplicantDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewApplicantDataLabel">Applicant Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id='first_data'>
                            <div class="col-md-12">
                                <label class='text-info'>School Name</label>
                                <p class='font-weight-bold' id='school_name'></p>
                            </div>
                            <div class="col-md-4">
                                <label class='text-info'>First Name</label>
                                <p class='font-weight-bold' id='first_name'></p>
                            </div>
                            <div class="col-md-2">
                                <label class='text-info'>M.I.</label>
                                <p class='font-weight-bold' id='middle_initial'></p>
                            </div>
                            <div class="col-md-4">
                                <label class='text-info'>Last Name</label>
                                <p class='font-weight-bold' id='last_name'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Phone Number</label>
                                <p class='font-weight-bold' id='phone_number'></p>
                            </div>
                            <div class="col-md-12">
                                <hr />
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>City</label>
                                <p class='font-weight-bold' id='city'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Province</label>
                                <p class='font-weight-bold' id='province'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Country</label>
                                <p class='font-weight-bold' id='country'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Zip Code</label>
                                <p class='font-weight-bold' id='zip_code'></p>
                            </div>
                        </div>

                        <div class="row" id='second_data' style="display:none">
                            <div class="col-md-12">
                                <label class='text-info'>Specialization</label>
                                <p class='font-weight-bold' id='specialization'></p>
                            </div>
                            <div class="col-md-12">
                                <label class='text-info'>GWA</label>
                                <p class='font-weight-bold' id='gwa'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Approval Count</label>
                                <p class='font-weight-bold' id='approval_count'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Status</label>
                                <p class='font-weight-bold' id='status'></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Application Date</label>
                                <p class='font-weight-bold' id='application_date'></p>
                            </div>
                            <div class="col-md-12">

                                <hr />
                            </div>
                            <div class="col-md-12">
                                <label class='text-info'>Academic Honors</label>
                                <p class='font-weight-bold' id='academic_honors'>

                                </p>
                            </div>
                            <div class="col-md-12">
                                <label class='text-info'>Community Activities</label>
                                <p class='font-weight-bold' id='community_activities'>

                                </p>
                            </div>
                            <div class="col-md-12">
                                <label class='text-info'>ExtraCurricular Activities</label>
                                <p class='font-weight-bold' id='extracurricular_activities'>

                                </p>
                            </div>
                            <div class="col-md-12">
                                <label class='text-info'>Scholarship Awarded</label>
                                <p class='font-weight-bold' id='scholarship_awarded'>

                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="changeView()" id='buttonView'>View Application Information</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require('./templates_cms/footer_cms.php') ?>
<script>
    var viewOne = true;

    function changeView() {
        if (viewOne) {
            $('#first_data').hide();
            $('#second_data').show();
            $('#buttonView').html('View Personal Information');
        } else {
            $('#first_data').show();
            $('#second_data').hide();
            $('#buttonView').html('View Application Information');
        }
        viewOne = !viewOne;
    }

    function getRowData(app_id, student_id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: "applications_query.php",
                data: {
                    request_method: 'get_one',
                    application_id: app_id,
                    student_id: student_id
                },
                success: function(result) {
                    resolve(result)
                },
                error: function(err) {
                    reject(err)
                }
            });
        })
    }

    function getData(app_id, student_id) {
        getRowData(app_id, student_id).then(data => {
            console.log(data);
            $('#school_name').html(data.school_name);
            $('#first_name').html(data.first_name);
            $('#middle_initial').html(data.middle_initial);
            $('#last_name').html(data.last_name);
            $('#phone_number').html(data.phone_number);
            $('#city').html(data.city);
            $('#province').html(data.province);
            $('#country').html(data.country);
            $('#zip_code').html(data.zip_code);
            $('#specialization').html(data.specialization);
            $('#approval_count').html(data.approval_count);
            $('#status').html(data.status);
            $('#application_date').html(data.application_date);
            $('#gwa').html(data.gwa);
            const acads = data.acads.map(elem => elem.academic_honors).join(', ');
            $('#academic_honors').html(acads);
            const comms = data.comms.map(elem => elem.community_activities).join(', ');
            $('#community_activities').html(comms);
            const extras = data.extras.map(elem => elem.extracurricular_activities).join(', ');
            $('#extracurricular_activities').html(extras);
            const scholars = data.scholars.map(elem => elem.scholarship_awarded).join(', ');
            $('#scholarship_awarded').html(scholars);
        }).catch(err => console.log(err));
    }

</script>