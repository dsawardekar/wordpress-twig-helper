<?php

namespace WordPress;

class TwigPrecompiler {

  function setEnvironment($twigEnv) {
    $this->twigEnv = $twigEnv;
  }

  function getEnvironment() {
    return $this->twigEnv;
  }

  function compile($sourceDirs) {
    foreach ($sourceDirs as $sourceDir) {
      $this->compileDir($sourceDir);
    }
  }

  function compileDir($sourceDir) {
    $templates = $this->templateNamesInDir($sourceDir);
    $env       = $this->twigEnv;

    foreach ($templates as $template) {
      $this->compileTemplate($template);
    }
  }

  function compileTemplate($templatePath) {
    $this->twigEnv->loadTemplate($templatePath);
  }

  function templateNamesInDir($dir) {
    $templates = $this->templatesInDir($dir);
    return array_map(array($this, 'templateNameFor'), $templates);
  }

  function templatesInDir($dir) {
    return glob($this->globForDir($dir));
  }

  function templateNameFor($filepath) {
    return basename($filepath);
  }

  function globForDir($dir) {
    return "$dir/*.twig";
  }

}
