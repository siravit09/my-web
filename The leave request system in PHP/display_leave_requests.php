<?php
function loadLeaveRequests() {
    $data = file_get_contents('leave_requests.json');
    return json_decode($data, true);
}

$requests = loadLeaveRequests();

// ส่วนของการค้นหา
if (isset($_GET['search_name']) && $_GET['search_name'] != '') {
    $search_name = $_GET['search_name'];
    $requests = array_filter($requests, function($request) use ($search_name) {
        return stripos($request['first_name'], $search_name) !== false || stripos($request['last_name'], $search_name) !== false;
    });
}

if (isset($_GET['search_date']) && $_GET['search_date'] != '') {
    $search_date = $_GET['search_date'];
    $requests = array_filter($requests, function($request) use ($search_date) {
        return $request['start_date'] == $search_date || $request['end_date'] == $search_date;
    });
}

// เรียงลำดับตามวันเวลาที่บันทึก
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'date_desc') {
        usort($requests, function($a, $b) {
            return strtotime($b['date_recorded']) - strtotime($a['date_recorded']);
        });
    } elseif ($_GET['sort'] == 'date_asc') {
        usort($requests, function($a, $b) {
            return strtotime($a['date_recorded']) - strtotime($b['date_recorded']);
        });
    }
}

// แสดงข้อมูลในตาราง
if (count($requests) > 0) {
    foreach ($requests as $request) {
        echo "<tr>";
        echo "<td>{$request['date_recorded']}</td>";
        echo "<td>{$request['first_name']} {$request['last_name']}</td>";
        echo "<td>{$request['leave_type']}</td>";
        echo "<td>{$request['start_date']}</td>";
        echo "<td>{$request['end_date']}</td>";
        echo "<td>{$request['status']}</td>";
        echo "<td>";
        if ($request['status'] == 'รอพิจารณา') {
            echo "<a href='edit_status.php?id={$request['id']}'>พิจารณา</a> | ";
        }
        echo "<a href='delete_request.php?id={$request['id']}' onclick='return confirm(\"คุณต้องการลบคำขอนี้หรือไม่?\");'>ลบ</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>ไม่มีข้อมูล</td></tr>";
}

?>
