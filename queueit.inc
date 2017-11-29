<?php

/**
 * @file
 * Queue-it module's include file.
 */

/**
 * Helper function to convert Markdown text into HTML.
 */
function queueit_md2html($content) {
  // Convert new lines into <br>.
  $content = nl2br($content, FALSE);
  // Format code.
  $content = preg_replace('/`(.*?)`/s', '<code>\1</code>', $content);
  // Convert links.
  $content = preg_replace('/\[([^\[]+)\]\(([^\)]+)\)/', '<a href=\'\2\'>\1</a>', $content);
  // Convert headers.
  $content = preg_replace('/\n?(.*)\n=+/', '<h1>\1</h1>', $content);
  $content = preg_replace_callback('/\n(#+)(.*)/',
    function ($regs) {
      list(, $chars, $header) = $regs;
      return sprintf('<h%d>%s</h%d>', strlen($chars), trim($header), strlen($chars));
    },
    $content);
  // Remove not needed characters.
  $content = strtr($content, ['=' => '']);
  return $content;
}
