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
<table border="1">
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
