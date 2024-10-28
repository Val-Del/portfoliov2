<?php
define('BASE_DIR', dirname(__DIR__, 2));  // Adjust the depth to get to the root

function ChargerClasse($classe)
{
	
    // Construct paths relative to the base directory
    $controllerPath = BASE_DIR . "/PHP/CONTROLLER/CLASSE/" . $classe . ".Class.php";
    $managerPath = BASE_DIR . "/PHP/MODEL/MANAGER/" . $classe . ".Class.php";
	
    if (file_exists($controllerPath)) {
        require $controllerPath;
    }
    if (file_exists($managerPath)) {
        require $managerPath;
    }
	
}
spl_autoload_register("ChargerClasse");



function uri()
{
	$uri = $_SERVER['REQUEST_URI'];
	if (substr($uri, strlen($uri) - 1) == "/") // se termine par /
	{
		$uri .= "index.php?";
	}
	else if (in_array("?", str_split($uri))) // si l'uri contient deja un ?
	{
		$uri .= "&";
	}
	else
	{
		$uri .= "?";
	}
	return $uri;
}

function crypte($mot)
{
	return md5(md5($mot));
}

function texte($codeTexte)
{
	$retour=TextesManager::findByCodes($_SESSION['lang'], $codeTexte);;
	if ($retour==false) return $codeTexte;
	return $retour;
}

function afficherPage($page)
{
    // Ensure BASE_DIR is defined at the root of your project
    // define('BASE_DIR', dirname(__DIR__, 2)); // Adjust depth to reach your root directory

    $path = $page[0];
    $nom = $page[1];
    $titre = $page[2];
    $roleRequis = $page[3];
    $api = $page[4];
    if (isset($page[5])) {
        $alternativeCSS = $page[5];
    }
    $roleConnecte = isset($_SESSION["utilisateur"]) ? $_SESSION["utilisateur"]->getRole() : 0;

    if ($roleConnecte >= $roleRequis) {
        if ($api) {
            // Include page using BASE_DIR
            include BASE_DIR . '/' . $path . $nom . '.php';
        } else {
            // Include general layout files using BASE_DIR
            include BASE_DIR . '/PHP/VIEW/GENERAL/Head.php';
            if (isset($alternativeCSS)) {
                echo '<link rel="stylesheet" href="CSS/'.$alternativeCSS.'">';
            }
            if (isset($nom)) {
                switch ($nom) {
                    case 'WorkDetails':
                    case 'Portfolio':
                        include BASE_DIR . '/PHP/VIEW/GENERAL/HeaderPortfolio.php';
                        break;
                    // case 'Home':
                    //     echo '<link rel="stylesheet" href="CSS/home.css">';
                    //     break;
                    default:
                        include BASE_DIR . '/PHP/VIEW/GENERAL/Header.php';
                        break;
                }
            }

            if (isset($_SESSION["utilisateur"]) && stripos($path, "PHP/CONTROLLER/ACTION/") !== 0) {
                include BASE_DIR . '/PHP/VIEW/GENERAL/Nav.php';
            }

            // Include the specific page using BASE_DIR
            include BASE_DIR . '/' . $path . $nom . '.php';

            include BASE_DIR . '/PHP/VIEW/GENERAL/Footer.php';
        }
    } else {
        // If not authorized, redirect to the login form
        $nom = "FormConnexion";
        $titre = "Authorisation insuffisante";

        include BASE_DIR . '/PHP/VIEW/GENERAL/Head.php';
        include BASE_DIR . '/PHP/VIEW/GENERAL/Header.php';
        include BASE_DIR . '/PHP/VIEW/FORM/FormConnexion.php';
        include BASE_DIR . '/PHP/VIEW/GENERAL/Footer.php';
    }
}

