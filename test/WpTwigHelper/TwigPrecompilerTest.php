<?php

namespace WpTwigHelper;

use WpTwigHelper\TwigReaper;
use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \DateTime;

class TwigPrecompilerTest extends \PHPUnit_Framework_TestCase {

  public $compiler;

  function setUp() {
    $this->compiler = new TwigPrecompiler();
  }

  function test_it_can_store_twig_environment() {
    $env = new Twig_Environment();
    $this->compiler->setEnvironment($env);

    $actual = $this->compiler->getEnvironment();
    $this->assertEquals($env, $actual);
  }

  function test_it_can_build_glob_for_directory() {
    $actual = $this->compiler->globForDir('templates');
    $this->assertEquals('templates/*.twig', $actual);
  }

  function test_it_can_find_templates_in_directory() {
    $actual = $this->compiler->templatesInDir('templates');
    $this->assertContains('templates/hello.twig', $actual);
  }

  function test_it_can_find_template_names_in_directory() {
    $actual = $this->compiler->templateNamesInDir('templates');
    $this->assertContains('hello.twig', $actual);
  }

  function test_it_can_compile_template() {
    $templatePath = 'hello.twig';
    $outputDir    = 'dist/templates';
    $loader       = new Twig_Loader_Filesystem('templates');
    $opts         = array( 'cache' => $outputDir);
    $env          = new Twig_Environment($loader, $opts);

    $this->compiler->setEnvironment($env);
    $cacheFile = $env->getCacheFilename('hello.twig');

    $this->compiler->compileTemplate($templatePath);
    $this->assertTrue(file_exists($cacheFile));
  }

  function test_it_can_compile_directory_of_templates() {
    $outputDir    = 'dist/templates';
    $loader       = new Twig_Loader_Filesystem('templates');
    $opts         = array( 'cache' => $outputDir);
    $env          = new Twig_Environment($loader, $opts);

    $this->compiler->setEnvironment($env);
    $this->compiler->compileDir('templates');

    $this->assertTrue(file_exists($env->getCacheFilename('hello.twig')));
    $this->assertTrue(file_exists($env->getCacheFilename('bye.twig')));
  }

  function test_it_can_compile_directories_of_templates() {
    $outputDir    = 'dist/templates';
    $loader       = new Twig_Loader_Filesystem('templates');
    $opts         = array( 'cache' => $outputDir);
    $env          = new Twig_Environment($loader, $opts);

    $this->compiler->setEnvironment($env);
    $this->compiler->compile(array('templates'));

    $this->assertTrue(file_exists($env->getCacheFilename('hello.twig')));
    $this->assertTrue(file_exists($env->getCacheFilename('bye.twig')));
  }
}
