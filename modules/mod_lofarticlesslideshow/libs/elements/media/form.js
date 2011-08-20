/**
 * LofForm Plugin 
 * 
 * @copyright http://landofcoder.com
 */
var LofForm = new Class({
	initialize: function(panels, toolbar, container){
		if( panels.length <=0 ){
			return ;	
		}
	 
		var tmptb = panels[0].getElement(".lof-toolbar-items") ;  
		toolbar.adopt(tmptb );
		var lofpanel = [];
		for( var i=1; i< panels.length-1; i++ ) {
			container.adopt(panels[i]);	
			lofpanel[i-1] = panels[i].setStyle("display","none").tween("opacity",0);
		}
		panels[0].empty().hide();
		panels[panels.length-1].hide();
		panels = null;
		// add event for switching panel configuration form
		lofpanel[0].fade("in").setStyle("display","block");
		$$(".lof-toolbar-items > li")[0].addClass("active");
		$$(".lof-toolbar-items > li").each( function(item, i){
			item.addEvent( "click" , function(){
				$$(".lof-toolbar-items > li:.active").removeClass("active");
				item.addClass("active");										  
				if( $defined(lofpanel[i]) ) {
					 lofpanel[i].tween("opacity",1).setStyle("display","block");
					 for( var j=0; j< lofpanel.length; j++ ) {
					 	if( j != i ){
							lofpanel[j].tween("opacity",0).setStyle("display","none");
						}
					 }
				}
			} );
		} );
}});
// JavaScript Document
$(window).addEvent( 'load', function(){
								
	$$(".lof-cbktoggle").each( function(item){
		item.addEvent( 'click', function(){
			if(item.checked){
				$$("#toggle-"+item.id).show();
			} else {
				$$("#toggle-"+item.id).hide();
			}
		} );
		
		if(item.checked){
			$$("#toggle-"+item.id).show();
		} else {
			$$("#toggle-"+item.id).hide();
		}
			
			
	} );
			
	// add event addrow
	$$('.it-addrow-block .add').each( function( item, idx ){ 
		item.addEvent('click', function( ){
			var name   = "jform[params]["+item.getProperty('id').replace('btna-','')+"][]"
			var newrow = new Element('div', {'class':'row'} );	
			var input  = new Element('input', {'name':name,'type':'text'} );
			var span   = new Element('span',{'class':'remove'});
			var spantext   = new Element('span',{'class':'spantext'}); 
				newrow.adopt( spantext );	
				newrow.adopt( input );	
				newrow.adopt( span );			
			var parent = item.getParent().getParent();	
			parent.adopt( newrow );	
			spantext.innerHTML= parent.getElements('input').length;	
			span.addEvent('click', function(){ 
											
				if( span.getParent().getElement('input').value ) {
					if( confirm('Are you sure to remove this') ) {
						span.getParent().dispose(); 
					}
				} else {
					span.getParent().dispose(); 
				}
				setTimeout( function(){ $$('.jpane-slider ').setStyle( 'height', $$('.paramlist').offsetHeight );
																		parent.getElements('.spantext').each( function(tm,j){
																			tm.innerHTML=j+1;											   
																		});					
				}, 300 );
			} );				 
			setTimeout( function(){
				//	$$('.jpane-slider ').setStyle( 'height', $$('.paramlist').offsetHeight );
			//		parent.getElements('.spantext').each( function(tm,j){tm.innerHTML=j+1;});	
					
			}, 300 );
				    
		} );
	} );
	$$('.it-addrow-block .row').each(function( item ){
		item.getElement('.remove').addEvent('click', function() {
			if( item.getElement('input').value ) {
				if( confirm('Are you sure to remove this') ) {
					item.dispose();
				}
			}else {
				item.dispose();
			}
		//	setTimeout( function(){ $$('.jpane-slider ').setStyle( 'height', $$('.paramlist').offsetHeight );}, 300 );
		} );
	});
} );

