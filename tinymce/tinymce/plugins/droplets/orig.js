tinymce.PluginManager.requireLangPack('droplets');
tinymce.PluginManager.add('droplets', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('droplets', {
        tooltip: tinymce.util.I18n.translate('Droplet einf\u00fcgen'),
        image: url + '/img/droplets.png',
        onclick: function() {
            // Open window
            editor.windowManager.open({
                title:  tinymce.util.I18n.translate('Droplet einf\u00fcgen'),
                file:   url + '/droplets.php',
				inline: false,
                width: 600,
                height: 400,

                buttons: [
        			{text: tinymce.util.I18n.translate('Insert'), onclick: function() {
                        editor.insertContent('[['+self.frames[1].document.forms[0].droplet.value+']]');
                        top.tinymce.activeEditor.windowManager.close();
        			}},
                    {text: tinymce.util.I18n.translate('Discard'), onclick: 'close'},
                ]
            });
        }
    });
});