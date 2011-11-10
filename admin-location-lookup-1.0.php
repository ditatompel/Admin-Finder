<?php
error_reporting(0);
/**
 * PHP Admin Location Lookup
 *
 * @version 1.00
 * @author Christian Ditaputratama <ditatompel@gmail.com>
 *
 * Admin location finder for single site.
 * optionally dump scan result to text file.
 * 
 * still very early release, just for testing and coding purpose :)
 * 
 *------------------------------------------------------------------------+
 * This program is free software; you can redistribute it and/or modify   |
 * it under the terms of the GNU General Public License version 2 as      |
 * published by the Free Software Foundation.                             |
 *                                                                        |
 * This program is distributed in the hope that it will be useful,        |
 * but WITHOUT ANY WARRANTY; without even the implied warranty of         |
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          |
 * GNU General Public License for more details.                           |
 *                                                                        |
 * This script are often used solely for informative, educational         |
 * purposes only. Author cannot be held responsible for any               |
 * damage and (or) (ab)use of this script.                                |
 * Please submit changes of the script so other people can use            |
 * them as well. This script is free to use, don't abuse.                 |
 *------------------------------------------------------------------------+
 */
set_time_limit(0);
$greetz = '
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
 PHP Admin Location Lookup by ditatompel < ditatompel [at] gmail [dot] com >
 Please send bug report to help improving this script.
 
 Greetings for all members of devilzc0de.org, all Indonesian c0ders,
 and all GNU Generation ;-)
 Thanks to : 5ynL0rd who always inspire me, I glue you all my regards.
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
';
print $greetz;
if ( $argc < 2) {
	print_r('
-----------------------------------------------------------------------------
    Usage     : php '.$argv[0].' [target] [output]
    target    : domain / url
    output    : file name for Every [+] Wo0t! output will be saved to (optional)
    Example 1 : php '.$argv[0].' myhost.com
    Example 2 : php '.$argv[0].' myhost.com scan_result.txt
-----------------------------------------------------------------------------
');
exit;
}

function doValidLink($link) {
	$validLink = preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $link) ? $link : "http://" . $link;
    return $validLink . '/';
}
function write($text) {
	global $fh;
	fwrite($fh, $text);
}

$url = doValidLink($argv[1]);
$output = $argv[2];

