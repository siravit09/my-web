<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบขออนุญาตลาหยุด</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <h1>ระบบขออนุญาตลาหยุด</h1>
    
    <!-- ฟอร์มสำหรับขอลาหยุด -->
    <form action="save_leave_request.php" method="POST">
        <label>ชื่อ:</label>
        <input type="text" name="first_name" required><br>

        <label>นามสกุล:</label>
        <input type="text" name="last_name" required><br>

        <label>สังกัด/ตำแหน่ง:</label>
        <input type="text" name="department_position"><br>

        <label>อีเมล์:</label>
        <input type="email" name="email"><br>

        <label>เบอร์โทรศัพท์:</label>
        <input type="text" name="phone_number" required><br>

        <label>ประเภทการลา:</label>
        <select name="leave_type" required>
            <option value="ลาป่วย">ลาป่วย</option>
            <option value="ลากิจ">ลากิจ</option>
            <option value="พักร้อน">พักร้อน</option>
            <option value="อื่นๆ">อื่นๆ</option>
        </select><br>

        <label>สาเหตุการลา:</label>
        <textarea name="reason" required></textarea><br>

        <label>วันที่ขอลา:</label>
        <input type="date" name="start_date" required><br>

        <label>ถึงวันที่:</label>
        <input type="date" name="end_date" required><br>

        <button type="submit">บันทึกคำขอลา</button>
    </form>

    <hr>

    <!-- ฟอร์มค้นหา -->
    <h2>ค้นหาคำขอลาหยุด</h2>
    <form method="GET">
        <label>ค้นหาด้วยชื่อ:</label>
        <input type="text" name="search_name">
        <label>ค้นหาด้วยวันที่:</label>
        <input type="date" name="search_date">
        <button type="submit">ค้นหา</button>
    </form>

    <hr>

    <!-- แสดงรายการคำขอลา -->
    <h2>รายการคำขอลาหยุด</h2>
    <table border="1">
        <tr>
            <th><a href="?sort=date_desc">วันที่บันทึก </a></th>
            <th>ชื่อ-นามสกุล</th>
            <th>ประเภทการลา</th>
            <th>วันที่ขอลา</th>
            <th>ถึงวันที่</th>
            <th>สถานะ</th>
            <th>การดำเนินการ</th>
        </tr>
        <?php include 'display_leave_requests.php'; ?>
    </table>

</body>
</html>

