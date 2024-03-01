<?php

namespace models;

use DB\Cortex;

class school extends Cortex
{
    protected
        $db = 'DB',
        $table = 'school';

    protected $fieldConf = [
        'name'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'address'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'praxeDate'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'field'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'focus'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'class'=>['type'=>'VARCHAR256', 'nullable'=>false],
        'note'=>['type'=>'VARCHAR256', 'nullable'=>false],
    ];

}