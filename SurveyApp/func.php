<?php
session_start();

define ('FILE_NAME', __DIR__.'/questions.json');
define ('FILE_RESULTS', __DIR__.'/results.json');

function isJson($string) {
    json_decode($string);
    return (json_last_error() === JSON_ERROR_NONE);
}

function getQuestionBody($question) {
    $result = '';
    switch ($question['type']) {
        case 'radio':
            return getRadioQuestion($question);
        case 'dropdown':
            return getDropdownQuestion($question);
        case 'rating':
            return getRatingQuestion($question);
        case 'text':
            return getTextQuestion($question);
    }
    return $result;
}

function getRadioQuestion($question) {
    global $lang;
    $result = $question['question'][$lang].':&nbsp;';
    foreach ($question['variants'] as $value => $tag) {
        $result .= <<<INPUT
{$tag[$lang]} <input type="radio" name="{$question['name']}" value="{$value}">&nbsp;
INPUT;
    }

    return $result;
}

function getDropdownQuestion($question) {
    global $lang;
    $result = '';
    foreach ($question['variants'] as $value => $tag) {
        $tag = isset($tag[$lang]) ? $tag[$lang] : $tag;
        $result .= <<<INPUT
        <option value="{$value}">{$tag}</option>
INPUT;
    }
    return $question['question'][$lang].':&nbsp;<select name="'.$question['name'].'">'.$result.'</select>';
}

function getRatingQuestion($question) {
    global $lang;
    return <<<RESULT
{$question['question'][$lang]}<br/>
<input id="input-id" name="{$question['name']}" type="number" class="rating" min=1 max={$question['variants']} step=1 data-size="lg" data-rtl="true">
RESULT;
}

function getTextQuestion($question) {

    global $lang;
    $result = $question['question'][$lang].'<br/>';
    $result .= <<<INPUT
    <textarea name="{$question['name']}"></textarea>
INPUT;

    return $result;
}
