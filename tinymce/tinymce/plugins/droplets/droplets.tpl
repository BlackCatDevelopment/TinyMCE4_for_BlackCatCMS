<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>Droplets</title>
    <script charset=iso-8859-1 src="{$CAT_URL}/modules/lib_jquery/jquery-core/jquery-core.min.js" type="text/javascript"></script>
    <style type="text/css" media="screen">
    body, html { font-family: HelveticaNeue,Helvetica,Arial,Verdana,sans-serif;font-size: 13px; }
    div { margin: 7px auto; }
    .dr_title { background-color:#7b8b98;color:#fff;font-weight:bold;text-align:center; }
    </style>
  </head>
  <body>
    <form action="#" onsubmit="droplepsDialog.insert();return false;">
    <label for="droplet">{translate('Droplet')}</label>
    <select id="droplet" name="droplet">
      {foreach $data item}
      <option value="{$item.title}">{$item.title}</option>
      {/foreach}
    </select><br /><br />
    {foreach $data item}
    <div id="dr_{$item.title}" style="display:none;">
      <div class="dr_title">
        {translate('Droplet')}: {$item.title}
      </div>
      <div class="dr_desc">
        {$item.description}
      </div>
      {if $item.comment}
      <hr />
      <div class="dr_com">
        {$item.comment}
      </div>
      {/if}
    </div>
    {/foreach}
  </form>
  <script charset=iso-8859-1 type="text/javascript">
    jQuery(document).ready( function($) {
      $('div#dr_'+$('select#droplet').val()).show();
      $('#droplet').change( function() {
          current = $(this).val();
          $('div').not(':hidden').hide();
          $('div#dr_'+current).show();
      });
    });
  </script>
 </body>
</html>