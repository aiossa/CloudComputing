<?php
include_once __DIR__.'/func.php';

if (array_key_exists('ok', $_POST)) {
    //append to file
    $data = '';
    if (file_exists(FILE_RESULTS)) {
        $data = file_get_contents(FILE_RESULTS);
        $data .= PHP_EOL;
    }
    $result = json_encode($_POST, JSON_UNESCAPED_UNICODE);
    $data .= $result;
    file_put_contents(FILE_RESULTS, $data);

    // die
    if ($lang == 'ru') {
        echo 'Спасибо, что прошли наш опрос. Чтобы пройти опрос еще раз перейдите по <a href="/?lang='.$lang.'">ссылке</a>';
    } else {
        echo 'Thank you! To pass the survey one more time follow the <a href="/?lang='.$lang.'">link</a>';
    }
    die();
}
$data = json_decode(file_get_contents(FILE_NAME), true);
$label = $lang == 'ru' ? 'Язык' : 'Language';
$body = $label . ': <a href="/?lang=ru">Русский</a> | <a href="/?lang=en">English</a>';
foreach ($data as $name => $question) {
    $body .= '<br/>'.getQuestionBody($name, $question);
}
?>

<html>
<head>

</head>
<body>
<form method="POST" action="">
    <?php echo $body; ?>
    <br/>
    <input type="submit" value="OK" name="ok">
</form>
</body>
</html>


