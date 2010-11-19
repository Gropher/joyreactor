$j(document).ready(function (){
  UpdateCommentsCss();
})

function UpdateCommentsCss(){
  $j(".comment").hover(
    function(){
        $j(this).css("background","#ebebeb");
    },
    function(){
        $j(this).css("background","none");
    }
  );
}

function startAddComment(formId)
{
    $j('.submit_add_comment' + formId).attr("disabled", true);
}

function completeAddComment(formId, response)
{
    $j('#add_comment_form' + formId).keypress(function(e){ctrlEnter(e, this)});
    $j('.addcomment').hide("fast");
    $j('.addcommentInline').hide("fast");
    $j('#comment_list' + formId).html(response);
    $j('.submit_add_comment' + formId).removeAttr("disabled");
    $j('#add_comment_form' + formId + ' :input[type=textarea]').each(function(){
      $j(this).val('');
    });
    $j('#add_comment_form' + formId + ' input#comment_picture_url').each(function(){
      $j(this).val('');
    });
}