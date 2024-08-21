<?php
function loadLeaveRequests() {
    $data = file_get_contents('leave_requests.json');
    return json_decode($data, true);
}

function saveLeaveRequests($requests) {
    $json_data = json_encode($requests, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('leave_requests.json', $json_data);
}

if (isset($_GET['id'])) {
    $requests = loadLeaveRequests();
    $id = $_GET['id'];
    $requests = array_filter($requests, function($request) use ($id) {
        return $request['id'] != $id;
    });

    saveLeaveRequests(array_values($requests));
    echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location.href = 'index.php';</script>";
}
?>
