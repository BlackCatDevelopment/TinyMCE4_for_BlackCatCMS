<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>Droplets</title>
    <script charset=iso-8859-1 src="{$CAT_URL}/modules/lib_jquery/jquery-core/jquery-core.min.js" type="text/javascript"></script>
    <style type="text/css" media="screen">
      body,html{ font-family:HelveticaNeue,Helvetica,Arial,Verdana,sans-serif;font-size:13px; }
      div{ margin:7px auto; }
      .dr_title { background-color:#7b8b98;color:#fff;font-weight:bold;text-align:center; }
    </style>
  </head>
  <body>
    <form action="#" method="post">
      <label for="droplet" class="mce-widget mce-label mce-abs-layout-item mce-first">{translate('Droplet')}</label>
        <select id="droplet" name="droplet">
          {foreach $data item}
          <option value="{$item.title}">{$item.title}</option>
          {/foreach}
        </select><br />
    </form>
  </body>
</html>