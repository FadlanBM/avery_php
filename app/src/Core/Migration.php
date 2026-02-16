<?php

namespace App\Core;

interface Migration
{
    public function up();
    public function down();
}
