<?php
include_once __DIR__.'/func.php';

global $lang;
if (array_key_exists('login', $_POST) &&
    $_POST['login'] === 'admin' &&
    $_POST['password'] === 'password_results') {
    {
        $_SESSION['results'] = true;
    }
}

if (!@$_SESSION['results']) {
    require __DIR__.'/login_form.php';
    die();
}
$file = FILE_RESULTS;

$data = [];

if (file_exists($file)) {
    $data = explode(PHP_EOL, file_get_contents($file));
}

$questions = json_decode(file_get_contents(FILE_NAME), true);
$title = $lang == 'ru' ? 'Всего проголосовало' : 'Total answers';
echo '<h1>'.$title.': '.count($data).'</h1>';
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
<div class="table-responsive">
<table class="table table-bordered table-striped" border="1">
    <thead>
    <?php foreach ($questions as $question) : ?>
    <th><?php echo $question['question'][$lang];?></th>
    <?php endforeach;?>
    </thead>
    <tbody>
    <?php
    foreach ($data as $row) {
        $row = json_decode($row, true);
        unset($row['ok']);
        echo '<tr>';
        foreach ($row as $questionKey => $questionAnswer) {
            $question = $questions[$questionKey];
            if (isset($question['variants']) && is_array($question['variants'])) {
                $variants = $question['variants'];
                $questionAnswer = $variants[$questionAnswer];
                if (is_array($questionAnswer)) {
                    $questionAnswer = $questionAnswer[$lang];
                }
            }
            echo '<td>'.$questionAnswer.'</td>';
        }
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
</div>


</body>
</html>
