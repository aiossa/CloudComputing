<?php
include_once __DIR__.'/func.php';

if (array_key_exists('login', $_POST) &&
    $_POST['login'] === 'admin' &&
    $_POST['password'] === 'password_questions') {
    {
        $_SESSION['questions'] = true;
    }
}

if (!@$_SESSION['questions']) {
    require __DIR__.'/login_form.php';
    die();
}

$file = FILE_NAME;

if (array_key_exists('file', $_POST)) {
    $post = $_POST['file'];
    if (isJson($post)) {
        saveQuestions($post);
    } else {
        echo '<H1>Error parsing json. Please, check again</H1>';
    }
    $data = $post;
} else {
    $data = getRawQuestions();
}
?>
<html>
<head>
    <meta charset="utf-8">
<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootsnipp.min.css?ver=7d23ff901039aef6293954d33d23c066">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/docs.min.css" rel="stylesheet">
</head>
<body>
<form method="POST" action="">
<textarea class="form-control" rows="40" style="width: 95%; padding: 10px; margin: 10px; height: 500px;" name="file">
<?php echo $data;?>
</textarea>
<br/>
<input type="submit" class="btn btn-success" name="ok" value="OK"><input class="btn btn-warning" type="button" value="Cancel">
</form>
</body>
</html>


