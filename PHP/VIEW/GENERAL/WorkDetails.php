<main class="main flex">
    <div class="left"></div>
    <div class="content work-details">
    <?php
    $id = (int)$_GET['id'];
    $work = WorksManager::findById($id);
    if ($work) {
        echo '<h1>'.ucfirst($work->getName()).'</h1>';
    }
    if ($work->getDescription()) {
        echo '<p class=description>';
        echo $work->getDescription();
        echo '</p>';
    }
    $techs = Work_TechnologiesManager::findTechnologiesByWorkId($id);
    if ($techs) {
        // var_dump($techs);
        echo '<ul class="techs flex">';
        foreach ($techs as $tech) {
            echo '<li>';
            echo $tech['name'];
            echo '</li>';
        }
        echo '</ul>';
    }
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

        
    }
    if ($work->getDisplay_order()) {
        echo '<h3>Other Works</h3>';
        echo '<div class="flex other-works">';
        $previousWorkDisplay = $work->getDisplay_order() -1;
        $nextWorkDisplay = $work->getDisplay_order() +1;
        $previousWork = WorksManager::getList(null, ['display_order'=>$previousWorkDisplay]);
        $nextWork= WorksManager::getList(null, ['display_order'=>$nextWorkDisplay]);
        if ($previousWork) {      
            $previousWork = $previousWork[0];
            $previousWork->displayAsCard();
        }else{
            // Get the last work by display_order
            $lastWork = WorksManager::getList(null, ['display_order' => '(SELECT MAX(display_order) FROM works)']);
            $lastWork = $lastWork[0];
            $lastWork->displayAsCard();

        }
        if ($nextWork) {      
            $nextWork = $nextWork[0];
            $nextWork->displayAsCard();
        }else {
            //last work, we show first one
            $firstWork = WorksManager::getList(null, ['display_order' => '(SELECT MIN(display_order) FROM works)']);
            $firstWork = $firstWork[0];
            $firstWork->displayAsCard();
        }
        echo '</div>';
    }
    ?>
    </div>
    <div class="right"></div>
</main>
