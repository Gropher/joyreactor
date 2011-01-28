$j(document).ready(function (){
  $j('a[title]').qtip({ 
    style: {
      background: '#F9E98E',
      padding: 0,
      border: { radius: 5 }, 
      name: 'cream', 
      tip: true 
    }, 
    show: { delay: 500, solo: true },
    hide: { delay: 500, effect: {type: 'fade', length: 0} },
    position: {
      corner: {
        target: 'topRight',
        tooltip: 'bottomLeft',
      }
    }
  });
  $j(".vote-unregistered").qtip({
    content:'<a href="/login">Войдите</a> или <a href="/register">зарегистрируйтесь</a> для голосования.', 
    show: { delay: 0, when: { event: "click" }, solo: true},  
    hide: { delay: 3000, fixed: true, effect: {type: 'fade', length: 0} },
    style: { 
      background: '#F9E98E',
      padding: 0,
      border: { radius: 5 }, 
      name: 'cream' 
    }, 
    position: {
      corner: {
        target: 'topRight',
        tooltip: 'bottomLeft',
      }
    }
  });
})
