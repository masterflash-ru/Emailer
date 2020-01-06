<?php
namespace Mf\Emailer;

use Admin\Service\JqGrid\ColModelHelper;
use Admin\Service\JqGrid\NavGridHelper;
use Laminas\Json\Expr;



return [
        /*jqgrid - сетка*/
        "type" => "ijqgrid",
        "description"=>"Редактирование шаблонов писем с сайта",
        "options" => [
            "container" => "emailer_tpl",
            "caption" => "",
            "podval" => "",
            
            
            /*все что касается чтения в таблицу*/
            "read"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from emailer_tpl",
                    "PrimaryKey"=>"id",
                ],
            ],
            /*редактирование*/
            "edit"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from emailer_tpl",
                    "PrimaryKey"=>"id",
                ],

            ],
            "add"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from emailer_tpl",
                    "PrimaryKey"=>"id",
                ],
            ],
            //удаление записи
            "del"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from emailer_tpl",
                    "PrimaryKey"=>"id",
                ],
            ],
            /*внешний вид*/
            "layout"=>[
                "caption" => "Редактирование шаблонов HTML писем",
                "height" => "auto",
                //"width" => "1100px",
                "rowNum" => 20,
                "rowList" => [20,50,100],
                "sortname" => "name",
                "sortorder" => "asc",
                "viewrecords" => true,
                "autoencode" => false,
                //"autowidth"=>true,
                "hidegrid" => false,
                "toppager" => true,
                "rownumbers" => false,
                "navgrid" => [
                    "button" => NavGridHelper::Button(["search"=>false]),
                    "editOptions"=>NavGridHelper::editOptions(),
                    "addOptions"=>NavGridHelper::addOptions(),
                    "delOptions"=>NavGridHelper::delOptions(),
                ],
                "colModel" => [

                    ColModelHelper::text("name",["label"=>"Имя элемента","width"=>300,"editoptions" => ["size"=>120 ]]),
                    ColModelHelper::text("sysname",["label"=>"Системное имя","width"=>200,"editoptions" => ["size"=>120 ]]),
                    ColModelHelper::textarea("tpl",[
                        "label"=>"TPL",
                        "hidden"=>true,
                        "editrules"=>["edithidden"=>true],
                        "editoptions" => [
                            "cols" => 120,
                            "rows"=>30
                        ],
                    ]),
                ColModelHelper::cellActions("my",[
                    "formatoptions"=>[
                        "editformbutton"=>true,
                    ]
                ]),
                    
                
                ],
            ],
        ],
];