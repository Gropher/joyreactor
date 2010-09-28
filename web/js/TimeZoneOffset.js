
$j(document).ready(function()
{
    $j.cookie("offset", (new Date()).getTimezoneOffset()/(-60), { path: '/', expires: 10 });
});