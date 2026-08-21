/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.fillEmptyBlocks = false;
	config.entities = false;
  	config.basicEntities = false;
	
	config.extraAllowedContent = '*{*}';
	config.extraAllowedContent = 'h4,p,span;ul;li;table;td;style;*[id];*(*);*{*}';
	config.allowedContent = {
    $1: {
        // Use the ability to specify elements as an object.
        elements: CKEDITOR.dtd,
        attributes: true,
        styles: true,
        classes: true
    }
};
};
