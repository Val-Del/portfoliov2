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
                    $content = $work->getContent();
                    $modifiedContent = $content; // Copy to store modified content
            
                    // Match <img> tags
                    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
            
                    foreach ($matches[0] as $key => $imgTag) {
                        $originalSrc = $matches[1][$key]; // Original src
                        $filename = basename($originalSrc); // Filename from src
                        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Get file extension
            
                        // Check if it's a GIF
                        if ($extension === 'gif') {
                            // For GIFs, keep the original src without creating a srcset
                            $modifiedImgTag = $imgTag; // No modification for GIFs
                        } else {
                            // Process non-GIF images with showImage for responsive srcset
                            $srcSmall = showImage($filename, 'small');   // For phones
                            $srcRegularX = showImage($filename, 'regularX'); // For tablets
            
                            // Construct the srcset attribute for responsive images
                            $srcset = "$srcSmall 400w, $srcRegularX 600w, $originalSrc 800w";
            
                            // Use sizes to control which image is loaded based on viewport width
                            $sizes = "(max-width: 599px) 400px, (max-width: 1024px) 600px, 800px";
            
                            // Replace the original <img> tag with the modified version including srcset and sizes
                            $modifiedImgTag = preg_replace(
                                '/src=["\'][^"\']+["\']/', 
                                'src="' . $originalSrc . '" srcset="' . $srcset . '" sizes="' . $sizes . '"', 
                                $imgTag
                            );
                        }
            
                        // Update the modified content with the processed img tag
                        $modifiedContent = str_replace($imgTag, $modifiedImgTag, $modifiedContent);
                    }
            
                    // Output the modified content
                    echo '<div class="work-details-content">';
                    echo $modifiedContent;
                    echo '</div>';
                    // echo '<div class="work-details-content">' . $work->getContent() . '</div>';
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
        echo'
        <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
            <img src="IMG/slider3.jpg" alt="Description of image 1">
            <p class="slide-caption">Caption for image 1</p>
            </div>
            <div class="swiper-slide">
            <img src="IMG/slider2.jpg" alt="Picture in France">
            <p class="slide-caption">Carnival, Dunkirk, France</p>
            </div>
            <div class="swiper-slide">
            <img src="IMG/slider3.jpg" alt="Picture from a plane">
            <p class="slide-caption">Over Spain</p>
            </div>
            <div class="swiper-slide">
            <img src="IMG/slider4.jpg" alt="Me and my wife">
            <p class="slide-caption">Making sure world\'s biggest pistachio is not falling down with my wifey</p>
            </div>
            <div class="swiper-slide">
            <img src="IMG/slider5.jpg" alt="Me visiting Roswell">
            <p class="slide-caption">Visiting Roswell</p>
            </div>
            <div class="swiper-slide">
            <img src="IMG/slider6.jpg" alt="Image of my dog">
            <p class="slide-caption">With my 10-month-old giant pup</p>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        </div>
        ';
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