// A coder pour décoder les informations base de données dans le json
function decode($texte)
{
	return $texte;
}
$regex = [
	"alpha" => "[A-Za-z]{2,}-?[A-Za-z]{2,}",
	"alphaNum" => "[A-Za-z0-9]*",
	"alphaMaj" => "[A-Z]*",
	"alphaMin" => "[a-z]*",
	"num" => "[0-9]*",
	"ucFirst" => "[A-Z][a-z]+",
	"email" => "[A-Za-z]([\.\-_]?[A-Za-z0-9])+@[A-Za-z]([\.\-_]?[A-Za-z0-9])+\.[A-Za-z]{2,4}",
	"date" => "[0-3]?[0-9](\/|-)(0|1)?[0-9](\/|-)[0-9]{4}",
	"pwd" => "(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}",
	"tel" => "0[0-9]([-/. ]?[0-9]{2}){4}",
	"postal" => "[0-9]{5}",
	"*"  => "*"
];


function appelGet($obj, $chaine)
{
	$methode = 'get' . ucfirst($chaine);
	return call_user_func(array($obj, $methode));
}

/**
 * Crée un select a partir des informations passées en parametre
 *
 * @param integer $valeur => Id de l'element a Selectionner
 * 
 * @param string $table => contient Nom de la table sur laquelle la requête sera effectuée.
	 * Exemple : nomTable => "FROM nomTable"
 * 
 * @param array $nomColonnes => contient le noms des champs désirés dans la requête.
	 * Exemple :  [nomColonne1,nomColonne2] => "SELECT nomColonne1, nomColonne2"
 * 
 * @param string $attributs => attributs attendu dans la balise select
 * 
 * Exemples : <select class="filtrefiche" data-serie=3 >
 * 
 * @param array|null $condition => null par défaut, attendu un tableau associatif 
	 * qui peut prendre plusieurs formes en fonction de la complexité des conditions.
	 *
	 *  Exemples : tableau associatif
	 *  [nomColonne => '1'] => "WHERE nomColonne = 1"
	 *  [nomColonne => ['1','3']] => "WHERE nomColonne in (1,3)"
	 *  [nomColonne => '%abcd%'] => "WHERE nomColonne like "%abcd%"
	 *  [nomColonne => '1->5'] => "WHERE nomColonne BETWEEN 1 and 5 "
	 *  Si il y a plusieurs conditions alors :
	 *  [nomColonne1 => '1', nomColonne2 => '%abcd%' ] => "WHERE nomColonne1 = 1 AND nomColonne2 LIKE "%abcd%"
	 * 
 * @param string|null $orderBy $orderBy => null par défaut, contient un string qui contient les noms de colonnes et le type de tri
	 * Exemple :"nomColonne1 , nomColonne2 DESC" => "Order By nomColonne1 , nomColonne2 DESC"
	 * 
 * @return void
 */
function creerSelect(?int $valeur, string $table, array $nomColonnes, ?string $attributs = "", array $condition = null, string $orderBy = null)
{
		$nomId= $table::getAttributes()[0];
		$select = '<select id="' . $nomId . '" name="' . $nomId . '"' . $attributs . '>';
		$methode = $table . 'Manager';
		$libelle= $nomColonnes;
		array_push($nomColonnes, $nomId);
		$liste = $methode::getList($nomColonnes, $condition, $orderBy);
		if ($valeur == null) {
				$select .= '<option value="" SELECTED>'.texte("inputDefault").'</option>';
		} else {
				$select .= '<option value="">'.texte("inputDefault").'</option>';
		}
		foreach ($liste as $elt) {
				$content = "";
				foreach ($libelle as $value) {
						$content .= appelGet($elt, $value) . " ";
				}
				if ($valeur == appelGet($elt, $nomId)) {
						$select .= '<option value="' . appelGet($elt, $nomId) . '" SELECTED>' . $content . '</option>';
				} else {
						$select .= '<option value="' . appelGet($elt, $nomId) . '">' . $content . '</option>';
				}
			}
		$select .= "</select>";
		return $select;
}

function truncateByChars($string, $limit, $ellipsis = '...') {
    if (strlen($string) > $limit) {
        return substr($string, 0, strpos($string, ' ', $limit)) . $ellipsis;
    }
	// var_dump($string);
    return $string;
}


