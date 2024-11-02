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
    $techs = Work_technologiesManager::findTechnologiesByWorkId($id);
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
        echo '<div class="work-details-content">';
        echo $work->getContent();
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
