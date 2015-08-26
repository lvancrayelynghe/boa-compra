<?php

class RoboFile extends \Robo\Tasks
{
    /**
     * Run all the commands
     */
    public function all()
    {
        $this->phpAll();
        $this->testsAll();
        $this->docGenerate();
    }

    /**
     * Run all the fixers
     */
    public function testsAll()
    {
        $this->testsPhpunit();
        $this->testsScrutinizer();
    }

    /**
     * Run all the fixers
     */
    public function phpAll()
    {
        $this->phpCsfixer();
        $this->phpMd();
        $this->phpCpd();
        $this->phpCs();
        $this->phpLoc();
    }

    /**
     * Run Sami doc generator
     */
    public function docGenerate()
    {
        $this->taskExec('sami update sami-config.inc.php')->dir(__DIR__)->run();
    }

    /**
     * Run PhpUnit tests
     */
    public function testsPhpunit()
    {
        $this->taskExec('vendor/bin/phpunit')->dir(__DIR__)->run();
    }

    /**
     * Send coverage to Scrutinizer
     */
    public function testsScrutinizer()
    {
        if (!file_exists(__DIR__.'/build/logs/clover.xml')) {
            $this->say('build/logs/clover.xml file not found. Run PhpUnit first.');
            return 1;
        }

        $this->taskExec('vendor/bin/ocular code-coverage:upload --format=php-clover '.__DIR__.'/build/logs/clover.xml')->dir(__DIR__)->run();
    }

    /**
     * Run PHP-CS-Fixer on "src" and "tests" directories
     */
    public function phpCsfixer()
    {
        $this->taskExecStack()->dir(__DIR__)
            ->exec('php-cs-fixer fix src --level=symfony')
            ->exec('php-cs-fixer fix src --fixers=align_equals,multiline_spaces_before_semicolon,no_blank_lines_before_namespace')
            ->exec('php-cs-fixer fix tests --level=symfony')
            ->exec('php-cs-fixer fix tests --fixers=align_equals,multiline_spaces_before_semicolon,no_blank_lines_before_namespace')
        ->run();
    }

    /**
     * Run PHP Mess Detector on "src" directory
     */
    public function phpMd()
    {
        $this->taskExec('phpmd src text cleancode,codesize,controversial,design,naming,unusedcode')->dir(__DIR__)->run();
    }

    /**
     * Run PHP Copy Paste Detector on "src" directory
     */
    public function phpCpd()
    {
        $this->taskExec('phpcpd src --min-lines=2 --min-tokens=30')->dir(__DIR__)->run();
    }

    /**
     * Run PHP_CodeSniffer on "src" directory
     */
    public function phpCs()
    {
        $this->taskExecStack()->dir(__DIR__)
            ->exec('phpcs src --standard=PSR2')
            ->exec('phpcbf src --standard=PSR2')
        ->run();
    }

    /**
     * Run PHPLOC on "src" directory (measuring the size and analyzing the structure of a PHP project)
     */
    public function phpLoc()
    {
        $this->taskExec('phploc src')->dir(__DIR__)->run();
    }

}
