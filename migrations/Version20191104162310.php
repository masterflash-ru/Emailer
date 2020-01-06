<?php

namespace Mf\Emailer;

use Mf\Migrations\AbstractMigration;
use Mf\Migrations\MigrationInterface;
use Laminas\Db\Sql\Ddl;

class Version20191104162310 extends AbstractMigration implements MigrationInterface
{
    public static $description = "Create table for Emailer";

    public function up($schema, $adapter)
    {
        $this->mysql_add_create_table=" ENGINE=MyIsam DEFAULT CHARSET=utf8";
        $table = new Ddl\CreateTable("emailer_tpl");
        $table->addColumn(new Ddl\Column\Integer('id',false,null,["AUTO_INCREMENT"=>true]));
        $table->addColumn(new Ddl\Column\Char('sysname', 50,false,null,["COMMENT"=>"Системное имя элемента"]));
        $table->addColumn(new Ddl\Column\Char('name', 50,false,null,["COMMENT"=>"Имя элемента в админке"]));
        $table->addColumn(new Ddl\Column\Text('tpl', null,false));

        $table->addConstraint(
            new Ddl\Constraint\PrimaryKey(['id'])
        );
        $this->addSql($table);
    }

    public function down($schema, $adapter)
    {
        $drop = new Ddl\DropTable('emailer_tpl');
        $this->addSql($drop);
    }
}
