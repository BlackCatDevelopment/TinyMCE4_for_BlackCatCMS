<textarea name="{$name}" id="{$id}" style="width:{$width};height:{$height};">{$content}</textarea>
<script>
    tinymce.init({
        selector: "textarea#{$id}"
        ,language: 'de'
        ,rel_list: [
        					{ text: "Fancybox",	value: "fancybox" },
        					{ text: "Lightbox",	value: "lightbox" },
        					{ text: "PrettyPhoto", value: "prettyPhoto" },
        					{ text: "Alternate", value: "alternate" },
        					{ text: "Copyright", value: "copyright" },
        					{ text: "Designates", value: "designates" },
        					{ text: "No follow", value: "nofollow" },
        					{ text: "Stylesheet", value: "stylesheet" },
        					{ text: "Thumbnail", value: "thumbnail" }]
        ,menubar: "false"
        {$filemanager_include}
        {$toolbars_include}
        ,plugins: [
             "advlist charmap directionality fullscreen insertdatetime lists noneditable preview searchreplace table visualchars"
            ,"anchor autosave code emoticons hr legacyoutput media pagebreak print spellchecker template wordcount"
            ,"autolink bbcode contextmenu fullpage image link nonbreaking paste save tabfocus visualblocks textcolor cmsplink droplets"
            {if isset($plugins)},"{$plugins}"{/if}
        ]
        ,image_advtab: true
    });
</script>