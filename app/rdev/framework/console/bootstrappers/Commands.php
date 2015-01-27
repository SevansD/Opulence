<?php
/**
 * Copyright (C) 2015 David Young
 *
 * Defines the command bootstrapper
 */
namespace RDev\Framework\Console\Bootstrappers;
use RDev\Applications\Bootstrappers;
use RDev\Console\Commands as ConsoleCommands;
use RDev\Console\Commands\Compilers;
use RDev\IoC;

class Commands extends Bootstrappers\Bootstrapper
{
    /** @var array The list of built-in command classes */
    private static $commandClasses = [
        "RDev\\Framework\\Console\\Commands\\AppEnvironment",
        "RDev\\Framework\\Console\\Commands\\FlushViewCache",
        "RDev\\Framework\\Console\\Commands\\RenameApp"
    ];
    /** @var ConsoleCommands\Commands The list of console commands */
    private $commands = null;

    /**
     * {@inheritdoc}
     */
    public function registerBindings(IoC\IContainer $container)
    {
        $compiler = new Compilers\Compiler();
        $container->bind("RDev\\Console\\Commands\\Compilers\\ICompiler", $compiler);
        $this->commands = new ConsoleCommands\Commands();
        $container->bind("RDev\\Console\\Commands\\Commands", $this->commands);
    }

    /**
     * Adds built-in commands to our list
     *
     * @param IoC\IContainer $container The dependency injection container to use
     */
    public function run(IoC\IContainer $container)
    {
        // Instantiate each command class
        foreach(self::$commandClasses as $commandClass)
        {
            $this->commands->add($container->makeShared($commandClass));
        }
    }
}