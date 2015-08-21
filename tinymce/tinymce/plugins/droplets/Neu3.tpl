    <form action="#">
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
        <span style="width:100px;font-weight:bold;display:inline-block;">{translate('Description')}:</span>
        {$item.description}
      </div>
      {if $item.comment}
      <hr />
      <div class="dr_com">
        <span style="width:100px;font-weight:bold;display:inline-block;">{translate('Comment')}:</span>
        <span class="comment">{$item.comment}</span>
      </div>
      {/if}
    </div>
    {/foreach}
    <div class="dr_usage">
      <span style="width:100px;font-weight:bold;display:inline-block;">{translate('Edit')}:</span>
      <input type="text" name="dr_content" value="" />
    </div>
  </form>
  <script type="text/javascript">
    jQuery(document).ready( function($) {
      $('div#dr_'+$('select#droplet').val()).show();
      var myRegexp = /\[\[(\w+\?[\w=]+)\]\]/;
      $('#droplet').change( function() {
          current = $(this).val();
          $('div').not(':hidden').not('.dr_usage').hide();
          // get the include
          var match = myRegexp.exec($('div#dr_'+current).find('span.comment').text());
          if (match != null) {
            $('input[name="dr_content"]').val(match[0]);
          }
          else {
            $('input[name="dr_content"]').val("[[" + current + "]]");
          }
          $('div#dr_'+current).show();
      });
    });
  </script>