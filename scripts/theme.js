// The purpose of this code is to fix the height of overflow: auto blocks, because some browsers can't figure it out for themselves.
function smf_codeBoxFix()
{
	var codeFix = document.getElementsByTagName('code');
	for (var i = codeFix.length - 1; i >= 0; i--)
	{
		if (is_webkit && codeFix[i].offsetHeight < 20)
			codeFix[i].style.height = (codeFix[i].offsetHeight + 20) + 'px';

		else if (is_ff && (codeFix[i].scrollWidth > codeFix[i].clientWidth || codeFix[i].clientWidth == 0))
			codeFix[i].style.overflow = 'scroll';

		else if ('currentStyle' in codeFix[i] && codeFix[i].currentStyle.overflow == 'auto' && (codeFix[i].currentStyle.height == '' || codeFix[i].currentStyle.height == 'auto') && (codeFix[i].scrollWidth > codeFix[i].clientWidth || codeFix[i].clientWidth == 0) && (codeFix[i].offsetHeight != 0))
			codeFix[i].style.height = (codeFix[i].offsetHeight + 24) + 'px';
	}
}

// Add a fix for code stuff?
if ((is_ie && !is_ie4) || is_webkit || is_ff)
	addLoadEvent(smf_codeBoxFix);

// Toggles the element height and width styles of an image.
function smc_toggleImageDimensions()
{
	var oImages = document.getElementsByTagName('IMG');
	for (oImage in oImages)
	{
		// Not a resized image? Skip it.
		if (oImages[oImage].className == undefined || oImages[oImage].className.indexOf('bbc_img resized') == -1)
			continue;

		oImages[oImage].style.cursor = 'pointer';
		oImages[oImage].onclick = function() {
			this.style.width = this.style.height = this.style.width == 'auto' ? null : 'auto';
		};
	}
}

// Add a load event for the function above.
addLoadEvent(smc_toggleImageDimensions);

// Adds a button to a certain button strip.
function smf_addButton(sButtonStripId, bUseImage, oOptions)
{
	var oButtonStrip = document.getElementById(sButtonStripId);
	var aItems = oButtonStrip.getElementsByTagName('span');

	// Remove the 'last' class from the last item.
	if (aItems.length > 0)
	{
		var oLastSpan = aItems[aItems.length - 1];
		oLastSpan.className = oLastSpan.className.replace(/\s*last/, 'position_holder');
	}

	// Add the button.
	var oButtonStripList = oButtonStrip.getElementsByTagName('ul')[0];
	var oNewButton = document.createElement('li');
	setInnerHTML(oNewButton, '<a href="' + oOptions.sUrl + '" ' + ('sCustom' in oOptions ? oOptions.sCustom : '') + '><span class="last"' + ('sId' in oOptions ? ' id="' + oOptions.sId + '"': '') + '>' + oOptions.sText + '</span></a>');

	oButtonStripList.appendChild(oNewButton);
}

// Adds hover events to list items. Used for a versions of IE that don't support this by default.
var smf_addListItemHoverEvents = function()
{
	var cssRule, newSelector;

	// Add a rule for the list item hover event to every stylesheet.
	for (var iStyleSheet = 0; iStyleSheet < document.styleSheets.length; iStyleSheet ++)
		for (var iRule = 0; iRule < document.styleSheets[iStyleSheet].rules.length; iRule ++)
		{
			oCssRule = document.styleSheets[iStyleSheet].rules[iRule];
			if (oCssRule.selectorText.indexOf('LI:hover') != -1)
			{
				sNewSelector = oCssRule.selectorText.replace(/LI:hover/gi, 'LI.iehover');
				document.styleSheets[iStyleSheet].addRule(sNewSelector, oCssRule.style.cssText);
			}
		}

	// Now add handling for these hover events.
	var oListItems = document.getElementsByTagName('LI');
	for (oListItem in oListItems)
	{
		oListItems[oListItem].onmouseover = function() {
			this.className += ' iehover';
		};

		oListItems[oListItem].onmouseout = function() {
			this.className = this.className.replace(new RegExp(' iehover\\b'), '');
		};
	}
}

// Add hover events to list items if the browser requires it.
if (is_ie7down && 'attachEvent' in window)
	window.attachEvent('onload', smf_addListItemHoverEvents);

$(document).ready(function(){
	$("input[type=button],.button_submit").attr("class", "btn btn-primary");
	$("input[type=text]").attr("class", "form-control input-sm");
	$("select").attr("class", "form-control");
	$(".infobox").prepend("<button data-dismiss='alert' class='close' type='button'>×</button><i class='fa fa-check icon-sign'></i>");
	$(".infobox").attr("class", "alert alert-dismissable alert-success");
	$(".errorbox").prepend("<button data-dismiss='alert' class='close' type='button'>×</button><i class='fa fa-warning icon-sign'></i>");
	$(".errorbox").attr("class", "alert alert-dismissable alert-danger"); 
	$("input[name=delete]").before("<span class='btn-label' style='left: 7px !important; top: -3px;'><i class='fa fa-trash-o'></i></span>");
	$("input[name=delete], button[name=delete]").attr("class", "btn btn-danger").attr("style", "padding-left: 45px; margin-left: -25px;");
	$("img[alt=\'"+txtnew+"'], img.new_posts").replaceWith(" <span class=\'label label-primary\'>"+txtnew+"</span>");
	if (st_disable_fa_icons != 1) {
		$("img[src=\'"+smf_images_url+"/"+varianteurl+"off.png\'],img[src=\'"+smf_images_url+"/"+varianteurl+"new_none.png\']").replaceWith("<span style=\'opacity: 0.3;\' class=\'far fa-copy fa-3x\'></span>");
		$("img[src=\'"+smf_images_url+"/"+varianteurl+"on.png\'],img[src=\'"+smf_images_url+"/"+varianteurl+"on2.png\'],img[src=\'"+smf_images_url+"/"+varianteurl+"new_some.png\']").replaceWith("<span class=\'fas fa-copy fa-3x text-primary\'></span>");
		$("img[src=\'"+smf_images_url+"/"+varianteurl+"redirect.png\'],img[src=\'"+smf_images_url+"/"+varianteurl+"new_redirect.png\']").replaceWith("<span class=\'fa fa-link fa-3x text-primary\'></span>");
	}
	if ($(window).width() >= 767)
		$('[data-toggle="dropdown"]').bootstrapDropdownHover();
});