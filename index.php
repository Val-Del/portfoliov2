<?php

include __DIR__ . "/PHP/CONTROLLER/Outils.php";  // Absolute path


spl_autoload_register("ChargerClasse");

Parametres::init();

DbConnect::init();

session_start();

$routes = [
	// "Default" => ["PHP/VIEW/FORM/", "FormConnexion", "Connexion", 0, false],
	// "Home" => ["PHP/VIEW/GENERAL/", "Home", "Home", 0, false, 'home.css'],
	"Resume" => ["PHP/VIEW/GENERAL/", "Resume", "Resume", 0, false],
	"Desktop" => ["PHP/VIEW/GENERAL/", "Desktop", "Desktop", 0, false, 'desktop.css'],
	"Portfolio" => ["PHP/VIEW/GENERAL/", "Portfolio", "Portfolio", 0, false, 'portfolio.css'],
	"WorkDetails" => ["PHP/VIEW/GENERAL/", "WorkDetails", "WorkDetails", 0, false, 'portfolio.css'],
	"Erreur" => ["PHP/VIEW/GENERAL/", "Erreur", "titreErreur", 0, false],
	//AJAX
	"ActionPath" => ["PHP/CONTROLLER/ACTION/", "ActionPath", "ActionPath", 0, true],
	"Generate" => ["PHP/CONTROLLER/ACTION/", "Generate", "Generate", 0, false]
];

if (isset($_GET["page"])) {
	$page = $_GET["page"];
	if (isset($routes[$page])) {
		AfficherPage($routes[$page]);
	} else {
		AfficherPage($routes["Portfolio"]);
	}
} else {
	AfficherPage($routes["Portfolio"]);
}
