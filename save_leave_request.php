<?php
// ตั้งเวลาเป็นประเทศไทย
date_default_timezone_set('Asia/Bangkok');

function loadLeaveRequests() {
    $data = file_get_contents('leave_requests.json');
    return json_decode($data, true);
}

function saveLeaveRequests($requests) {
    // ใช้ JSON_UNESCAPED_UNICODE เพื่อให้ข้อมูลเป็นข้อความที่อ่านได้
    $json_data = json_encode($requests, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('leave_requests.json', $json_data);
}

function addLeaveRequest($data) {
    $requests = loadLeaveRequests();

    
    $data['id'] = isset($requests) && count($requests) > 0 ? end($requests)['id'] + 1 : 1;
    $data['date_recorded'] = date('d-m-Y H:i:s');
    $data['status'] = 'รอพิจารณา';

    
    if ($data['leave_type'] == 'พักร้อน') {
        $current_date = date('d-m-Y');
        $advance_days = (strtotime($data['start_date']) - strtotime($current_date)) / 86400; //วันที่เลือก-วันที่ปัจจุบันหารด้วย 86400วินาที
        $total_days = (strtotime($data['end_date']) - strtotime($data['start_date'])) / 86400; //วันสุดท้าย-วันที่เลือก หารด้วย86400วินาที

        if ($advance_days < 3) {
            echo "<script>alert('กรุณาลาล่วงหน้าอย่างน้อย 3 วันสำหรับพักร้อน'); window.history.back();</script>";
            return false;
        }
        if ($total_days > 1) {
            echo "<script>alert('พักร้อนลาติดต่อกันได้ไม่เกิน 2 วัน'); window.history.back();</script>";
            return false;
        }
    }

    
    if (strtotime($data['start_date']) < strtotime(date('d-m-Y'))) {
        echo "<script>alert('ไม่อนุญาตให้บันทึกวันลาย้อนหลังได้'); window.history.back();</script>";
        return false;
    }

    
    $requests[] = $data;
    saveLeaveRequests($requests);
    echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location.href = 'index.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'department_position' => $_POST['department_position'],
        'email' => $_POST['email'],
        'phone_number' => $_POST['phone_number'],
        'leave_type' => $_POST['leave_type'],
        'reason' => $_POST['reason'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date']
    ];

    addLeaveRequest($data);
}

?>

