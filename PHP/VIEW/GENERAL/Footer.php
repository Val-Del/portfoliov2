<footer>
</footer>
<?php
if (isset($nom)) {
    switch ($nom) {
        case 'Desktop':
            echo '<script type="module" src="./JS/os.js"></script>';
            break;
        case 'Portfolio':
            echo '<script type="module" src="./JS/portfolio.js"></script>';
            break;
        case 'Home':
            echo '<script type="module" src="./JS/home.js"></script>';
            break;
        default:
            break;
    }
}
echo '</body>
</html>';