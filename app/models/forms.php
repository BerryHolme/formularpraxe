<?php

namespace models;

use DB\Cortex;

class forms extends Cortex
{
    protected
        $db = 'DB',
        $table = 'forms';

    protected $fieldConf = [
        'id' =>['type'=>'INT4', 'nullable'=>false],
        'name' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'surname' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'id_number' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'phone' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'email' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyName' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyICO' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyAddress' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyPhone' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyRepresentativeName' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyRepresentativeSurname' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyMasterName' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyMasterSurname' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'companyMasterPhone' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'Activity' =>['type'=>'VARCHAR256', 'nullable'=>false],
        'Place' =>['type'=>'VARCHAR256', 'nullable'=>false],
    ];

}