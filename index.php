<?php
	ob_start();
	session_start();
	error_reporting(0); // kapatmak için 0 yaz, hataları görmek için E_ALL
	define('INCONAY', true);
	date_default_timezone_set('Europe/Istanbul');

	require_once('class/connect.php');
	require_once('class/functions.php');

	require_once('php/header.php');
	require_once('class/processing.php');

	switch($_GET['page'])
	{
		case 'home': require_once('sayfalar/home.php'); break;
		case 'news': require_once('sayfalar/news.php'); break;
		case 'register': require_once('sayfalar/register.php'); break;
		case 'lostpass': require_once('sayfalar/lostpass.php'); break;
		case 'logout': require_once('sayfalar/logout.php'); break;
		case 'cp': require_once('sayfalar/cp.php'); break;
		case 'mb': require_once('sayfalar/mb.php'); break;
		case 'account': require_once('sayfalar/account.php'); break;
		case 'profile': require_once('sayfalar/profile.php'); break;
		case 'players': require_once('sayfalar/players.php'); break;
		case 'rules': require_once('sayfalar/rules.php'); break;
		case 'char': require_once('sayfalar/char.php'); break;
		case 'applications': require_once('sayfalar/applications.php'); break;
		case 'ucp_applications': require_once('sayfalar/ucp_applications.php'); break;
		case 'control': require_once('sayfalar/control.php'); break;
		case 'settings': require_once('sayfalar/settings.php'); break;
		case 'skin': require_once('sayfalar/skin.php'); break;
		case 'chars': require_once('sayfalar/chars.php'); break;
		case 'donator': require_once('sayfalar/donator.php'); break;
		case 'staff': require_once('sayfalar/staff.php'); break;
		case 'mychar': require_once('sayfalar/mychar.php'); break;
		case 'newchar': require_once('sayfalar/newchar.php'); break;
		case 'adminarea': require_once('sayfalar/adminarea.php'); break;
		case 'add_staff': require_once('sayfalar/add_staff.php'); break;
		case 'remove_staff': require_once('sayfalar/remove_staff.php'); break;
		case 'gameprofile': require_once('sayfalar/gameprofile.php'); break;
		default: require_once('sayfalar/home.php'); break;
	}


	require_once('php/footer.php');
	ob_end_flush();
?>
