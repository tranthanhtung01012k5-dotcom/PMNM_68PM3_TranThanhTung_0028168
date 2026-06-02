<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Radio buttons */
        .gender-options {
            display: flex;
            gap: 25px;
            margin-top: 8px;
        }

        .gender-option {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thêm Sinh Viên</h1>
        
        <form action="/sinhvien/store" method="post">
            <div class="form-group">
                <label for="ma_sv">Mã sinh viên</label>
                <input type="text" id="ma_sv" name="ma_sv" placeholder="VD: SV001" required>
            </div>

            <div class="form-group">
                <label for="ho_ten">Họ và tên</label>
                <input type="text" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên sinh viên" required>
            </div>

            <div class="form-group">
                <label>Giới tính</label>
                <div class="gender-options">
                    <label class="gender-option">
                        <input type="radio" name="gioi_tinh" value="Nam" required>
                        Nam
                    </label>
                    <label class="gender-option">
                        <input type="radio" name="gioi_tinh" value="Nữ">
                        Nữ
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="ngay_sinh">Ngày sinh</label>
                <input type="date" id="ngay_sinh" name="ngay_sinh" required>
            </div>

            <div class="form-group">
                <label for="dia_chi">Địa chỉ</label>
                <input type="text" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
            </div>

            <div class="form-group">
                <label for="lop">Lớp</label>
                <input type="text" id="lop" name="lop" placeholder="VD: CNTT21" required>
            </div>

            <button type="submit">Thêm Sinh Viên</button>
        </form>
    </div>
</body>
</html>