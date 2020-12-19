<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class TestmakeFacade extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自定义命令测试';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/facade.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\facades';
    }

}
