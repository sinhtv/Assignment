/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	
	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.entities  = false;
	config.basicEntities = false;
	config.entities_greek = false;
	config.entities_latin = false;
	//config.extraAllowedContent = "a[rel,title];img[title];";
	
	config.filebrowserBrowseUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '{{HTTP_OPENCART}}view/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	config.filebrowserWindowWidth = '800'; 
	config.filebrowserWindowHeight = '480';
};

CKEDITOR.on('instanceReady',function(evt){
	
	var editor = evt.editor;
	editor.dataProcessor.htmlFilter.addRules(
	{
		elements :
		{
			a : function( element ){	if ( !element.attributes.title )	element.attributes.title = strip_tags(element.getHtml());	
			},
			img : function( element ) {   
				if ( !element.attributes.title && element.attributes.alt )     element.attributes.title = element.attributes.alt;  
			},
			td : function( element ){  
				changeAlign(element); 
			},
		}
	});

	function changeAlign(element){
		var style = element.attributes.style;
		if ( style ){
			var match = /(?:^|\"|\s)text-align\s*:\s*(\w*)(?:$|\"|\s)/i.exec( style );	// Get the align from the style.
			var align = match && match[1];
			if ( align ){
				element.attributes.style = element.attributes.style.replace( /text-align\s*:\s*(\w*);?/i , '' );
				element.attributes.align = align;
			} 
		}
		if (!element.attributes.style)   delete element.attributes.style;
		return element;
	}
	function strip_tags(input, allowed) {
	  allowed = (((allowed || '') + '')
		.toLowerCase()
		.match(/<[a-z][a-z0-9]*>/g) || [])
		.join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
		commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	  return input.replace(commentsAndPhpTags, '')
		.replace(tags, function ($0, $1) {
		  return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		});
	}

});
