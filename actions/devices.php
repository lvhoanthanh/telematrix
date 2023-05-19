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
        case 'create':
            createRecord();
            break;
        case 'read':
            readRecords();
            break;
        case 'read_one':
            readRecord();
            break;
        case 'update':
            updateRecord();
            break;
        case 'delete':
            deleteRecord();
            break;
        default:
            echo json_encode(['status' => false, 'message' => 'Invalid action']);
            break;
    }
}

// Function to create a new record
function createRecord()
{
    global $conn;

    // Get values from request parameters
    $device = $_POST['device'];
    $mac = $_POST['mac'];
    $active = 1;

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO device_info(Device, MAC, Active) VALUES(?, ?, ?)");
    $stmt->bind_param("ssi", $device, $mac, $active);
    $result = $stmt->execute();

    // Return response based on the result of query execution
    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Record created successfully.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'An error occurred while creating the record.']);
    }
}

// Function to read all records from the database
function readRecords()
{
    global $conn;

    $page = $_REQUEST['page'];
    $limit = $_REQUEST['limit'];
    $search = $_REQUEST['search'];

    // Calculate the offset based on the page and limit
    $offset = ($page - 1) * $limit;

    // Prepare and execute the SQL query with pagination
    $searchTerm = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT * FROM device_info WHERE Device LIKE ? OR MAC LIKE ? LIMIT ?, ?");
    $stmt->bind_param("ssii", $searchTerm, $searchTerm, $offset, $limit);

    $stmt->execute();

    // Fetch result set as an associative array
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);

    // Get the total number of channels
    $totalDevices = getTotalDevices($search);

    // Calculate the total number of pages
    $totalPages = ceil($totalDevices / $limit);

    // Create an associative array with the required information
    $data = array(
        'records' => $records,
        'total' => $totalDevices,
        'currentPage' => $page,
        'totalPages' => $totalPages
    );

    // Return the data as a JSON object
    echo json_encode($data);
}

function getTotalDevices($search)
{
    global $conn;
    $searchTerm = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM device_info WHERE Device LIKE ? OR MAC LIKE ?");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
}

// Function to read a single record from the database
function readRecord()
{
    global $conn;

    // Get the ID parameter from request
    $id = $_REQUEST['id'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM device_info WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Fetch result set as an associative array
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();

    // Return record as a JSON object
    echo json_encode($record);
}

// Function to update an existing record in the database
function updateRecord()
{
    global $conn;

    // Get values from request parameters
    $id = intval($_POST['id']);
    $device = $_POST['device'];
    $mac = $_POST['mac'];
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("UPDATE device_info SET Device=?, MAC=? WHERE ID=?");
    $stmt->bind_param("ssi", $device, $mac, $id);
    $result = $stmt->execute();

    // Return response based on the result of query execution
    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Record updated successfully.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'An error occurred while updated the record.']);
    }
}

function deleteRecord()
{
    global $conn;

    // Get values from request parameters
    $id = intval($_POST['id']);

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("DELETE FROM device_info WHERE ID=?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    // Return response based on the result of query execution
    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Record deleted successfully.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'An error occurred while deleted the record.']);
    }
}

// Close database connection
$conn->close();
