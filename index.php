<?php

include __DIR__ . "/PHP/CONTROLLER/Outils.php";  // Absolute path


spl_autoload_register("ChargerClasse");

Parametres::init();

DbConnect::init();

session_start();

$routes = [
	// "Default" => ["PHP/VIEW/FORM/", "FormConnexion", "Connexion", 0, false],
	"Home" => ["PHP/VIEW/GENERAL/", "Home", "", 0, false],
	"Erreur" => ["PHP/VIEW/GENERAL/", "Erreur", "titreErreur", 0, false],
	//AJAX
	"ActionPath" => ["PHP/CONTROLLER/ACTION/", "ActionPath", "ActionPath", 0, true],
];

if (isset($_GET["page"])) {
	$page = $_GET["page"];
	if (isset($routes[$page])) {
		AfficherPage($routes[$page]);
	} else {
		AfficherPage($routes["Home"]);
	}
} else {
	AfficherPage($routes["Home"]);
}
