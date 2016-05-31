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

$data = '[]';

if (array_key_exists('file', $_POST)) {
    $post = $_POST['file'];
    if (isJson($post)) {
        file_put_contents($file, $post);
    } else {
        echo '<H1>Error parsing json. Please, check again</H1>';
    }
    $data = $post;
} elseif (file_exists($file)) {
    $data = file_get_contents($file);
}

?>

<form method="POST" action="">
<textarea rows="40" style="width: 100%; padding: 10px; margin: 10px; height: 500px;" name="file">
<?php echo $data;?>
</textarea>
<br/>
<input type="submit" name="ok" value="OK"><input type="button" value="Cancel">
</form>


