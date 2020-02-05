<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelMake extends ModelMakeCommand
{
    /**
     * Prefix default root namepsace with the appropriate 'Models/' folder
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Models";
    }
}
