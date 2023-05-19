<?php
include '../layout/header.php';
?>
<div class="col-lg-9">
    <!-- Main Content -->
    <div class="title-page">Hi, Welcome back</div>
    <div class="container main-content d-flex">
        <div class="col-md-3 card m-3 p-4 text-center d-flex align-items-center card-devices">
            <img src="<?= BASE_URL ?>assets/icons/channels.png" class="card-img-top" alt="Card Image">
            <div class="card-body">
                <h5 class="card-title" id="total-devices">0</h5>
                <p class="card-text">Total Devices</p>
            </div>
        </div>
        <div class="col-md-3 card m-3 p-4 text-center  d-flex  align-items-center card-channels">
            <img src="<?= BASE_URL ?>assets/icons/devices.png" class="card-img-top" alt="Card Image">
            <div class="card-body">
                <h5 class="card-title" id="total-channels">0</h5>
                <p class="card-text">Total Channels</p>
            </div>
        </div>
    </div>
</div>

<?php
include '../layout/footer.php';
?>  

<script src="<?php BASE_URL ?>js/dashboard.js"></script>