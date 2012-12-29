<?php
/*
 * Advanced Sidebox Module
 *
 * Welcome (install)
 *
 * This module is part of the Advanced Sidebox  default module pack. It can be installed and uninstalled like any other module. Even though it is included in the original installation, it is not necessary and can be completely removed by deleting the containing folder (ie modules/thisfolder).
 *
 * If you delete this folder from the installation pack this module will never be installed (and everything should work just fine without it). Don't worry, if you decide you want it back you can always download them again. The best move would be to install the entire package and try them out. Then be sure that the packages you don't want are uninstalled and then delete those folders from your server.
 *
 * This is a default portal box. Any changes from portal.php (MyBB 1.6.9) will be noted here.
 */
 
// Include a check for Advanced Sidebox
if(!defined("IN_MYBB") || !defined("ADV_SIDEBOX"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

/*
 * This function is required. If it is missing the add-on will not install.
 */
function welcome_is_installed()
{
	global $db;
	
	// works just like a plugin
	$query = $db->simple_select('templates', 'title', "title='adv_sidebox_welcome'");
	return $db->num_rows($query);
}

/*
 * This function is required. Make your mods here.
 */
function welcome_install()
{
	global $db;
	
	// the parent template for the welcome box
	$template_1 = array(
        "title" => "adv_sidebox_welcome",
        "template" => "<table border=\"0\" cellspacing=\"{\$theme[\'borderwidth\']}\" cellpadding=\"{\$theme[\'tablespace\']}\" class=\"tborder\">
	<tr>
		<td class=\"thead\"><strong>{\$lang->welcome}</strong></td>
	</tr>
	<tr>
		<td class=\"trow1\">
			{\$welcometext}
		</td>
	</tr>
</table><br />",
        "sid" => -1
    );
	$db->insert_query("templates", $template_1);
	
	// a child template of the welcome box (member)
	$template_2 = array(
        "title" => "adv_sidebox_welcome_membertext",
        "template" => "<span class=\"smalltext\"><em>{\$lang->member_welcome_lastvisit}</em> {\$lastvisit}<br />
{\$lang->since_then}<br />
<strong>&raquo;</strong> {\$lang->new_announcements}<br />
<strong>&raquo;</strong> {\$lang->new_threads}<br />
<strong>&raquo;</strong> {\$lang->new_posts}<br /><br />
<a href=\"{\$mybb->settings[\'bburl\']}/search.php?action=getnew\">{\$lang->view_new}</a><br /><a href=\"{\$mybb->settings[\'bburl\']}/search.php?action=getdaily\">{\$lang->view_todays}</a>
</span>",
        "sid" => -1
    );
	$db->insert_query("templates", $template_2);
	
	// a child template of the welcome box (guest state)
	$template_3 = array(
        "title" => "adv_sidebox_welcome_guesttext",
        "template" => "<span class=\"smalltext\">{\$lang->guest_welcome_registration}</span><br />
<br />
<form method=\"post\" action=\"{\$mybb->settings[\'bburl\']}/member.php\"><input type=\"hidden\" name=\"action\" value=\"do_login\" />
	<input type=\"hidden\" name=\"url\" value=\"{\$portal_url}\" />
	{\$username}<br />&nbsp;&nbsp;<input type=\"text\" class=\"textbox\" name=\"username\" value=\"\" /><br /><br />
	{\$lang->password}<br />&nbsp;&nbsp;<input type=\"password\" class=\"textbox\" name=\"password\" value=\"\" /><br /><br />
	<label title=\"{\$lang->remember_me_desc}\"><input type=\"checkbox\" class=\"checkbox\" name=\"remember\" value=\"yes\" /> {\$lang->remember_me}</label><br /><br />
	<br /><input type=\"submit\" class=\"button\" name=\"loginsubmit\" value=\"{\$lang->login}\" />
</form>",
        "sid" => -1
    );
	$db->insert_query("templates", $template_3);
}

/*
 * This function is required. Clean up after yourself.
 */
function welcome_uninstall()
{
	global $db;
	
	// delete all the boxes of this custom type and the template as well
	$db->query("DELETE FROM " . TABLE_PREFIX . "sideboxes WHERE box_type='" . $db->escape_string('{$welcome}') . "'");
	$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE title='adv_sidebox_welcome'");
	$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE title='adv_sidebox_welcome_membertext'");
	$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE title='adv_sidebox_welcome_guesttext'");
}

?>