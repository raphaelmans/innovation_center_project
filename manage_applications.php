<?php require('./templates_cms/header_cms.php') ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manage Applications</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div id="jsGrid"></div>
    </div>
</div>



<?php require('./templates_cms/footer_cms.php') ?>

<script>
    const status_enum = [{
            type: 'PENDING'
        },
        {
            type: 'ACTIVE'
        },
        {
            type: 'INACTIVE'
        },
    ]
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "400px",
        sorting: true,
        paging: true,
        autoload: true,
        editing: true,
        // inserting: true,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "manage_applications_query.php",
                    dataType: 'json',
                    data: {
                        request_method: 'get_all'
                    },
                    success: function(result) {
                        console.log(result)
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "manage_applications_query.php",
                    data: {...item,
                        request_method: 'update_one'
                    },
                    success: function(result) {
                        // location.reload();
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            },
        },
        fields: [
            {
                name: "application_id",
                title: "ID",
                type: "text",
                visible:false,
            },
            {
                name: "action",
                title: "Action",
                type: "text",
            },
            {
                name: "school_name",
                title: "School Name",
                type: "text",
                editing: false,
            },
            {
                name: "student_name",
                title: "Student Name",
                type: "text",
                editing: false,
            },
            {
                name: "specialization",
                title: "Specialization",
                type: "text",
                editing: false,
            },
            {
                title: "Application Date",
                name: "application_date",
                type: "text",
                editing: false,
            },
            {
                name: "membership_end_date",
                title: "Membership End Date",
                type: "text",
            },
            {
                name: "status",
                type: "select",
                items: status_enum,
                valueField: "type",
                textField: "type"
            },
            {
                type: "control",
                deleteButton: false
            }
        ]
    });
</script>