<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <? include_http_metas() ?>
    <? include_metas() ?>
    <? include_title() ?>
    <? include_stylesheets() ?>
    <? include_javascripts() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
 <body>
      <? include_partial('sfAdminDash/header') ?>
      <? echo $sf_content ?>
      <? include_partial('sfAdminDash/footer') ?>
    </body>
</html>
