<main class="main flex">
    <div class="left"></div>
    <div class="content">
        <section class="me">
            <h3 class="title">
                Full Stack Developer
            </h3>
            <p class="description">
                Hello! I'm a Full Stack Developer with a strong foundation in application development and web design.
            </p>
        </section>
        <section class="work flex">
            <?php
            $works = WorksManager::getList();
            if ($works) {
                foreach ($works as $work) {
                    if ($work->getVisible()) {
                        echo '<div class=card>';
                                echo '<img src=IMG/'.$work->getThumbnail().'></img>';
                                echo '<div class=overlay>';
                                    echo '<h4>'.$work->getName().'</h4>';
                                echo '</div>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </section>
    </div>
    <div class="right"></div>
</main>