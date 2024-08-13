<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
    if(isset($_SESSION['success'])){
?>
    <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> -->

    <script>
        // swal({
        //     text: "",
        //     icon: "success",
        //     button: "Okay!",
        // });

        Swal.fire({
            title: "Nice",
            text: "<?php echo $_SESSION['success']; ?>",
            icon: "success"
        });
    </script>
<?php
    unset($_SESSION['success']);    
    }
?>