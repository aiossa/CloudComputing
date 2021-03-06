<?php
session_start();

require __DIR__.'/config.php';

define ('FILE_NAME', __DIR__.'/questions.json');
define ('FILE_RESULTS', __DIR__.'/results.json');

global $lang, $pdo;

$params = [
    'dbname' . '=' . DB_NAME,
    'host' . '=' . DB_HOST,
    'port' . '=3306',
    'charset' . '=' . 'utf8'
];

$pdo = new \PDO(
    'mysql:' . implode(';', $params),
    DB_USER,
    DB_PASSWORD
);

$lang = @$_GET['lang'];
$lang = $lang ?: 'en';

function isJson($string) {
    json_decode($string);
    return (json_last_error() === JSON_ERROR_NONE);
}

function addResult($result) {
    global $pdo;
    $sql = 'INSERT INTO results (`timestamp`, `data`) VALUES (:timestamp, :data)';
    $stmt = $pdo->prepare($sql);
    $time = time();
    $stmt->bindParam('timestamp', $time);
    $stmt->bindParam('data', $result);
    $stmt->execute();
}

function getResults() {
    global $pdo;
    $sql = 'SELECT * FROM results';
    $stmt = $pdo->query($sql);
    $data = [];
    while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $data[] = json_decode($row['data'], true);
    }
    return $data;
}

function saveQuestions($questions) {
    global $pdo;
    $sql = 'UPDATE questions SET data = :data';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('data', $questions);
    $stmt->execute();
}

function getQuestions() {
    return json_decode(getRawQuestions(), true);
}

function getRawQuestions() {
    global $pdo;
    $sql = 'SELECT data FROM questions';
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $row['data'];
}

function getQuestionBody($name, $question) {
    $result = '';
    switch ($question['type']) {
        case 'radio':
            return getRadioQuestion($name, $question);
        case 'dropdown':
            return getDropdownQuestion($name, $question);
        case 'rating':
            return getRatingQuestion($name, $question);
        case 'text':
            return getTextQuestion($name, $question);
    }
    return $result;
}

function getRadioQuestion($name, $question) {
    global $lang;
    $result =  '<label class="control-label">'.$question['question'][$lang].':</label>&nbsp;' ;
    foreach ($question['variants'] as $value => $tag) {
        $result .= <<<INPUT
<div class="radio"><label><input type="radio" class="{$name}" name="{$name}" value="{$value}"> {$tag[$lang]} </label>
</div> 
INPUT;
    }

    return '<div class="controls">'.$result.'</div>' ;
}

function getDropdownQuestion($name, $question) {
    global $lang;
    $result = '';
    foreach ($question['variants'] as $value => $tag) {
        $tag = isset($tag[$lang]) ? $tag[$lang] : $tag;
        $tag = htmlspecialchars($tag);
        $result .= <<<INPUT
        <option value="{$value}">{$tag}</option>
INPUT;
    }
    return '<label class="control-label">'.$question['question'][$lang].':</label>&nbsp;<select class="input-xlarge '.$name.'" name="'.$name.'">'.$result.'</select>';
}

function getRatingQuestion($name, $question) {
    global $lang;
    return <<<RESULT
<div class="component"><div class="control-group"><label class="control-label">{$question['question'][$lang]}</label><br/>
<input id="input-id" name="{$name}" class="rating {$name}" value=10 type="number" data-language="{$lang}" min=0 max={$question['variants']} step=1 data-size="lg" data-stars="{$question['variants']}">
</div></div>
RESULT;
}

function getTextQuestion($name, $question) {

    global $lang;
    $result = '<label class="control-label">'.$question['question'][$lang].'</label>';
    $caption = $lang == 'ru' ? 'Проверка правописания' : 'Spell checking';
    $result .= <<<INPUT
    <div class="well">
      <p>
      </p>
      <textarea id="textarea-content" class="{$name}" placeholder="..." style="width:90%" rows="8" name="{$name}"></textarea>
      <div id="incorrect-word-list"></div>
    </div>
    <div class="form-actions">
      <button class="btn btn-primary btn-large" id="check-spelling">
        {$caption}
      </button>
    </div>
INPUT;

    return '<div class="component"><div class="control-group">'.$result.'</div></div>';
}
