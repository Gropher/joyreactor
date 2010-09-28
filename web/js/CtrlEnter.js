function ctrlEnter(event, formElem)
{
    if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD)))
    {
        formElem.submit.click();
        formElem.onkeypress = null;
    }
}


