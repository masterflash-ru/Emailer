<?php

namespace Mf\Emailer;

use Mf\Migrations\AbstractMigration;
use Mf\Migrations\MigrationInterface;

class Version20191104162310 extends AbstractMigration implements MigrationInterface
{
    public static $description = "Create table for Emailer";

    public function up($schema)
    {
        switch ($this->db_type){
            case "mysql":{
                $this->addSql("CREATE TABLE `emailer_tpl` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` char(255) DEFAULT NULL,
                  `sysname` char(127) DEFAULT NULL,
                  `tpl` text,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='шаблоны для emailer'");
                break;
            }
            default:{
                throw new \Exception("the database {$this->db_type} is not supported !");
            }
        }
    }

    public function down($schema)
    {
        //throw new \RuntimeException('No way to go down!');
        switch ($this->db_type){
            case "mysql":{
                $this->addSql("DROP TABLE `emailer_tpl`");
                break;
            }
            default:{
                throw new \Exception("the database {$this->db_type} is not supported !");
            }
        }
    }
}
