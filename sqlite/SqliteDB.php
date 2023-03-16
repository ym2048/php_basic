<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\DBAL\ArrayParameterType;

class SqliteDB
{
    private $con;
    private $table;


    private $projectid = 148;

    public function __construct()
    {

        $dsnParser = new DsnParser();
        $path = __DIR__ . '/example.sqlite';
        echo $path, "\n";
        $connectionParams = $dsnParser->parse("sqlite3:///$path");


        $this->con = DriverManager::getConnection($connectionParams)->createQueryBuilder();

        $this->table = 'example';

    }

    public function setParameters()
    {
        $key = '020601';
        $language = 'CN';
        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = ?')
            ->andWhere('key = ?')
            ->andWhere('language = ?')
            ->setParameters([
                0 => $this->projectid,
                1 => $key,
                2 => $language,
            ])
            ->executeQuery()
            ->fetchAssociative();

        print_r($res);
    }
    // 返回结果同上
    public function setParameterIndexNumber()
    {
        $key = '020601';
        $language = 'CN';
        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = ?')
            ->andWhere('key = ?')
            ->andWhere('language = ?')
            ->setParameter(0, $this->projectid)
            ->setParameter(1, $key)
            ->setParameter(2, $language)
            ->executeQuery()
            ->fetchAssociative();

        print_r($res);
    }

    // 返回结果同上
    public function setParameterIndexKey()
    {
        $key = '020601';
        $language = 'CN';
        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = :projectid')
            ->andWhere('key = :key')
            ->andWhere('language = :language')
            ->setParameter('npid', $this->projectid)
            ->setParameter('key', $key)
            ->setParameter('language', $language)
            ->executeQuery()
            ->fetchAssociative();

        print_r($res);
    }

    public function queryIn()
    {
        $key = '020601';
        $language = array('CN','US');

        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = :projectid')
            ->andWhere('key = :key')
            ->setParameter('projectid', $this->projectid)
            ->setParameter('key', $key)
            ->andWhere('language in (:language)')
            ->setParameter('language', $language, ArrayParameterType::STRING)
            ->executeQuery()
            ->fetchAllAssociative();

        print_r($res);

    }

/*
Array
(
    [npid] => 148
    [trans] => operationType只能为0或者1, 0-新增，1-修改
    [value] =>
)
 */
    public function selectField()
    {
        $key = '020601';
        $language = 'CN';
        $res = $this->con->select('npid,trans,value')
            ->from($this->table)
            ->where('npid = ?')
            ->andWhere('key = ?')
            ->andWhere('language = ?')
            ->setParameters([
                0 => $this->npid,
                1 => $key,
                2 => $language,
            ])
            ->executeQuery()
            // 只会返回一条数据
            ->fetchAssociative();

        print_r($res);
    }

    public function setParametersKey()
    {
        $key = '020601';
        $language = ['CN','US'];
        $res = $this->con->select('*')
            ->from($this->table)
            ->where('projectid = :projectid')
            ->andWhere('key = :key')
            ->setParameters([
                'projectid' => $this->projectid,
                'key' => $key,
            ])
            ->andWhere('language in (:language)')
            ->setParameter('language', $language, ArrayParameterType::STRING)
            ->executeQuery()
            // 返回全部数据
            ->fetchAllAssociative();

        print_r($res);
    }

}

$obj = new SqliteDB();
$obj->setParameters();
$obj->setParameterIndexNumber();
$obj->setParameterIndexKey();
$obj->queryIn();
$obj->setParametersKey();
$obj->selectField();
