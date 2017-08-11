jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.ss_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('ss_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[my_name]'+selected+'[/my_name]';
                    }else{
                        content =  '[my_name]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('ss_button', {title : 'Insert shortcode', cmd : 'ss_insert_shortcode', image: 'http://screenshots.sharkz.in/suraj/2017/08/chrome_2017-08-11_18-41-56.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('ss_button', tinymce.plugins.ss_plugin);
});