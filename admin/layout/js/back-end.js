//hide 
$(function(){

/* function to hide the placeholder  an input form on focus*/
$('[placeholder]').focus(function(){

	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');


}).blur(function(){

$(this).attr('placeholder',$(this).attr('data-text'));

});



//add "etoile" on required field
$('input').each(function(){

if($(this).attr('required')==='required'){


	$(this).after('<span class="asterisk ">*</span>');
}


});
//convert password field to text field on hover
 var passfield=$('.password');
$('.show-pass').hover(function(){
 passfield.attr('type','text');

}, function(){
 passfield.attr('type','password');
});

//confirm message in buttom

$('.confirm').click(function(){

return confirm('Are you sure');


});// if yes continue her action


//$('.child-c').hover(function(){

//$(this).find('.color-del').fadeIn(400);


//}, function(){
//$(this).find('.color-del').fadeOut(400);

//});//

//dashboard page hide + 
$('.toggle-info').click(function(){
$(this).parent().next('.panel-body').fadeToggle(100);

});

});
