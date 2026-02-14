<?php
if (isset($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>
            swal({
                title: 'Success',
                text: '$msg',
                icon: 'success'
            });
        </script>";
    }
}

if (isset($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>
            swal({
                title: 'Warning',
                text: '$msg',
                icon: 'warning'
            });
        </script>";
    }
}

if (isset($info_msg)) {
    foreach ($info_msg as $msg) {
        echo "<script>
            swal({
                title: 'Info',
                text: '$msg',
                icon: 'info'
            });
        </script>";
    }
}

if (isset($error_msg)) {
    foreach ($error_msg as $msg) {
        echo "<script>
            swal({
                title: 'Error',
                text: '$msg',
                icon: 'error'
            });
        </script>";
    }
}
?>
<?php if(!empty($success_msg)) { ?>
<script>
<?php foreach($success_msg as $msg){ ?>
    swal({
        title: "Success!",
        text: "<?= $msg ?>",
        icon: "success",
        button: "OK",
    });
<?php } ?>
</script>
<?php } ?>