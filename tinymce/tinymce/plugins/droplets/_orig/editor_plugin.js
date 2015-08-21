(function() {
	tinymce.PluginManager.requireLangPack('droplets');
	tinymce.create('tinymce.plugins.dropletsPlugin', {
		init : function(ed, url) {
			ed.addCommand('mcedroplets', function() {
				ed.windowManager.open({
					file:   url + '/droplets.php',
					width:  320 + ed.getLang('droplets.delta_width', 0),
					height: 340 + ed.getLang('droplets.delta_height', 0),
					inline: 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});

			// Register droplets button
			ed.addButton('droplets', {
				title: 'droplets.desc',
				cmd:   'mcedroplets',
				image: url + '/img/droplets.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('droplets', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'droplets plugin',
				author : 'LEPTON-CMS',
				authorurl : '',
				infourl : '',
				version : "1.1.2"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('droplets', tinymce.plugins.dropletsPlugin);
})();
