<?php
session_start();

define ('FILE_NAME', __DIR__.'/questions.json');
define ('FILE_RESULTS', __DIR__.'/results.json');

global $lang;
$lang = @$_GET['lang'];
$lang = $lang ?: 'en';

function isJson($string) {
    json_decode($string);
    return (json_last_error() === JSON_ERROR_NONE);
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
<div class="radio"><label><input type="radio" name="{$name}" value="{$value}"> {$tag[$lang]} </label>
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
    return '<label class="control-label">'.$question['question'][$lang].':</label>&nbsp;<select class="input-xlarge" name="'.$name.'">'.$result.'</select>';
}

function getRatingQuestion($name, $question) {
    global $lang;
    return <<<RESULT
<div class="component"><div class="control-group"><label class="control-label">{$question['question'][$lang]}</label><br/>
<input id="input-id" name="{$name}" class="rating" value=10 type="number" class="rating" data-language="{$lang}" min=0 max={$question['variants']} step=1 data-size="lg" data-stars="{$question['variants']}">
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
      <textarea id="textarea-content" placeholder="..." style="width:90%" rows="8" name="{$name}"></textarea>
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
