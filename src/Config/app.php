<?php

return [
    'providers' => [
        Kwaadpepper\ResponsiveFileManager\FileManagerServiceProvider::class
    ],
    'aliases' => [
        'PhareSpase' => \App\Lib\PhareSpase::class,
        'MenuApp' => \App\Lib\ModulApp::class,
        'DataTables' => Yajra\DataTables\DataTablesServiceProvider::class,

        'Tmparamtertr' => \Ismarianto\Ismarianto\Lib\Tmparamtertr::class
    ],
];
