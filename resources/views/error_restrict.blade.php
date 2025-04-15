<!DOCTYPE html>
<html lang="en">

<head>
    <title>Access Denied</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <base href="{{ asset('/') }}">
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css2?family=Titan+One&display=swap");

        html {
            width: 100%;
            height: 100vh;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            box-sizing: border-box;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: #fff;
            line-height: 0.7;
        }

        .icon {
            margin-top: 50px;
        }

        .error-message {
            font-family: 'Calibri';
            color: #575757;
            width: 50%;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-back {
            font-family: 'Calibri';
            background-color: #FF912B;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .btn-back:hover {
            background-color: #FF7536;
            color: white;
        }
    </style>
</head>

<body>
    <div class="icon">
        <img src="images/error-page.png" width="*" >
    </div>
    <div class="error-message">
        <span>
            <h2>Access Denied</h2>
            You don't have permissions to access this page.<br><br>
            Contact an administrator to get permissions or go to the home page and browse other pages.
        </span>
    </div>
    <button class="btn-back" onclick="kembali()">KEMBALI</button>

    <script>
        function kembali() {
            window.history.back();
        }
    </script>
</body>

</html>
