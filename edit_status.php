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

    foreach ($requests as &$request) {
        if ($request['id'] == $id && $request['status'] == 'รอพิจารณา') {
            if (isset($_POST['status'])) {
                $request['status'] = $_POST['status'];
                saveLeaveRequests($requests);
                echo "<script>alert('ปรับสถานะสำเร็จ'); window.location.href = 'index.php';</script>";
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิจารณาคำขอลาหยุด</title>
</head>
<body>
    <h1>พิจารณาคำขอลาหยุด</h1>
    <form method="POST">
        <label>สถานะ:</label>
        <select name="status">
            <option value="อนุมัติ">อนุมัติ</option>
            <option value="ไม่อนุมัติ">ไม่อนุมัติ</option>
        </select>
        <button type="submit">บันทึกการพิจารณา</button>
    </form>
</body>
</html>
