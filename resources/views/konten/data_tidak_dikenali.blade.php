

<style type="text/css">
        @import url("https://fonts.googleapis.com/css2?family=Titan+One&display=swap");

        html {
            width: 100%;
            height: 100vh;
        }


        .icon {
            margin-top: 50px;
        }

        .error-message {
            font-family: 'Calibri';
            color: #575757;
            width: 100%;
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
    
<div class="<?=($auth->userPelamarId == "") ? "col-sm-12" : "col-sm-8 col-sm-pull-4"?>" style="text-align: center;">
    <div class="icon">
        <img src="images/error-page.png" width="*" >
    </div>
    <div class="error-message">
        <span>
            <h2><?php echo $heading; ?></h2>
            <?php echo $message; ?>
        </span>
    </div>
    <button class="btn-back" onclick="kembali()">KEMBALI</button>

    <script>
        function kembali() {
            window.history.back();
        }
    </script>
</div>