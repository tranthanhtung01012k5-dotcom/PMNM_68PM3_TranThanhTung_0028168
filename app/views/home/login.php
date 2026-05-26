<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4f46e5, #7c3aed, #9333ea);
            overflow: hidden;
        }

        /* Background blur circles */
        .bg-circle{
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
        }

        .circle1{
            width: 300px;
            height: 300px;
            background: #ffffff;
            top: -80px;
            left: -80px;
        }

        .circle2{
            width: 250px;
            height: 250px;
            background: #c084fc;
            bottom: -60px;
            right: -60px;
        }

        .login-container{
            position: relative;
            width: 380px;
            padding: 40px;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn{
            from{
                opacity: 0;
                transform: translateY(30px);
            }
            to{
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h1{
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: 600;
        }

        .input-group{
            margin-bottom: 22px;
        }

        .input-group label{
            display: block;
            margin-bottom: 8px;
            color: #f3f4f6;
            font-size: 14px;
        }

        .input-group input{
            width: 100%;
            padding: 14px 16px;
            border: none;
            border-radius: 14px;
            outline: none;
            background: rgba(255,255,255,0.18);
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder{
            color: rgba(255,255,255,0.7);
        }

        .input-group input:focus{
            background: rgba(255,255,255,0.28);
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.15);
        }

        .login-btn{
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 14px;
            background: white;
            color: #6d28d9;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover{
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            background: #f3f4f6;
        }

        .extra{
            margin-top: 20px;
            text-align: center;
            color: white;
            font-size: 14px;
        }

        .extra a{
            color: #ffffff;
            font-weight: 500;
            text-decoration: none;
        }

        .extra a:hover{
            text-decoration: underline;
        }

        @media(max-width: 450px){
            .login-container{
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="bg-circle circle1"></div>
    <div class="bg-circle circle2"></div>

    <div class="login-container">

        <h1>Đăng nhập</h1>

        <form action="/auth/login" method="post">

            <div class="input-group">
                <label>Tên đăng nhập</label>
                <input 
                    type="text" 
                    name="username"
                    placeholder="Nhập tên đăng nhập"
                    required
                >
            </div>

            <div class="input-group">
                <label>Mật khẩu</label>
                <input 
                    type="password" 
                    name="password"
                    placeholder="Nhập mật khẩu"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                Đăng nhập
            </button>

        </form>

        <div class="extra">
            Chưa có tài khoản? <a href="#">Đăng ký</a>
        </div>

    </div>

</body>
</html>