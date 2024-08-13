<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
    if(isset($_SESSION['warning'])){
?>
    <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> -->

    <script>
        // swal({
        //     text: "",
        //     icon: "error",
        //     button: "Okay!",
        // });

        Swal.fire({
            title: "Oops...",
            text: "<?php echo $_SESSION['warning']; ?>",
            icon: "error"
        });
    </script>
<?php
    unset($_SESSION['warning']);    
    }
?>