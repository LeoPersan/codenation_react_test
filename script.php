<?php
include 'config.php';
include 'autoload.php';
use LeoPersan\Codec;
use LeoPersan\Codenation;

$codenation = new Codenation($token);

$json = $codenation->getJson();
$codenation->putJsonInFile('answer.json');

$codec = new Codec($json);

// $object = $codec->getObject();
// $array = $codec->getArray();
$json = $codec->getJson();

$codenation->setJson($json);

$codenation->putJsonInFile('answer.json');

$codenation->postFileJson('answer.json');