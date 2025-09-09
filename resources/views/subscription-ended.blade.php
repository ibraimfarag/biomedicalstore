<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>انتهاء الاشتراك</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8d7da 60%, #fff 100%);
            color: #721c24;
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card a {
            margin-bottom: 50px;
        }
        .card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px #d32f2f33;
            padding: 40px 32px 80px 32px;
            max-width: 370px;
            width: 100%;
            text-align: center;
            position: relative;
        }

        .icon {
            font-size: 54px;
            color: #d32f2f;
            margin-bottom: 18px;
            animation: shake 1.2s infinite alternate;
        }

        @keyframes shake {
            0% {
                transform: rotate(-6deg);
            }

            100% {
                transform: rotate(6deg);
            }
        }

        .title {
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 12px;
            color: #d32f2f;
        }

        .desc {
            font-size: 18px;
            margin-bottom: 50px;
            color: #721c24;
        }

        .contact-btn {
            background: linear-gradient(90deg, #d32f2f 70%, #b71c1c 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 17px;
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px #d32f2f22;
            transition: background 0.2s;
            text-decoration: none;
        }

        .contact-btn:hover {
            background: linear-gradient(90deg, #b71c1c 70%, #d32f2f 100%);
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="icon">&#9888;&#65039;</div>
        <div class="title">انتهاء الاشتراك</div>
        <div class="desc">نأسف، لقد انتهى الاشتراك في الموقع.<br>يرجى التواصل مع المطور لتجديد الاشتراك.</div>
        <a href="https://wa.me/201150529992" class="contact-btn" target="_blank" rel="noopener">تواصل عبر الواتساب</a>
    </div>
</body>

</html>