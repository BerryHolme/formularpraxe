<?php

namespace controllers;

use models\forms;

class index
{
    public function index(\Base $base)
    {
        echo \Template::instance()->render("index.html");
    }

    public function install(\Base $base)
    {
        \models\forms::setdown();
        \models\forms::setup();

        \models\school::setdown();
        \models\school::setup();

        echo "Databáze vytvořena";
    }

}