<?php require('./templates_cms/header_cms.php') ?>
<?php 

   if($_SESSION['role'] != 'ADMIN'){
    echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
   }

?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manage Admins</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div id="jsGrid"></div>
    </div>
</div>



<?php require('./templates_cms/footer_cms.php') ?>

<script>
    const pos_enums = [
        {
            role: 'SPECIALIST'
        },
        {
            role: 'STAFF'
        },
    ]
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "400px",

        sorting: true,
        paging: true,
        autoload: true,
        inserting: true,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "admins_query.php",
                    dataType: 'json',
                    data: {
                        request_method: 'get_all'
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "admins_query.php",
                    data: {
                        ...item,
                        request_method: 'delete_one'
                    }
                });
            },
            insertItem: function(item) {
                console.log(item);
                return $.ajax({
                    type: "POST",
                    url: "admins_query.php",
                    data: {
                        ...item,
                        request_method: 'insert'
                    },
                    success: function(result) {
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            },
        },
        fields: [{
                name: "email",
                title: "Email",
                type: "text",
                width: 'auto'
            },
            {
                name: "password",
                title: "password",
                type: "text",
            },
            {
                name: "first_name",
                title: "First Name",
                type: "text",
                width: 'auto'
            },
            {
                title: "Middle Initial",
                name: "middle_initial",
                type: "text",
            },
            {
                name: "last_name",
                title: "Last Name",
                type: "text",
                width: 'auto'
            },
            {
                title: "Phone Number",
                name: "phone_number",
                type: "text",
                width: 'auto'
            },
            {
                title: 'Role',
                name: "role",
                type: "select",
                items: pos_enums,
                valueField: "role",
                textField: "role",
                width: 'auto'
            },
            {
                name: "specialization",
                title: "Department",
                type: "text",
                width: 'auto'
            },
            {
                type: "control",
                editButton: false
            }
        ]
    });
</script>