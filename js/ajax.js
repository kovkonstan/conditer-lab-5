$(document).ready(function(){

    var c=$('.row_item').length;
    $(".delitem").live('click',function()
    {
       $('#delid').val($(this).attr('name'));
       $('#delform').ajaxSubmit();
       var i=$(this).index(".delitem");
    
       $('.row_item').eq(i).css('background','#ffcccc');
       $('.row_item').eq(i).fadeOut('slow',function(){
                  $('.row_item').eq(i).remove();
      c--;
       });
         
       
    })
})


