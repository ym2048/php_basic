<?php
// sqlite 本身没有权限控制功能，通过文件的权限来控制
$db = new SQLite3(__DIR__ . '/example.sqlite');
$ctable = <<<END
CREATE TABLE example (
      id          bigint(20) not null,
      key         varchar(500) default '' not null,
      tag         varchar(255) default '' not null,
      value       varchar(255) default '' not null,
      projectid   bigint(20)   default '0' not null,
      language    varchar(128) not null default '',
      trans       mediumtext,
      primary key (key,language)
    );
END;
try{
    $results = $db->exec($ctable);
    $results = $db->exec ('create index if not exists idx1 on example(key, language, projectid);');

}catch (\Exception $e){
    echo $e->getMessage();
}

var_dump($results);
