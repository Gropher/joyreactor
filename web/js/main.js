$j(document).ready(function (){
  $j('a[title]').qtip({ 
    style: {
      background: '#F9E98E',
      padding: 0,
      border: { radius: 5 }, 
      name: 'cream', 
      tip: true 
    }, 
    show: { delay: 500 },
    position: {
      corner: {
        target: 'topLeft',
        tooltip: 'bottomRight',
      }
    }
  });
  $j(".vote-unregistered").qtip({
    content:'<a href="/login">Войдите</a> или <a href="/register">зарегистрируйтесь</a> для голосования.', 
    show: { when: { event: "click" }, delay: 0 },  
    hide: { delay: 3000 },
    style: { 
      background: '#F9E98E',
      padding: 0,
      border: { radius: 5 }, 
      name: 'cream' 
    }, 
    position: {
      corner: {
        target: 'topLeft',
        tooltip: 'bottomRight',
      }
    }
  });
})
