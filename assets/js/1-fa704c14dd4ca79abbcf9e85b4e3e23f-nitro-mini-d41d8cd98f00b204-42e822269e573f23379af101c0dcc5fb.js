(function($){$.fn.toggleOption=function(value,show){return this.filter('select').each(function(){var select=$(this);if(typeof show==='undefined'){show=select.find('option[value="'+value+'"]').length==0;}
if(show){select.showOption(value);}
else{select.hideOption(value);}});};$.fn.showOption=function(value){return this.filter('select').each(function(){var select=$(this);var found=select.find('option[value="'+value+'"]').length!=0;if(found)return;var info=select.data('opt'+value);if(!info)return;var targetIndex=info.data('i');var options=select.find('option');var lastIndex=options.length-1;if(lastIndex==-1){select.prepend(info);}
else{options.each(function(i,e){var opt=$(e);if(opt.data('i')>targetIndex){opt.before(info);return false;}
else if(i==lastIndex){opt.after(info);return false;}});}
return;});};$.fn.hideOption=function(value){return this.filter('select').each(function(){var select=$(this);var opt=select.find('option[value="'+value+'"]').eq(0);if(!opt.length)return;if(!select.data('optionsModified')){select.find('option').each(function(i,e){$(e).data('i',i);});select.data('optionsModified',true);}
select.data('opt'+value,opt.detach());return;});};})(jQuery);