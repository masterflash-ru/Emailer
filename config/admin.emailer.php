<?php
namespace Mf\Statpage;

use Admin\Service\JqGrid\ColModelHelper;
use Admin\Service\JqGrid\NavGridHelper;
use Zend\Json\Expr;



return [
        /*jqgrid - сетка*/
        "type" => "ijqgrid",
        "description"=>"Редактирование просто страниц и фрагментов",
        "options" => [
            "container" => "statpage",
            "caption" => "",
            "podval" => "",
            
            
            /*все что касается чтения в таблицу*/
            "read"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from statpage",
                    "PrimaryKey"=>"id",
                ],
            ],
            /*редактирование*/
            "edit"=>[
                "cache" =>[
                    "tags"=>["statpage"],
                    "keys"=>["statpage"],
                ],

                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from statpage",
                    "PrimaryKey"=>"id",
                ],

            ],
            "add"=>[
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from statpage",
                    "PrimaryKey"=>"id",
                ],
            ],
            //удаление записи
            "del"=>[
                "cache" =>[
                    "tags"=>["statpage"],
                    "keys"=>["statpage"],
                ],
                "db"=>[//плагин выборки из базы
                    "sql"=>"select * from statpage",
                    "PrimaryKey"=>"id",
                ],
            ],
            /*внешний вид*/
            "layout"=>[
                "caption" => "Редактирование просто страниц и фрагментов",
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
                    ColModelHelper::text("url",["label"=>"URL (/page/)",
                        "width"=>200,
                        //"hidden"=>true,
                        "editrules"=>[
                            "edithidden"=>true,
                        ],
                        "plugins"=>[
                            "edit"=>[
                                "translit"=>[
                                    "source"=>"name"
                                ],
                            ],
                            "add"=>[
                                "translit"=>[
                                    "source"=>"name"
                                ],
                            ],
                        ],
                       "editoptions" => ["size"=>120 ],
                    ]),
                    ColModelHelper::select("locale",
                                        ["label"=>"Язык",
                                         "editable"=>true,
                                         "width"=>80,
                                         "plugins"=>[
                                             "colModel"=>[//плагин срабатывает при генерации сетки, вызывается в помощнике сетки
                                                 "Locale"=>[]
                                             ]
                                         ]
                                        ]),
                    
                    
                    
                    
                    ColModelHelper::text("sysname",["label"=>"Системное имя","width"=>200,"editoptions" => ["size"=>120 ]]),

                    ColModelHelper::select("page_type",
                                        ["label"=>"Состояние",
                                         "editable"=>true,
                                         "width"=>200,
                                         "plugins"=>[
                                             "colModel"=>[//плагин срабатывает при генерации сетки, вызывается в помощнике сетки
                                                 Service\Admin\JqGrid\Plugin\GetStatusStatpage::class=>[]
                                             ]
                                         ]
                                        ]),
                    ColModelHelper::select("tpl",
                                        ["label"=>"Шаблон",
                                         "editable"=>true,
                                         "hidden"=>true,
                                         "editrules"=>[
                                             "edithidden"=>true
                                         ],
                                         "plugins"=>[
                                             "colModel"=>[//плагин срабатывает при генерации сетки, вызывается в помощнике сетки
                                                 Service\Admin\JqGrid\Plugin\GetTplStatpage::class=>[]
                                             ]
                                         ]
                                        ]),
                    ColModelHelper::select("layout",
                                        ["label"=>"Макет",
                                         "editable"=>true,
                                         "hidden"=>true,
                                         "editrules"=>[
                                             "edithidden"=>true
                                         ],
                                         "plugins"=>[
                                             "colModel"=>[//плагин срабатывает при генерации сетки, вызывается в помощнике сетки
                                                 Service\Admin\JqGrid\Plugin\GetLayoutStatpage::class=>[]
                                             ]
                                         ]
                                        ]),
                    
                    ColModelHelper::ckeditor("content",[
                        "label"=>"Статья полностью",
                        "plugins"=>[
                            "edit"=>[
                                "ClearContent"=>[],
                            ],
                            "add"=>[
                                "ClearContent"=>[],
                            ],
                        ],
                    ]),
                    ColModelHelper::text("lastmod",[
                        "hidden"=>true,
                        "plugins"=>[
                            "edit"=>[
                                "LastMod"=>[],
                            ],
                            "add"=>[
                                "LastMod"=>[],
                            ],
                        ],
                        ]),
                    ColModelHelper::textarea("title",["label"=>"TITLE","hidden"=>true,"editrules"=>["edithidden"=>true]]),
                    ColModelHelper::textarea("keywords",["label"=>"KEYWORDS","hidden"=>true,"editrules"=>["edithidden"=>true]]),
                    ColModelHelper::textarea("description",["label"=>"DESCRIPTION","hidden"=>true,"editrules"=>["edithidden"=>true]]),
                ColModelHelper::seo("seo_options",
                                    [
                                        "label"=>"Опции SEO",
                                        "width"=>200,
                                        "hidden"=>true,
                                        "editrules"=>[
                                            "edithidden"=>true,
                                        ],
                                    ]),
                ColModelHelper::cellActions(),
                    
                
                ],
            ],
        ],
];