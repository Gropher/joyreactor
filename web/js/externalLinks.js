$j(document).ready(function(){
    $j("a").filter(function(){
        var hostname = window.location.hostname.replace("www.","").toLowerCase();
        var href = this.href.toLowerCase();
        return (href.indexOf("http://")!=-1 && href.indexOf(hostname)==-1) ? true : false;
    }).attr("target","_blank").addClass("external");
});