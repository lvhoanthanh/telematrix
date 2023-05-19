<?php
require_once('../constant.php');
// Establish database connection

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the action parameter exists
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    // Perform action based on the value of the action parameter
    switch ($action) {
        case 'countTotal':
            getTotalChannels();
            break;
        default:
            echo json_encode(['status' => false, 'message' => 'Invalid action']);
            break;
    }
}

// Function to get the total number of channels
function getTotalChannels()
{
    global $conn;
    $stmt_channel = $conn->prepare("SELECT COUNT(*) AS total FROM tv_channels");
    $stmt_channel->execute();
    $result_channel = $stmt_channel->get_result();
    $row_channel = $result_channel->fetch_assoc();

    $stmt_device = $conn->prepare("SELECT COUNT(*) AS total FROM device_info");
    $stmt_device->execute();
    $result_device = $stmt_device->get_result();
    $row_device = $result_device->fetch_assoc();

    $data = array(
        'total_devices' => $row_device['total'],
        'total_channels' => $row_channel['total']   ,
    );

    // Return the data as a JSON object
    echo json_encode($data);
}

// Close database connection
$conn->close();
