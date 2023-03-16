<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

class MaxFetchLines
{
    private $con;
    private $table;


    private $projectid = 6;

    public function __construct()
    {

        $dsnParser = new DsnParser();
        $path = __DIR__ . "/example.sqlite";
        echo $path, "\n";
        $connectionParams = $dsnParser->parse("sqlite3:///$path");


        $this->con = DriverManager::getConnection($connectionParams)->createQueryBuilder();

        $this->table = 'example';

    }

    public function fetch($limit)
    {
        $offset = 0;
        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = ?')
            ->setParameters([
                0 => $this->projectid,
            ])
            // 设置 offset
            ->setFirstResult($offset)
            // 设置 limit
            ->setMaxResults($limit)
            ->executeQuery()

            // 获取单条数据
            // ->fetchAssociative()
            // 获取多条数据
            ->fetchAllAssociative();

        echo count($res),"\n";
    }

}
// 从测试来看，返回数据条数似乎没有上限，取决于内存大小，
// 单次返回数据条数最大可以达到 9万条,然后就因为内存不足报错了
$obj = new MaxFetchLines();

if(!isset($argv[1])){
    echo "miss limit parameter \n";

}else{
    $limit = $argv[1];
    $obj->fetch($limit);
}


