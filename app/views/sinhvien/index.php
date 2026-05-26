<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 30px;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        th {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e8f4fd;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            h1 {
                font-size: 2rem;
            }
            th, td {
                padding: 12px 8px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <table>
    <tr>
        <th> STT </th>
        <th> Mã sinh viên </th>
        <th> Họ tên </th>
        <th> Giới tính </th>
        <!-- <th> Ngày sinh </th>
        <th> Địa chỉ </th> -->
        <!-- <th> Lớp </th> -->
    </tr>
    <?php foreach ($sinhviens as $index => $sinhvien): ?>
        <tr>
            <td> <?php echo $index + 1; ?> </td>
            <td> <?php echo $sinhvien['ma_sv']; ?> </td>
            <td> <?php echo $sinhvien['ho_ten']; ?> </td>
            <td> <?php echo $sinhvien['gioi_tinh']; ?> </td>
            <!-- <td> <?php echo $sinhvien['ngay_sinh']; ?> </td> -->
            <!-- <td> <?php echo $sinhvien['dia_chi']; ?> </td> -->
            <!-- <td> <?php echo $sinhvien['lop']; ?> </td> -->
        </tr>
    <?php endforeach; ?>
    </table>
    
</body>
</html>