// usual admin login place. Add yours if you want ;p
$adminLookup = array(
	"admin1.php",
	"admin1.html",
	"admin2.php",
	"admin2.html",
	"administrator/",
	"administrator/index.html",
	"administrator/index.php",
	"administrator/login.html",
	"administrator/login.php",
	"administrator/account.html",
	"administrator/account.php",
	"administrator.php",
	"administrator.html",
	"admin/",
	"admin/account.php",
	"admin/account.html",
	"admin/index.php",
	"admin/index.html",
	"admin/login.php",
	"admin/login.html",
	"admin/home.php",
	"admin/controlpanel.html",
	"admin/controlpanel.php",
	"admin.php",
	"admin.html",
	"admin/cp.php",
	"admin/cp.html",
	"adm/",
	"account.php",
	"account.html",
	"admincontrol.php",
	"admincontrol.html",
	"adminpanel.php",
	"adminpanel.html",
	"admin1.asp",
	"admin2.asp",
	"admin/account.asp",
	"admin/index.asp",
	"admin/login.asp",
	"admin/home.asp",
	"admin/controlpanel.asp",
	"admin.asp",
	"admin/cp.asp",
	"administr8.php",
	"administr8.html",
	"administr8/",
	"administr8.asp",
	"yonetim.php",
	"yonetim.html",
	"yonetici.php",
	"yonetici.html",
	"maintenance/",
	"webmaster/",
	"configuration/",
	"configure/",
	"cp.php",
	"cp.html",
	"controlpanel/",
	"controlpanel.php",
	"controlpanel.html",
	"ccms/",
	"ccms/login.php",
	"ccms/index.php",
	"login.php",
	"login.html",
	"modelsearch/login.php",
	"moderator.php",
	"moderator.html",
	"moderator/login.php",
	"moderator/login.html",
	"moderator/admin.php",
	"moderator/admin.html",
	"moderator/",
	"yonetim.asp",
	"yonetici.asp",
	"cp.asp",
	"administrator/index.asp",
	"administrator/login.asp",
	"administrator/account.asp",
	"administrator.asp",
	"login.asp",
	"modelsearch/login.asp",
	"moderator.asp",
	"moderator/login.asp",
	"moderator/admin.asp",
	"account.asp",
	"controlpanel.asp",
	"admincontrol.asp",
	"adminpanel.asp",
	"fileadmin/",
	"fileadmin.php",
	"fileadmin.asp",
	"fileadmin.html",
	"administration/",
	"administration.php",
	"administration.html",
	"sysadmin.php",
	"sysadmin.html",
	"phpmyadmin/",
	"myadmin/",
	"sysadmin.asp",
	"sysadmin/",
	"ur-admin.asp",
	"ur-admin.php",
	"ur-admin.html",
	"ur-admin/",
	"Server.php",
	"Server.html",
	"Server.asp",
	"Server/",
	"webadmin/",
	"webadmin.php",
	"webadmin.asp",
	"webadmin.html",
	"administratie/",
	"admins/",
	"admins.php",
	"admins.asp",
	"admins.html",
	"administrivia/",
	"Database_Administration/",
	"WebAdmin/",
	"useradmin/",
	"sysadmins/",
	"admin1/",
	"system-administration/",
	"administrators/",
	"pgadmin/",
	"directadmin/",
	"staradmin/",
	"ServerAdministrator/",
	"SysAdmin/",
	"administer/",
	"LiveUser_Admin/",
	"sys-admin/",
	"typo3/",
	"panel/",
	"cpanel/",
	"cPanel/",
	"cpanel_file/",
	"platz_login/",
	"rcLogin/",
	"blogindex/",
	"formslogin/",
	"autologin/",
	"support_login/",
	"meta_login/",
	"manuallogin/",
	"simpleLogin/",
	"loginflat/",
	"utility_login/",
	"showlogin/",
	"memlogin/",
	"members/",
	"login-redirect/",
	"sub-login/",
	"wp-login/",
	"wp-admin/",
	"blog/wp-admin/",
	"blog/wp-login/",
	"forum/admin/",
	"login1/",
	"dir-login/",
	"login_db/",
	"xlogin/",
	"smblogin/",
	"customer_login/",
	"UserLogin/",
	"login-us/",
	"acct_login/",
	"admin_area/",
	"bigadmin/",
	"project-admins/",
	"phppgadmin/",
	"pureadmin/",
	"sql-admin/",
	"radmind/",
	"openvpnadmin/",
	"wizmysqladmin/",
	"vadmind/",
	"ezsqliteadmin/",
	"hpwebjetadmin/",
	"newsadmin/",
	"adminpro/",
	"Lotus_Domino_Admin/",
	"bbadmin/",
	"vmailadmin/",
	"Indy_admin/",
	"ccp14admin/",
	"irc-macadmin/",
	"banneradmin/",
	"sshadmin/",
	"phpldapadmin/",
	"macadmin/",
	"administratoraccounts/",
	"admin4_account/",
	"admin4_colon/",
	"radmind-1/",
	"Super-Admin/",
	"AdminTools/",
	"cmsadmin/",
	"SysAdmin2/",
	"globes_admin/",
	"cadmins/",
	"phpSQLiteAdmin/",
	"navSiteAdmin/",
	"server_admin_small/",
	"logo_sysadmin/",
	"server/",
	"database_administration/",
	"power_user/",
	"system_administration/",
	"ss_vms_admin_sm/",
	"websvn/"
);
echo "\r\nChecking " . $url . "\r\n";

// get server headers
$check = get_headers($url, 1);
if ( empty($check)) {
	print_r('
    No repsond from server.
    make sure your target url are correct!
    Exiting...
-----------------------------------------------------------------------------
'); exit;
}
$serverInfo = $check['Server'];
// handle for redirect status.
// replace target path with server redirect location.
if (preg_match('/301/', $check[0]) || preg_match('/302/', $check[0]) ) {
	$url = $check['Location'];
	$serverInfo = $check['Server'][0];
}

$additionalInfo = NULL;
if ( !empty($output) ) {
	$fh = fopen($output, 'w');
	if ($fh) {
		$additionalInfo = 'Every [+] Wo0t! output will be saved on ' . $output;
	}
	else {
		$additionalInfo = '[!] Cannot write scan result to ' . $output;
	}
	
}

$info = '
-----------------------------------------------------------------------------
    Target : ' . $url . '
    Status : ' . $check[0] . '
    Server : ' . $serverInfo . '
    Start Scan : ' . date("Y-m-d H:i:s") . '
    ' . $additionalInfo . '
-----------------------------------------------------------------------------
';
print_r($info);

if ( $fh ) {
	write($greetz);
	write($info);
}

foreach ($adminLookup as $admin){
	$headers = get_headers($url . $admin, 1);
	if ( preg_match('/200/', $headers[0]) ) {
		$result = "[+] Wo0t! " . $url . $admin . " Found!\r\n";
		echo $result;
		if ( $fh ) { write($result); }
	}
	elseif (preg_match('/301/', $headers[0]) || preg_match('/302/', $headers[0]) ) {
		$result = "[+] Wo0t! " . $url . $admin . " Found! redirect to -> " . $headers['Location'] . "\r\n";
		echo $result;
		if ( $fh ) { write($result); }
	}
	else {
		echo "[-] " . $url . $admin . " NOT Found!\r\n";
	}
}
if ( !empty($output) ) {
	write("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- Finish -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\r\n");
	fclose($fh);
}
echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- Finish -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\r\n";
?>