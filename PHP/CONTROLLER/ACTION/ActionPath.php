<?php
$path = $_GET['path'];
$path = filter_var($path, FILTER_SANITIZE_URL);

// Use "C:/" as the default if the path does not start with "C:/"
if (strpos($path, 'C:/') !== 0) {
    $path = 'C:/';
    $noreturn = true;
}

$src = 'IMG/maximize.png';
if (isset($_GET['size'])) {
    $src = 'IMG/minimize.png';
}
if (substr($path, -4) === '.pdf') {
    $file = substr($path, strrpos($path, '/') + 1);
    echo '<div class="pdf frontWindow">';
        echo '<div class="controls flex">';
            if (!isset($noreturn)) {
                $parentPath = dirname($path) . '/';
                echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
            }
            echo '<img class="maximize" src="' . $src . '" alt="change the window size">';
            echo '<img class="close" src="IMG/cross.png" alt="close the window">';
        echo '</div>';
        echo '<iframe src="./PDF/' . $file . '" width="100%" height="600px"></iframe>';
    echo '</div>';
} elseif (str_contains($path, '&workId=')) {
    $startPos = strpos($path, '&workId=') + strlen('&workId=');

    $workId = '';

    // Loop through each character after `&workId=` to extract the integer part
    while ($startPos < strlen($path) && is_numeric($path[$startPos])) {
        $workId .= $path[$startPos];
        $startPos++;
    }

    $workId = (int)$workId;
    $work = WorksManager::findById($workId);

    if ($work) {
        echo '<div class="pdf frontWindow">';
            echo '<div class="controls flex">';
                if (!isset($noreturn)) {
                    // Remove the last segment
                    $parentPath = preg_replace('~[^/]+/$~', '', dirname($path) . '/');
                    
                    echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
                }
            
                echo '<img class="maximize" src="' . $src . '" alt="change the window size">';
                echo '<img class="close" src="IMG/cross.png" alt="close the window">';
            echo '</div>';

        // Begin main content section
        echo '<main class="main flex scrollable-element">';
            echo '<div class="content work-details ">';

                // Display work details
                echo '<h1>' . ucfirst($work->getName()) . '</h1>';

                if ($work->getDescription()) {
                    echo '<p class="description">' . $work->getDescription() . '</p>';
                }

                // Display technologies
                $techs = Work_technologiesManager::findTechnologiesByWorkId($workId);
                if ($techs) {
                    echo '<ul class="techs flex">';
                    foreach ($techs as $tech) {
                        echo '<li>' . $tech['name'] . '</li>';
                    }
                    echo '</ul>';
                }

                // Display work content
                if ($work->getContent()) {
                    echo '<div class="work-details-content">' . $work->getContent() . '</div>';
                }

                // Display other works by order
                // if ($work->getDisplay_order()) {
                //     echo '<h3>Other Works</h3>';
                //     echo '<div class="flex other-works">';

                //     $previousWorkDisplay = $work->getDisplay_order() - 1;
                //     $nextWorkDisplay = $work->getDisplay_order() + 1;

                //     $previousWork = WorksManager::getList(null, ['display_order' => $previousWorkDisplay]);
                //     $nextWork = WorksManager::getList(null, ['display_order' => $nextWorkDisplay]);

                //     if ($previousWork) {      
                //         $previousWork = $previousWork[0];
                //         $previousWork->displayAsCard();
                //     } else {
                //         // Show the last work if no previous work
                //         $lastWork = WorksManager::getList(null, ['display_order' => '(SELECT MAX(display_order) FROM works)']);
                //         $lastWork = $lastWork[0];
                //         $lastWork->displayAsCard();
                //     }

                //     if ($nextWork) {      
                //         $nextWork = $nextWork[0];
                //         $nextWork->displayAsCard();
                //     } else {
                //         // Show the first work if no next work
                //         $firstWork = WorksManager::getList(null, ['display_order' => '(SELECT MIN(display_order) FROM works)']);
                //         $firstWork = $firstWork[0];
                //         $firstWork->displayAsCard();
                //     }

                //     echo '</div>'; // Close other works div
                // }

            echo '</div>'; // Close content div
        echo '</main>';
        echo '</div>'; // Close pdf frontWindow div
    }
}


elseif (substr($path, -4) === '/Bio'){
    echo '<div class="folder pictures frontWindow">';
        echo '<div class="controls flex">';
        if (!isset($noreturn)) {
            $parentPath = dirname($path) . '/';
            echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
        }
            echo '<img class="maximize" src="' . $src . '" alt="change the window size">';
            echo '<img class="close" src="IMG/cross.png" alt="close the window">';
        echo '</div>';
        // echo '<nav class="dir">';
        //     echo '<input class="dirInput" value="' . $path . '">';
        // echo '</nav>';
        $imageArr = [
            "https://images.pexels.com/photos/28874274/pexels-photo-28874274.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" => "Fidon text number 1",
            "https://images.pexels.com/photos/208321/pexels-photo-208321.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" => "Figcaption text number 2",
            "https://images.pexels.com/photos/620337/pexels-photo-620337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" => "Figcaption text number 3",
            "https://images.pexels.com/photos/206359/pexels-photo-206359.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" => "Figcaption text number 4",
            "https://images.pexels.com/photos/417074/pexels-photo-417074.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" => "Figcaption text number 5"
        ];
        
        echo '
        <div class="slider">
            <div class="container">
                <!-- Top section with arrows and main image frame -->
                <div class="top">
                    <i class="fas fa-chevron-left arrow left"></i>
                    <div class="frame">
                        <div class="slide">';
        
        foreach ($imageArr as $imageSrc => $caption) {
            echo '
                            <figure>
                                <img class="image" src="' . $imageSrc . '" alt="Slider Image" data-caption="' . htmlspecialchars($caption) . '">
                            </figure>';
        }
        
        echo '
                        </div>
                    </div>
                    <i class="fas fa-chevron-right arrow right"></i>
                </div>
        
                <!-- Caption section outside of the main figure -->
                <p class="caption">' . reset($imageArr) . '</p> <!-- Display the caption of the first image initially -->
        
                <!-- Bottom section for thumbnails -->
                <div class="bottom">';
        
        foreach ($imageArr as $imageSrc => $caption) {
            echo '<img class="thumbnail" src="' . $imageSrc . '" alt="Thumbnail">';
        }
        
        echo '
                </div>
            </div>
        </div>';
    echo '</div>';
}
else {
    $otherPaths = PathsManager::getList(null, ['path' => $path], 'display_order');
    echo '<div class="folder frontWindow">';
        echo '<div class="controls flex">';
        if (!isset($noreturn)) {
            $parentPath = dirname($path) . '/';
            echo '<img data-path="' . $parentPath . '" class="back" src="IMG/back-arrow.png" alt="return to the previous window">';
        }
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
            } elseif ($otherPath->getType() === 'Work') {
                $workId = $otherPath->getId_work();
                $work = WorksManager::findById($workId);
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '/&workId='.$workId.'"';
                echo ' class="work"><img src="IMG/'.$work->getThumbnail().'" alt="Icon of a project">';
            }elseif ($otherPath->getType() === 'Pictures') {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '"';
                echo '><img src="IMG/picture.png" alt="pictures icon">';
            }else {
                echo 'data-path="' . $otherPath->getPath() . $otherPath->getName() . '/"';
                echo '><img src="IMG/folder126x126.png" alt="folder icon">';
            }
            echo '<p class="no-select align-txt">' . str_replace('-', ' ', $otherPath->getName()) . '</p>';
            echo '</li>';
        }
        echo '</ul>';
    echo '</div>';
}