function showImage($id, $filename, $size = 'regular', $type = 'article', $compressThreshold = 500000) {
    // Define size dimensions
    $sizes = [
        'small' => [100, 100],
        'regular' => [300, 300],
        'regularX' => [400, 400],
        'xl' => [600, 600],
        'xxl' => [800, 800]
    ];

    // Determine the size dimensions
    if (!isset($sizes[$size])) {
        return false; // Invalid size requested
    }
    list($newWidth, $newHeight) = $sizes[$size];

    // Path to the original image
    $originalImagePath = "IMG/{$filename}";

    // If the original image does not exist, return a default image
    if (!file_exists($originalImagePath)) {
        return 'IMG/default.jpg'; // Default image path
    }

    // Create folder for the resized images if it doesn't exist
    $folderPath = "IMG/{$type}_{$id}";
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Extract file name without extension
    $newName = pathinfo($filename, PATHINFO_FILENAME);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Path for the resized image
    $sizePath = "$folderPath/{$newName}_$size.$extension";

    // If the resized image already exists, return the path
    if (file_exists($sizePath)) {
        return $sizePath;
    }

    // Resize and create the image
    $newImg = resizeImage($originalImagePath, $newWidth, $newHeight);

    // Get the original file size to check if compression is needed
    $fileSize = filesize($originalImagePath); // File size in bytes
    if ($fileSize > $compressThreshold) {
        compressImage($newImg, $sizePath, 80); // Compress the resized image with quality 80 for JPEG
    } else {
        saveImage($newImg, $sizePath, 100); // Save without compression, using quality 100
    }

    // Return the path to the resized image
    return $sizePath;
}

function compressImage($imgResource, $sizePath, $quality = 80) {
    // Determine format based on file extension
    $extension = pathinfo($sizePath, PATHINFO_EXTENSION);
    
    switch (strtolower($extension)) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($imgResource, $sizePath, $quality); // Compress JPEG with quality
            break;
        case 'png':
            imagepng($imgResource, $sizePath, min(9, floor($quality / 10))); // Compress PNG (0-9 scale)
            break;
        case 'gif':
            imagegif($imgResource, $sizePath); // GIF does not support quality adjustment
            break;
    }
    imagedestroy($imgResource); // Free memory
}

function saveImage($imgResource, $sizePath, $quality = 100) {
    // Same logic as compressImage but default to highest quality
    compressImage($imgResource, $sizePath, $quality);
}

function resizeImage($originalImagePath, $newWidth, $newHeight) {
    // Get the original image dimensions and file type
    list($width, $height, $imageType) = getimagesize($originalImagePath);

    // Calculate aspect ratio
    $originalAspect = $width / $height;
    $newAspect = $newWidth / $newHeight;

    // Determine cropping dimensions to maintain aspect ratio
    if ($originalAspect >= $newAspect) {
        // Original is wider than the target aspect ratio
        $tempHeight = $height;
        $tempWidth = (int)($height * $newAspect);
        $cropX = (int)(($width - $tempWidth) / 2); // Center cropping on X-axis
        $cropY = 0;
    } else {
        // Original is taller than the target aspect ratio
        $tempWidth = $width;
        $tempHeight = (int)($width / $newAspect);
        $cropY = (int)(($height - $tempHeight) / 2); // Center cropping on Y-axis
        $cropX = 0;
    }

    // Create a new image resource with the target dimensions
    $newImg = imagecreatetruecolor($newWidth, $newHeight);

    // Create the original image resource based on its type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $originalImage = imagecreatefromjpeg($originalImagePath);
            break;
        case IMAGETYPE_PNG:
            $originalImage = imagecreatefrompng($originalImagePath);
            // Maintain transparency for PNG
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            break;
        case IMAGETYPE_GIF:
            $originalImage = imagecreatefromgif($originalImagePath);
            break;
        default:
            return false; // Unsupported image type
    }

    // Resize and crop the original image to fit the target dimensions
    imagecopyresampled(
        $newImg,          // Destination image
        $originalImage,   // Source image
        0, 0,             // Destination X and Y
        $cropX, $cropY,   // Source X and Y (for cropping)
        $newWidth, $newHeight, // Destination width and height
        $tempWidth, $tempHeight // Source width and height after cropping
    );

    // Free memory from the original image resource
    imagedestroy($originalImage);

    return $newImg; // Return the resized and cropped image resource
}
