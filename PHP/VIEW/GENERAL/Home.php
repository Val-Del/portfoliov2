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
    <ul class=icons>
        <?php
                $pathsDesktop = PathsManager::getList(null, ['path'=>'C:/Valentin/Desktop/']);
                $i = 0;
                foreach ($pathsDesktop as $pathDesktop) {
                    $i++;
                    echo '<li data-draggable="true" data-path="'.$pathDesktop->getPath().'" style="grid-column-start: 1; grid-row-start: '.$i.'">';
                        switch ($pathDesktop->getType()) {
                            case 'PDF':
                                echo '<img src="IMG/pdf54w.png" alt="pdf icon">';
                                break;
                            case 'Folder':
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
    <div id="windows">
        <!-- <div id=flashcardsWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Flashcards.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=blogWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Blog.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=linkedinWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Linkedin.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=migrationWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Migration.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=karumanyWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Karumany.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=refactoringWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Refactoring.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=hospitalWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Hospital.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=menuWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Restaurant-menu.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=botWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Python_bot.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=restaurantWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/Restaurant.pdf" width="100%" height="600px">
            </iframe>
        </div>
        <div id=ecommerceWindow class="pdf hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe src="./PDF/E-commerce.pdf" width="100%" height="600px">
            </iframe>
        </div> -->
        <div id=resumeWindow class="resume hide">
            <div class="controls">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <iframe id=iframe-pdf src="./PDF/Resume-Valentin_Bruneel.pdf" width="100%" height="900px">
            </iframe>
            <div class="overlay-pdf"></div>
        </div>
        <!-- <div id=projectsWindow class="folder hide"> -->
            <!-- <div class="controls">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <ul class="projects icons-folder">
                <li id=2022>
                    <img src="IMG/folder48x48.png" alt="icon of a folder">
                    <p class=no-select>2022</p>
                </li>
                <li id=2023>
                    <img src="IMG/folder48x48.png" alt="icon of a folder">
                    <p class=no-select>2023</p>
                </li>
                <li id=2024>
                    <img src="IMG/folder48x48.png" alt="icon of a folder">
                    <p class=no-select>2024</p>
                </li>
            </ul>
        </div> -->

        <!-- years projects -->

        <!-- <div id=2022Window class="folder hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <ul class=icons-folder>
                <li id=karumanyPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Karumany</p>
                </li>
                <li id=linkedinPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Linkedin Bot</p>
                </li>
            </ul>
        </div> -->
        <!-- <div id=2023Window class="folder hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <ul class=icons-folder>
                <li id=restaurantMenuPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Restaurant menu</p>
                </li>
                <li id=refactoringPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Refactoring</p>
                </li>
                <li id=hospitalPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Hospital</p>
                </li>
                <li id=migrationPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Migration</p>
                </li>
            </ul>
        </div> -->
        <!-- <div id=2024Window class="folder hide">
            <div class="controls flex">
                <img class=back src="IMG/back-arrow.png" alt="return to the previous window">
                <img class=close src="IMG/cross.png" alt="close the window">
            </div>
            <ul class=icons-folder>
                <li id=restaurantPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Restaurant</p>
                </li>
                <li id=botPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Bot python</p>
                </li>
                <li id=flashcardsPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">Flashcards extension</p>
                </li>
                <li id=ecommercePDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">E-commerce</p>
                </li>
                <li id=blogPDF>
                    <img src="IMG/pdf54w.png" alt="pdf icon">
                    <p class="no-select align-txt">AI blog</p>
                </li>
            </ul>
        </div> -->
    </div>
</main>