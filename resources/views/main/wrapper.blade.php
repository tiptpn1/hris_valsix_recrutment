
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title><?=config("app.nama_aplikasi")?> | <?=config("app.nama_perusahaan")?></title>
    <base href="{{ asset('/') }}">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <base href="{{ asset('/') }}">

    <!-- Bootstrap Core CSS -->
    <link href="libraries/startbootstrap-blog-post-1.0.4/css/bootstrap.css" rel="stylesheet">
    <link href="libraries/startbootstrap-freelancer-1.0.3/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="libraries/startbootstrap-blog-post-1.0.4/css/blog-post.css" rel="stylesheet">

    <link href="css/gaya-rekrutmen.css" rel="stylesheet">
    <link href="css/entri.css" rel="stylesheet">
    <link href="css/halaman.css" rel="stylesheet" type="text/css">

</head>
<body style="overflow:hidden">

<?  
echo $content;
?>



</body>
</html>