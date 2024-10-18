<main>
    <div id="warning">
        <p>The website is primarily designed for computers.</p>
        <img id=closeWarning src="IMG/crossWhite.png" alt="close the warning">
    </div>
    <div class=loging-overlay></div>
    <div class=loging>
        <div class=pfp>
            <img src="IMG/pfp.jpg" alt="A picture of the beautiful developer">
        </div>
        <p>Valentin Bruneel</p>
        <div class="windows11-login-container">
            <input id="login-password" type=text value=developer123 class="windows11-login-password">
            <span id="icon-next" class="icon-next"></span>
        </div>
    </div>
    <ul class='icons icons-desktop'>
        <?php
                $pathsDesktop = PathsManager::getList(null, ['path'=>'C:/Valentin/Desktop/']);
                $i = 0;
                foreach ($pathsDesktop as $pathDesktop) {
                    $i++;
                    echo '<li data-draggable="true" style="grid-column-start: 1; grid-row-start: '.$i.'" data-path="'.$pathDesktop->getPath().$pathDesktop->getName().'';
                        switch ($pathDesktop->getType()) {
                            case 'PDF':
                                echo '.pdf" >';
                                echo '<img src="IMG/pdf54x54.png" alt="pdf icon">';
                                break;
                            case 'Folder':
                                echo '/" >';
                                echo '<img src="IMG/folder48x48.png" alt="folder icon">';
                                break;
                            default:
                                break;
                        }
                        echo '<p class=no-select>'.$pathDesktop->getName().'</p>';
                    echo '</li>';
                }
        ?>
    </ul>
</main>