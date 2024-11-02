<body>
    <header class=flex>
        <div class="left"></div>
        <div class="content flex">
            <nav class=main>
                <?php 
                $portefolio = $resume = '';
                if (isset($_GET['page'])) {
                    $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['page']);
                    switch ($page) {
                        case 'Portfolio':
                            $portefolio = 'highlight';
                            break;
                        case 'Resume':
                            $resume = 'highlight';
                            break;
                        case 'WorkDetails':
                            break;
                        default:
                            $portefolio = 'highlight';
                            break;
                    }
                }else {
                    $portefolio = 'highlight';
                }
               
                ?>
                <ul class=flex>
                     <li><a class="<?= $portefolio ?>" href="?page=Portfolio">Work</a></li>
                    <li><a target="_blank" href="?page=Resume">Resume</a></li>
                </ul>
            </nav>
            <h1 class="name">
                Valentin Bruneel
            </h1>
            <nav class="social">
                <ul class="flex">
                    <li><a href="https://www.linkedin.com/in/valentin-bruneel-7880a8202/" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                    <li><a href="https://github.com/Val-Del?tab=repositories" target="_blank" rel="noopener noreferrer">Github</a></li>
                </ul>
            </nav>
        </div>
        <div class="right"></div>
    </header>