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