<?php

use WordPress\TwigReaper;
use Twig_Loader_Filesystem;

class TwigReaperTest extends PHPUnit_Framework_TestCase {

  function setUp() {
    $this->reaper = new TwigReaper();
  }

  function test_it_knows_if_template_directory_is_valid() {
    $actual = $this->reaper->isValidTemplateDir('lib/WordPress');
    $this->assertTrue($actual);
  }

  function test_it_knows_if_template_directory_is_invalid() {
    $actual = $this->reaper->isValidTemplateDir('lib/FooBar');
    $this->assertFalse($actual);
  }

  function test_it_removes_non_existing_dirs() {
    $sourceDirs = array(
      'lib/WordPress',
      'test/WordPress',
      'foo/bar',
      'bar/foo'
    );

    $expected = array(
      'lib/WordPress',
      'test/WordPress'
    );

    $actual = $this->reaper->toValidTemplateDirs($sourceDirs);
    $this->assertEquals($expected, $actual);
  }

  function test_it_can_setup_twig_loader() {
    $dirs = array('templates');
    $this->reaper->setup($dirs);

    $loader = $this->reaper->getTwigLoader();
    $this->assertEquals($dirs, $loader->getPaths());
  }

  function test_it_can_setup_twig_environment() {
    $dirs = array('templates');
    $this->reaper->setup($dirs);

    $env = $this->reaper->getTwigEnvironment();
    $template = 'hello.twig';
    $actual = $env->render($template, array('name' => 'Darshan'));

    $this->assertEquals('Hello Darshan', $actual);
  }

}
