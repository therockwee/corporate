/* =========================================================
 * params/all.js v0.0.1
 * =========================================================
 * Copyright 2012 Wpbakery
 *
 * Visual composer javascript functions to enable fields.
 * This script loads with settings form.
 * ========================================================= */

(function ( $ ) {
	function InitGalleries() {
		// TODO: Backbone style for view binding
		$( '.gallery_widget_attached_images_list', this.$view ).unbind( 'click.removeImage' ).on( 'click.removeImage',
			'a.icon-remove',
			function ( e ) {
				e.preventDefault();
				var $block = $( this ).closest( '.edit_form_line' );
				$( this ).parent().remove();
				var img_ids = [];
				$block.find( '.added img' ).each( function () {
					img_ids.push( $( this ).attr( "rel" ) );
				} );
				$block.find( '.gallery_widget_attached_images_ids' ).val( img_ids.join( ',' ) ).trigger( 'change' );
			} );
		$( '.gallery_widget_attached_images_list' ).each( function ( index ) {
			var $img_ul = $( this );
			$img_ul.sortable( {
				forcePlaceholderSize: true,
				placeholder: "widgets-placeholder-gallery",
				cursor: "move",
				items: "li",
				update: function () {
					var img_ids = [];
					$( this ).find( '.added img' ).each( function () {
						img_ids.push( $( this ).attr( "rel" ) );
					} );
					$img_ul.closest( '.edit_form_line' ).find( '.gallery' +
					'' +
					'_widget_attached_images_ids' ).val( img_ids.join( ',' ) ).trigger( 'change' );
				}
			} );
		} );
	}

	new InitGalleries();

	var $tabs = $( '#vc_edit-form-tabs' );
	if ( $tabs.length ) {
		$( '.wpb-edit-form' ).addClass( 'vc_with-tabs' );
		$tabs.find( '.vc_edit-form-tab-control' ).removeClass( 'vc_active' ).eq( 0 ).addClass( 'vc_active' );
		$tabs.find( '[data-vc-ui-element="panel-edit-element-tab"]' ).removeClass( 'vc_active' ).eq( 0 ).addClass( 'vc_active' );
		$tabs.find( '.vc_edit-form-link' ).click( function ( e ) {
			var $this = $( this );
			e.preventDefault();
			$tabs.find( '.vc_active' ).removeClass( 'vc_active' );
			$this.parent().addClass( 'vc_active' );
			var $target = $( $this.attr( 'href' ) ).addClass( 'vc_active' );
			$target.parents( '.vc_panel-body' ).scrollTop( 0 ); // fix for #1801
		} );
	}
	//additemlist button
	$(".vc_panel .additembutton").click(function(){
		var listitemwindow = $(this).parent().parent().next().find(".listitemwindow");
		listitemwindow.css({
			"display": "block",
			"top": "220px"
		});
		listitemwindow.find("[name='item_type']").val("items");
		listitemwindow.find("[name='item_value'], [name='item_content'], [name='item_url'], [name='item_content_color'], [name='item_value_color'], [name='item_border_color']").val("");
	});
	$(".cancel-item-options, .listitemwindow .vc_close").click(function(event){
		event.preventDefault();
		$(".listitemwindow").css("display", "none");
	});
	$("#add-item-shortcode").click(function(event){
		event.preventDefault();
		var editor = window.tinyMCE.get('wpb_tinymce_content');
		var currentContent = editor.getContent();
		var text_color = $("[name='additemwindow'] [name='item_content_color']");
		var value_color = $("[name='additemwindow'] [name='item_value_color']");
		var border_color = $("[name='additemwindow'] [name='item_border_color']");
		var item = '[item' + ($("[name='additemwindow'] [name='item_type']").length ? ' type="' + $("[name='additemwindow'] [name='item_type']").val() + '"' : '') + ($("[name='additemwindow'] [name='item_value']").length ? ' value="' + $("[name='additemwindow'] [name='item_value']").val() + '"' : '') + ($("[name='additemwindow'] [name='item_url']").length ? ' url="' + $("[name='additemwindow'] [name='item_url']").val() + '"' : '') + ($("[name='additemwindow'] [name='item_url_target']").length ? ' url_target="' + $("[name='additemwindow'] [name='item_url_target']").val() + '"' : '') + ($("[name='additemwindow'] [name='item_icon']").length ? ' icon="' + $("[name='additemwindow'] [name='item_icon']").val() + '"' : '') + (text_color.length!="" ? ' text_color="' + text_color.val() + '"' : '') + (value_color.length!="" ? ' value_color="' + value_color.val() + '"' : '') + (border_color.length!="" ? ' border_color="' + border_color.val() + '"' : '') + ']' + $("[name='additemwindow'] [name='item_content']").val() + '[/item]';
		editor.setContent($(currentContent).text()+item);
		$(".listitemwindow").css("display", "none");
	});
	//small slider show/hide images dependency fields
	$(".gallery_widget_attached_images_ids").change(function(){
		var val_split = $(this).val().split(",");
		var count = 0;
		if(parseInt(val_split[0]))
			count = val_split.length;
		//$("[data-dependency='images']").css("display", "none");
		var multipler = ($(this).hasClass("carousel_images") ? 5 : ($(this).hasClass("slider_images") ? 3 : 4));
		var nextAll = $(".wpb_el_type_attach_images").nextAll();
		nextAll.slice(0, 30*multipler+1).css("display", "none");
		if(count)
		{
			nextAll.slice(0, count*multipler).css("display", "block");
			nextAll.slice(30*multipler, 30*multipler+1).css("display", "block");
			/*for(var i=0; i<count*multipler; i++)
				$("[data-dependency='images']:eq("+i+")").css("display", "block");*/
			//$("[data-dependency='images']:last").css("display", "block");
		}
		
	});
	setTimeout(function(){
		$(".gallery_widget_attached_images_ids").trigger("change");
	}, 1);
	//testimonials
	$(".vc_panel [name^='testimonials_icon'], .vc_panel [name^='testimonials_title'], .vc_panel [name^='testimonials_author'], .vc_panel [name^='testimonials_author_subtext']").parent().parent().css("display", "none");
	$(".vc_panel [name='testimonials_count']").change(function(){
		var self = $(this);
		var multipler = $(".vc_panel [name$='29']").length;
		$(".vc_panel [name^='testimonials_icon'], .vc_panel [name^='testimonials_title'], .vc_panel [name^='testimonials_author'], .vc_panel [name^='testimonials_author_subtext']").parent().parent().css("display", "none");
		self.parent().parent().nextUntil('', ':lt(' + (self.val()*multipler) + ')').css("display", "block");
	});
	setTimeout(function(){
		$("[name='testimonials_count']").trigger("change");
	}, 1);
	//testimonials
	$(".vc_panel [name^='icon_type'], .vc_panel [name^='icon_url'], .vc_panel [name^='icon_target']").parent().parent().css("display", "none");
	$(".vc_panel [name='icons_count']").change(function(){
		var self = $(this);
		$(".vc_panel [name^='icon_type'], .vc_panel [name^='icon_url'], .vc_panel [name^='icon_target']").parent().parent().css("display", "none");
		self.parent().parent().nextUntil('', ':lt(' + (self.val()*3) + ')').css("display", "block");
	});
	setTimeout(function(){
		$("[name='icons_count']").trigger("change");
	}, 1);
	
})( window.jQuery );
