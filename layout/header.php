<?php
require_once('../constant.php');
require_once('../utils.php');
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= convertToTitleCase(get_page_name()) ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= BASE_URL . 'css/admin.css' ?>">
  <!-- Constants for JS -->
  <script>
    const BASE_URL_JS = '<?= BASE_URL ?>';
    // Define the day and month names
    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    function updateDateTime() {
      // Get the current date and time
      var now = new Date();

      // Convert the date and time to the desired format
      var dayOfWeek = days[now.getDay()];
      var month = months[now.getMonth()];
      var dayOfMonth = ('0' + now.getDate()).slice(-2);
      var hours = ('0' + now.getHours()).slice(-2);
      var minutes = ('0' + now.getMinutes()).slice(-2);
      var seconds = ('0' + now.getSeconds()).slice(-2);

      // Display the date and time on the webpage
      var dateTimeString = dayOfWeek + " " + month + " " + dayOfMonth + " " + hours + ":" + minutes + ":" + seconds;
      document.getElementById("currentDateTime").innerHTML = dateTimeString;
    }

    // Update the date and time every second
    setInterval(updateDateTime, 1000);
  </script>
</head>

<body>
  <div id="alert-messages">
    <!--  This is a alert message! -->
  </div>

  <div id="loader" class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <!-- Navigation Bar -->

  <div class="container-fluid">

    <div id="currentDateTime"></div>
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none">
      <div class="col-xs-3 text-center ">
        <a class="navbar-brand" href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>assets/images/Logo.png" /></a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav d-lg-none">
          <li class="nav-item <?php if (get_page_name() == 'index.php') echo 'active'; ?>">
            <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'index.php') ? 'dashboard_active.png' : 'dashboard_inactive.png' ?>" />
              Dashboard
            </a>
          </li>
          <li class="nav-item <?php if (get_page_name() == 'devices.php') echo 'active'; ?>">
            <a class="nav-link" href="<?= BASE_URL . 'devices' ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'devices.php') ? 'devices_active.png' : 'devices_inactive.png' ?>" />
              Devices
            </a>
          </li>
          <li class="nav-item <?php if (get_page_name() == 'channels.php') echo 'active'; ?>">
            <a class="nav-link" href="<?= BASE_URL . 'channels' ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'channels.php') ? 'channels_active.png' : 'channels_inactive.png' ?>" />
              Channels
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid row ">
      <div class="col-md-3 d-none d-lg-block side-bar-custom">
        <div class="col-md-12 text-center mb-5 p-2 mt-2">
          <a class="navbar-brand" href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>assets/images/Logo.png" /></a>
        </div>
        <!-- Sidebar -->
        <ul class="list-group ">
          <li class="list-group-item <?php if (get_page_name() == 'index.php') echo 'active'; ?>" aria-current="true">
            <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'index.php') ? 'dashboard_active.png' : 'dashboard_inactive.png' ?>" />
              Dashboard
            </a>
          </li>
          <li class="list-group-item <?php if (get_page_name() == 'devices.php') echo 'active'; ?>">
            <a class="nav-link" href="<?= BASE_URL . 'devices' ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'devices.php') ? 'devices_active.png' : 'devices_inactive.png' ?>" />
              Devices
            </a>
          </li>
          <li class="list-group-item <?php if (get_page_name() == 'channels.php') echo 'active'; ?>">
            <a class="nav-link" href="<?= BASE_URL . 'channels' ?>">
              <img src="<?= BASE_URL ?>assets/icons/<?= (get_page_name() == 'channels.php') ? 'channels_active.png' : 'channels_inactive.png' ?>" />
              Channels
            </a>
          </li>
        </ul>
      </div>