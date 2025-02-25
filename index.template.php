<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0.19
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

/*	This theme is a work of SMF Tricks Team. For more information please visit
	https://www.smftricks.com/
	This theme was developed by Diego Andrés and its a Free Theme.
	Theme designed by Raphisio
	Visit SMF Tricks for more Free Themes and Premium Themes.
	Flexive is a Free Theme
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0.9';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show right to left and the character set for ease of translating.
	echo '<!DOCTYPE html>
<html', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>';

	// The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
	echo '
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/responsive.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />';

	// Some browsers need an extra stylesheet due to bugs/compatibility issues.
	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
		if ($context['browser']['is_' . $cssfix])
			echo '
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

	// RTL languages require an additional stylesheet.
	if ($context['right_to_left'])
		echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

	// Here comes the JavaScript bits!
	echo '
	<script type="text/javascript">!window.jQuery && document.write(unescape(\'%3Cscript src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"%3E%3C/script%3E\'))</script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		var st_disable_fa_icons = "', $settings['st_disable_fa_icons'], '";
		var txtnew = "', $txt['new'], '";
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var variante = "', $context['theme_variant'], '";
		var varianteurl = "', $context['theme_variant_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

	echo '
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

	// Please don't index these Mr Robot.
	if (!empty($context['robot_no_index']))
		echo '
	<meta name="robots" content="noindex" />';

	// Present a canonical url for search engines to prevent duplicate content in their indices.
	if (!empty($context['canonical_url']))
		echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';

	// Show all the relative links, such as help, search, contents, and the like.
	echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

	// If RSS feeds are enabled, advertise the presence of one.
	if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
		echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

	// If we're in a board, or a topic for that matter, the index will be the board's index.
	if (!empty($context['current_board']))
		echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

	// Output any remaining HTML headers. (from mods, maybe?)
	echo $context['html_headers'];

	echo '
</head>
<body>';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show the menu here, according to the menu sub template.
	template_menu();

	echo '
	<div', !empty($settings['st_enable_header_background']) ? ' class="header-main" '. (!empty($settings['st_custom_header_url']) ? ' style="background-image: url('.$settings['st_custom_header_url']. ');"' : '') : ' class="header-normal"', '>
		<div class="wrapper"', !empty($settings['forum_width']) ? ' style="width: '.$settings['forum_width'].'"' : '', '>
			<h1 class="forumtitle">
				<a href="', $scripturl, '">', empty($context['header_logo_url_html_safe']) ? $context['forum_name'] : '<img src="' . $context['header_logo_url_html_safe'] . '" alt="' . $context['forum_name'] . '" />', '</a>
			</h1>
		</div>
	</div>';

	// Show the navigation tree.
	theme_linktree(false, true, true);

	echo '
<div class="wrapper"', !empty($settings['forum_width']) ? ' style="width: '.$settings['forum_width'].'"' : '', '>';

	// The main content should go here.
	echo '
	<div id="content_section">
		<div id="main_content_section">';

	// Reports and stuff
	if ($context['user']['is_logged']) {

		// Is the forum in maintenance mode?
		if ($context['in_maintenance'] && $context['user']['is_admin'])
			echo '
			<div class="alert alert-dismissable alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="fa fa-gear icon-sign"></i>
				<a class="alert-link" href="', $scripturl, '?action=admin;area=serversettings;sa=general;', $context['session_var'], '=', $context['session_id'], '" title="', $txt['maintain_mode_on'], '">
					', $txt['maintain_mode_on'], '</a>
			</div>';

		// Are there any members waiting for approval?
		if (!empty($context['unapproved_members']))
			echo '
			<div class="alert alert-dismissable alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="fa fa-users icon-sign"></i>
				<a class="alert-link" href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve" title="', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '">
					', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '
				</a>
			</div>';

		if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
			echo '
			<div class="alert alert-dismissable alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="fa fa-flag icon-sign"></i>
				<a class="alert-link" href="', $scripturl, '?action=moderate;area=reports" title="', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '">
					', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '
				</a>
			</div>';
	}

	// Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
		</div>
	</div>
</div>';

	// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	echo '
	<div class="footer-main">
		<div class="wrapper"', !empty($settings['forum_width']) ? ' style="width: '.$settings['forum_width'].'"' : '', '>
			<div class="row">
				<div class="col-md-6">
						<ul class="reset">
							<li class="copyright">', theme_copyright(), '</li>
							<li class="copyright">', flexive_copy(), '</li>
						</ul>
				</div>
				<div class="col-md-6">
					<div id="quicknav">
						<ul class="reset">';

					if(!empty($settings['st_facebook_username']))
						echo '
							<li><a class="social_icon facebook" href="https://facebook.com/', $settings['st_facebook_username'] , '" target="_blank" rel="noopener"><span class="fab fa-facebook"></span></a></li>';

					if(!empty($settings['st_twitter_username']))
						echo '
							<li><a class="social_icon twitter" href="https://twitter.com/', $settings['st_twitter_username'] , '" target="_blank" rel="noopener"><span class="fab fa-twitter"></span></a></li>';

					if(!empty($settings['st_youtube_username']))
						echo '
							<li><a class="social_icon youtube" href="https://youtube.com/user/', $settings['st_youtube_username'] , '" target="_blank" rel="noopener"><span class="fab fa-youtube"></span></a></li>';

					if(!empty($settings['st_instagram_username']))
						echo '
							<li><a class="social_icon instagram" href="https://instagram.com/', $settings['st_instagram_username'] , '" target="_blank" rel="noopener"><span class="fab fa-instagram"></span></a></li>';

						echo '
							<li><a class="social_icon rss" href="', empty($settings['st_rss_url']) ? '' . $scripturl . '?action=.xml;type=rss' : '' . $settings['st_rss_url'] . '', '" target="_blank" rel="noopener"><span class="fa fa-rss"></span></a></li>
						</ul>
					</div>
				</div>
			</div>';

	// Show the load time?
	if ($context['show_load_time'])
		echo '
		<p class="footer-load">', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

	echo '
		</div>
	</div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false, $index=false, $quicklinks=false)
{
	global $context, $settings, $options, $shown_linktree, $txt;

	// If linktree is empty, just return - also allow an override.
	if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
		return;

	echo '
	<div class="navigate_section">
		<div class="wrapper"', !empty($settings['forum_width']) && $index==true ? ' style="width: '.$settings['forum_width'].'"' : '', '>
		<ul>';

	// Each tree item has a URL and name. Some may have extra_before and extra_after.
	foreach ($context['linktree'] as $link_num => $tree)
	{
		echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

		// Show something before the link?
		if (isset($tree['extra_before']))
			echo $tree['extra_before'];

		// Show the link, including a URL if it should have one.
		echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

		// Show something after the link...?
		if (isset($tree['extra_after']))
			echo $tree['extra_after'];

		// Don't show a separator for the last one.
		if ($link_num != count($context['linktree']) - 1)
			echo ' &#187;';

		echo '
			</li>';
	}
	echo '
		</ul>';

	// If the user is logged in, display stuff like their name, new messages, etc.
	if ($quicklinks && $context['user']['is_logged'])
	{
		echo '
		<ul class="reset">';

		// Is the forum in maintenance mode?
		if ($context['in_maintenance'] && $context['user']['is_admin'])
			echo '
			<li class="notice quicklinks">', $txt['maintain_mode_on'], '</li>';

		echo '
			<li class="quicklinks"><a href="', $scripturl, '?action=unread">', $txt['unread_since_visit'], '</a></li>
			<li class="quicklinks"><a href="', $scripturl, '?action=unreadreplies">', $txt['show_unread_replies'], '</a></li>';

		// Are there any members waiting for approval?
		if (!empty($context['unapproved_members']))
			echo '
			<li class="quicklinks">', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' <a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve">', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], '</a> ', $txt['approve_members_waiting'], '</li>';

		if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
			echo '
			<li class="quicklinks"><a href="', $scripturl, '?action=moderate;area=reports">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</a></li>';

		echo '
		</ul>';
	}

	echo '
		</div>
	</div>';

	$shown_linktree = true;
}

// Theme copyright, please DO NOT REMOVE THIS!
function flexive_copy() {
	$flexive = 'Theme by <a href="https://smftricks.com">SMF Tricks</a>';

	return $flexive;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	$prevent_actions = array('search','logout','login', 'register');
	
	echo '
				<nav class="navbar  navbar-inverse" id="topnav">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="', $scripturl, '">', $context['forum_name'], '</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
							<ul class="nav navbar-nav">';

	// Note: Menu markup has been cleaned up to remove unnecessary spans and classes.
	foreach ($context['menu_buttons'] as $act => $button)
	{
			// Remove useless actions from menu
			if (in_array($act, $prevent_actions))
				continue;

			echo '
								<li id="button_', $act, '"', $button['active_button'] ? ' class="active'. (!empty($button['active_button']) ? ' dropdown' : ''). '"' : '', '', (!$button['active_button'] && !empty($button['sub_buttons']) ? ' class="dropdown"' : ''), '>
									<a href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '', !empty($button['sub_buttons']) ? ' class="dropdown-toggle" data-toggle="dropdown"' :'', '>
										', !empty($settings['st_enable_menuicons']) ? '<span class="fa fa-'. $act. '"></span> ' : '', '
										', $button['title'], '', !empty($button['sub_buttons']) ? ' <span class="caret"></span>' :'', '
									</a>';

		if (!empty($button['sub_buttons']))
		{
			echo '
									<ul class="dropdown-menu" role="menu">';
									
							// People always complaining about the toggle button... Let's add the main button here to make them happy.
							echo '
										<li>
											<a href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>', $button['title'], '</a>
										</li>';
										
							// Theme settings
							if ($act == 'admin')
								echo '
										<li>
											<a href="', $scripturl, '?action=admin;area=theme;sa=settings;th=', $settings['theme_id'], '">', $txt['current_theme'], '</a>
										</li>';
										
			foreach ($button['sub_buttons'] as $childbutton)
			{
				echo '
										<li', !empty($childbutton['sub_buttons']) ? ' class="subsections"' :'', '>
											<a href="', $childbutton['href'], '"' , isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
												', $childbutton['title'], '
											</a>';
				// 3rd level menus :)
				if (!empty($childbutton['sub_buttons']))
				{
					echo '
											<ul>';

					foreach ($childbutton['sub_buttons'] as $grandchildbutton)
						echo '
												<li>
													<a href="', $grandchildbutton['href'], '"' , isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
														', $grandchildbutton['title'], '
													</a>
												</li>';

					echo '
											</ul>';
				}

				echo '
										</li>';
			}
				echo '
									</ul>';
		}
		echo '
								</li>';
	}

	echo '
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="userinf dropdown active">
									<a href="', $scripturl, '?action=profile" class="dropdown-toggle" data-toggle="dropdown">
										<img src="', ($context['user']['avatar'] ? $context['user']['avatar']['href'] : $settings['images_url']. '/theme/noavatar.png'), '" alt="', $txt['profile'], '" />
										', $context['user']['name'], ($context['user']['unread_messages'] == 0) ? '' : ' <span class="label label-primary visible-xs-inline">' . $context['user']['unread_messages'] . '</span>', ' <span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu">';

								// If the user is logged in, display some things that might be useful.
								if ($context['user']['is_logged']) {
									echo '
										<li><a href="', $scripturl, '?action=profile"><span class="fa fa-user"></span> ', $txt['summary'], '</a></li>
										<li><a href="', $scripturl, '?action=profile;area=forumprofile"><span class="fa fa-wrench"></span> ', $txt['forumprofile'], '</a></li>
										<li><a href="', $scripturl, '?action=profile;area=account"><span class="fa fa-cog"></span> ', $txt['account'], '</a></li>
										<li><a href="', $scripturl, '?action=unread"><span class="fa fa-list"></span> ', $txt['unread_topics_visit'], '</a></li>
										<li><a href="', $scripturl, '?action=unreadreplies"><span class="fa fa-comment"></span> ', $txt['unread_replies'], '</a></li>
										<li class="divider"></li>
										', !empty($context['user']['unread_messages']) ? '<li class="visible-xs"><a href="'. $scripturl. '?action=pm"><span class="fa fa-inbox"></span> '. $txt['pm_short']. ' <span class="label label-primary">' . $context['user']['unread_messages'] . '</span></li>' : '', '
										', ($context['user']['unread_messages'] == 0) ? '' : '<li class="divider visible-xs"></li>', '
										<li><a href="', $scripturl, '?action=logout;' . $context['session_var'] . '=' . $context['session_id']. '"><span class="fa fa-sign-out"></span> ', $txt['logout'], '</a></li>';
								}
								else  {
									echo '
										<li><a href="', $scripturl, '?action=login"><span class="fa fa-sign-in"></span> ', $txt['login'], '</a></li>
										<li><a href="', $scripturl, '?action=register"><span class="fa fa-key"></span> ', $txt['register'], '</a></li>';
								}
								echo '
									</ul>
								</li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="fa fa-search"></span>', $txt['search'], ' <b class="caret"></b></a>
									<ul class="dropdown-menu negative-search">
										<li>
											<div class="row">
												<div class="col-md-12">
													<form role="search" class="navbar-form navbar-left" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">';
												// Search within current topic?
												if (!empty($context['current_topic']))
													echo '
														<input type="hidden" name="sd_topic" value="', $context['current_topic'], '">';
												// If we're on a certain board, limit it to this board ;).
												elseif (!empty($context['current_board']))
													echo '
														<input type="hidden" name="sd_brd[', $context['current_board'], ']" value="', $context['current_board'], '">';
											  
													 echo '
														<div class="input-group">
															<span class="input-group-btn">
																<input placeholder="', $txt['search'], '" class="form-control" type="search" name="search">
																<button type="submit" class="btn btn-primary" name="search2">', $txt['go'], '</button>
															</span>
														</div>
														<input type="hidden" name="advanced" value="0">
													</form>
												</div>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// List the buttons in reverse order for RTL languages.
	if ($context['right_to_left'])
		$button_strip = array_reverse($button_strip, true);

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li' .(isset($value['active']) ? ' class="active"' : '') . '><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . ' buttonlist" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><i class="fa fa-'.$key.' fa-fw"></i> <span class="hidden-xs">' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="', !empty($direction) ? 'pull-' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>
			<ul class="nav nav-pills">',
				implode('', $buttons), '
			</ul>
		</div>';
}

?>