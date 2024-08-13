<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
    if(isset($_SESSION['error'])){
?>
    <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> -->

    <script>
        // swal({
        //     text: "",
        //     icon: "",
        //     button: "Okay!",
        // });

        Swal.fire({
            title: "Oops...",
            text: "<?= $_SESSION['error']; ?>",
            icon: "<?= $_SESSION['error-code']; ?>"
        });
    </script>
<?php
    unset($_SESSION['error']);    
    }
?>