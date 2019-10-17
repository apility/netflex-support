<?php

namespace Netflex\Support;

class Str
{
  /**
   * @param string $str
   * @return string
   */
  public static function toCamcelCase(string $str): string
  {
    return preg_replace_callback('/(^|_)([a-z])/', function ($matches) {
      return strtoupper($matches[2]);
    }, $str);
  }
}
