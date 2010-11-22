$j(document).ready(function(){
  $j('#bn_35VfKN0KS5S5DkmXjB25').each(function(){
    var tizt = 0; <!-- тип тизеров, 1 - JPEG, 2 - GIF -->
    var tizw = 0; <!-- ширина тизеров -->
    var pov = 0; <!-- разрешить повторы объявлений одного рекламодателя, 1 - да -->
    var nobg = 0; <!-- значение 1 - делает фон таблицы прозрачным -->
    var vref = 0; <!-- 1 - показывать реф-ссылку, 2 - нет -->
    var vopis = 0; <!-- 1 - показывать описание, 2 - нет -->
    var sortt = 0; <!-- тип сортировки, 1 - по ставке, 2 - по цтр, 3 - глобальная, 4 - по CPC -->
    var nod = 0; <!-- если 1 - то будут выводится объявления из разных категорий -->
    var ref = escape(document.referrer); var server = 'tizer6.net';
    $j('body').append('<scr'+'ipt type="text/jav'+'ascript" src="http://'+server+'/tizers2.php?sid=22955&bn=35VfKN0KS5S5DkmXjB25&ad=0&char=2&nod='+nod+'&sort='+sortt+'&tizt='+tizt+'&tizw='+tizw+'&pov='+pov+'&nobg='+nobg+'&vref='+vref+'&vopis='+vopis+'&ref='+ref+'"></scr'+'ipt>');
  });
});

