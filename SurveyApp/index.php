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
if ($lang == 'ru') {
	$title = '';
} else {
	$title = '';
}
$data = json_decode(file_get_contents(FILE_NAME), true);
$label = $lang == 'ru' ? 'Язык' : 'Language';
$body = '<label class="control-label">'.$label .'</label>'. ': <label class="control-label"><a href="/?lang=ru">Русский</a></label> | <label class="control-label"><a href="/?lang=en">English</a></label>';
foreach ($data as $name => $question) {
    $body .= getQuestionBody($name, $question);
}
?>

<html>
<head>
    <meta charset="utf-8">
<!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/bootsnipp.min.css?ver=7d23ff901039aef6293954d33d23c066">
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/css/docs.min.css" rel="stylesheet">
	<link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
	
</head>
<body>
<div class="container bs-docs-container"> 
<h1><?php echo $title;?></h1>
<form name="myform" method="POST" action="">
    <?php echo $body; ?>
    <br/>
    <input class="btn btn-success" type="submit" value="OK" name="ok">
</form> 
</div>
	<script src="/js/jquery-2.2.4.js"></script>
	<script src="/js/star-rating.js"></script>
	<script src="/js/star-rating_locale_<?php global $lang; echo $lang;?>.js"></script>
	<script type="text/javascript" src="speller/spell.js"></script>
	<script type="text/javascript">
	var speller = new Speller({ url:"speller", lang:"en", options:Speller.IGNORE_URLS });
	 
	function spellCheck() {
		var form = document.forms["myform"];
		speller.check([ form.ctrl_1, form.ctrl_2, ..., form.ctrl_N ]);
	}
	</script>
</body>
</html>


