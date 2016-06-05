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
    $sums = [];
    foreach ($data as $row) {
        $row = json_decode($row, true);
        unset($row['ok']);
        echo '<tr>';
        foreach ($row as $questionKey => $questionAnswer) {
            $question = $questions[$questionKey];
            if ($questionKey == 'design') {
                @$sums[$questionKey] += $questionAnswer;
            } else if (in_array($questionKey, [
                'sex','age','logo'
            ])) {
                @$sums[$questionKey][$questionAnswer]++;
            }
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
    $count = count($data);
    $count = $count ?: 1;
    ?>
    <tr>
        <td colspan="2" style="text-align: right;">Avg:</td>
        <td colspan="3" style="text-align: left;"><?php echo $sums['design'] / $count;?></td>
    </tr>
    </tbody>
</table>
</div>

<?php unset($sums['design']);?>

<?php
    foreach ($sums as $key => $options) {
        echo '<div id="'.$key.'" style="height: 400px"></div>';
    }
?>
<script src="/js/jquery-2.2.4.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>

    $(function () {
    <?php foreach ($sums as $key => $options):?>
        var resultData = [];
        <?php foreach ($options as $opKey => $opValue) {
            $value = $questions[$key]['variants'][$opKey];
            $value = isset($value[$lang]) ? $value[$lang] : htmlspecialchars($value);
            echo 'var currentValue=["'.$value.'",'.$opValue.']; resultData.push(currentValue);';
        }?>
        $('#<?php echo $key;?>').highcharts({
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: '<?php echo $questions[$key]['question'][$lang];?>'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            series: [{
                name: 'Answers',
                data: resultData
            }]
        });
        <?php endforeach; ?>
    });


</script>

</body>
</html>
