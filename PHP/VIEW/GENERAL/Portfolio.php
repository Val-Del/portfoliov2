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
            <a class=os target="_blank" href="?page=Desktop">See my work through a different perspective.</a>
            <nav class="social">
                <ul class="flex">
                    <li>LinkedIn</li>
                    <li>Github</li>
                </ul>
            </nav>
        </section>
        <section class="work flex">
            <?php
            $works = WorksManager::getList();
            if ($works) {
                foreach ($works as $work) {
                    if ($work->getVisible()) {
                        echo '<a href=?page=WorkDetails&id='.$work->getId().' class=card>';
                                echo '<img src=IMG/'.$work->getThumbnail().'></img>';
                                echo '<div class=overlay>';
                                    echo '<h4>'.$work->getName().'</h4>';
                                    $techs = Work_technologiesManager::findTechnologiesByWorkId($work->getId());
                                    if ($techs) {
                                        echo '<p class="technologies">';
                                        $tech = '';
                                        foreach ($techs as $techItem) {
                                            $tech .= $techItem['name'] . ', ';
                                        }
                                        $tech = rtrim($tech, ', ');
                                        echo $tech;
                                        echo '</p>';
                                    }
                                    
                                echo '</div>';
                        echo '</a>';
                       
                    }
                }
            }
            ?>
        </section>
    </div>
    <div class="right"></div>
</main>