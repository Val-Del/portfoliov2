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
    ?>
    </div>
    <div class="right"></div>
</main>
