<?php
// Load Hobo base
$hobo = require('application/base.php');
// Load configuration
$hobo->config('public/config.json');
// Apply configuration settings
$hobo->apply();

// Use $hobo->db to fetch data from database
$hobo->db->query('SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname');
$hobo->db->bind(':lname', 'Slusny');
$row = $hobo->db->fetchRow();
$hobo->set('user', $row['FName'].' '.$row['LName']);
$hobo->session->start();
$hobo->session->set('test','This is session var');
$hobo->cookie->set('test','This is cookie');

function raintpl($hobo, $params) {
	$hobo->rain->assign('URL', $hobo->get('URL'));
	$hobo->rain->assign('user', $hobo->get('user'));
	$hobo->rain->assign('title','Rain TPL test &middot; Hobo MVC');
	$hobo->rain->assign('heading','<a href="http://www.raintpl.com/">Rain TPL</a> test');
	$hobo->rain->assign('content','This page was loaded using Rain TPL template engine extension');
	$hobo->rain->assign('session', $hobo->session->toArray());
	$hobo->rain->assign('cookie', $hobo->cookie->toArray());
	$hobo->rain->draw('default');
}

function index($hobo, $params) {
	// Set global variables what can be used in view
	$hobo->set('title','HoboMVC');
	$hobo->set('heading','Hello World!');
	$hobo->set('content','This is Hello World index page using Hobo MVC Framework');
	$hobo->set('session',$hobo->session->toArray());
	$hobo->set('cookie',$hobo->cookie->toArray());
	// Render view
	$hobo->draw('views/default.php');
}

function markdown($hobo, $params) {
	// Set global variables what can be used in view
	$hobo->set('title','Markdown test &middot; Hobo MVC');
	$hobo->set('heading','Markdown test using <a href="http://www.parsedown.org/">Parsedown.php</a>');
	$file = file_get_contents('README.md');
	$content = '<div style="text-align: left;">'.$hobo->md->text($file).'</div>';
	$hobo->set('content',$content);
	$hobo->set('session',$hobo->session->toArray());
	$hobo->set('cookie',$hobo->cookie->toArray());
	// Render view
	$hobo->draw('views/default.php');
}

function error($hobo, $params) {
	// Set global variables what can be used in view
	$hobo->set('title','Page not found &middot; HoboMVC');
	$hobo->set('heading','404!');
	$hobo->set('content','This is not the web page you are looking for.');
	$hobo->set('session',$hobo->session->toArray());
	$hobo->set('cookie',$hobo->cookie->toArray());
	// Render view
	$hobo->draw('views/default.php');
}

$hobo->run();