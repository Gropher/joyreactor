/*

CUSTOM FORM ELEMENTS

Created by Ryan Fait
www.ryanfait.com

The only thing you need to change in this file is the following
variables: checkboxHeight, radioHeight and selectWidth.

Replace the first two numbers with the height of the checkbox and
radio button. The actual height of both the checkbox and radio
images should be 4 times the height of these two variables. The
selectWidth value should be the width of your select list image.

You may need to adjust your images a bit if there is a slight
vertical movement during the different stages of the button
activation.

Visit http://ryanfait.com/ for more information.

*/

var radioHeight = "46";

var Custom = {
	init: function() 
	{
		var inputs = document.getElementsByTagName("input"), span = Array();
		for(a = 0; a < inputs.length; a++) 
		{
			if(inputs[a].type == "radio" && inputs[a].className.substr(0,6) == "styled") 
			{
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type + inputs[a].className.substr(6);
				inputs[a].style.display = "none";
				if(inputs[a].checked == true) 
				{
					span[a].style.backgroundPosition = "0 -" + (radioHeight*2) + "px";
				}
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				inputs[a].onchange = Custom.clear;
				span[a].onmousedown = Custom.pushed;
				span[a].onmouseup = Custom.check;
				document.onmouseup = Custom.clear;
			}
		}
	},
	pushed: function() 
	{
		element = this.nextSibling;
		if(element.checked == true && element.type == "radio") 
		{
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} 
		else 
		{
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() 
	{
		element = this.nextSibling;
		this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
		group = this.nextSibling.name;
		inputs = document.getElementsByTagName("input");
		for(a = 0; a < inputs.length; a++) 
		{
			if(inputs[a].name == group && inputs[a] != this.nextSibling) 
			{
				inputs[a].previousSibling.style.backgroundPosition = "0 0";
			}
		}
		element.checked = true;
        element.click();
	},
	clear: function() 
	{
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) 
		{
			if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") 
			{
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} 
			else if(inputs[b].type == "radio" && inputs[b].className == "styled") 
			{
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	}
}
window.onload = Custom.init;