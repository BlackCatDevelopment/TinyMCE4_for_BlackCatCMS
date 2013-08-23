<textarea name="{$name}" id="{$id}" style="width:{$width};height:{$height};">{$content}</textarea>
<script>
    tinymce.init({
        selector: "textarea#{$id}"
        ,menubar: "false"
        {$filemanager_include}
        {$toolbars_include}
        ,plugins: [
             "advlist autoresize charmap directionality fullscreen insertdatetime lists noneditable preview searchreplace table visualchars"
            ,"anchor autosave code emoticons hr legacyoutput media pagebreak print spellchecker template wordcount"
            ,"autolink bbcode contextmenu fullpage image link nonbreaking paste save tabfocus visualblocks textcolor droplets"
            {if isset($plugins)},"{$plugins}"{/if}
        ]
        ,image_advtab: true
    });
</script>