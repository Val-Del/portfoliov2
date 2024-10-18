<?php
$path = $_GET['path'];
$path = filter_var($path, FILTER_SANITIZE_URL);

// Use "C:/" as the default if the path does not start with "C:/"
if (strpos($path, 'C:/') !== 0) {
    $path = 'C:/';
}

$src = 'IMG/maximize.png';
if (isset($_GET['size'])) {
    $src = 'IMG/minimize.png';
}

if (substr($path, -4) === '.pdf') {
    $file = substr($path, strrpos($path, '/') + 1);
    echo '<div class="pdf frontWindow">';
        echo '<div class="controls flex">';
            $parentPath = dirname($path) . '/';
            echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
            echo '<img class="maximize" src="' . $src . '" alt="change the window size">';
            echo '<img class="close" src="IMG/cross.png" alt="close the window">';
        echo '</div>';
        echo '<iframe src="./PDF/' . $file . '" width="100%" height="600px"></iframe>';
    echo '</div>';
} else {
    $otherPaths = PathsManager::getList(null, ['path' => $path]);
    echo '<div class="folder frontWindow">';
        echo '<div class="controls flex">';
            $parentPath = dirname($path) . '/';
            echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
            echo '<img class="maximize" src="' . $src . '" alt="change the window size">';
            echo '<img class="close" src="IMG/cross.png" alt="close the window">';
        echo '</div>';
        echo '<nav class="dir">';
            echo '<input class="dirInput" value="' . $path . '">';
        echo '</nav>';

        echo '<ul class="icons icons-folder">';
        foreach ($otherPaths as $otherPath) {
            echo '<li ';
            if ($otherPath->getType() === 'PDF') {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '.pdf"';
                echo '><img class="pdf-icon" src="IMG/pdf54x54.png" alt="pdf icon">';
            } elseif ($otherPath->getType() === 'User') {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '/"';
                echo '><img class="icon-pfp" src="IMG/pfp.jpg" alt="A picture of the beautiful developer">';
            } elseif ($otherPath->getType() === 'Desktop') {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '/"';
                echo '><img src="IMG/desktop.png" alt="Desktop icon">';
            } else {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '/"';
                echo '><img src="IMG/folder48x48.png" alt="folder icon">';
            }
            echo '<p class="no-select align-txt">' . str_replace('-', ' ', $otherPath->getName()) . '</p>';
            echo '</li>';
        }
        echo '</ul>';
    echo '</div>';
}
