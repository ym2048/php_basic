<?php

$db = new SQLite3(__DIR__ . '/example.sqlite');

$results = $db->exec ('create index if not exists idx2 on words(tag, value,language);');
$results = $db->exec ('create index if not exists idx2 on words(tag, language);');

var_dump($results);


$db = new SQLite3(__DIR__ . '/example.sqlite');
// 已经创建好索引后，再执行sql不会报错
$results = $db->exec ('create index if not exists idx1 on words(key, language, npid);');
$results = $db->exec ('create index if not exists idx2 on words(tag, value,language);');
$results = $db->exec ('create index if not exists idx2 on words(tag, language);');

var_dump($results);
