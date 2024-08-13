<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
    if(isset($_SESSION['message'])){
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
            text: "<?= $_SESSION['message']; ?>",
            icon: "success"
        });
    </script>
<?php
    unset($_SESSION['message']);    
    }
?>