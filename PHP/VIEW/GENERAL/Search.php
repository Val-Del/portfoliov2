<?php
if (isset($_POST['s'])) {
    $search = htmlspecialchars($_POST['s'], ENT_QUOTES, 'UTF-8');
    if (strlen($_POST['s']) > 1) {
        $conditions = [
            'name' => '%' . $search . '%'
        ];
        // $categories = CategoriesManager::getList(['name', 'id', 'description'], $conditions, null, 4, false, false);
        $articles = ArticlesManager::getList(['id', 'title', 'excerpt','content'], [
            'title' => '%' . $search . '%',
            'status' => 'published'
        ], 'published_at', 10, false, false);
        if (empty($articles)) {
            echo '0 results';
            echo '<br>';
        }
    } else {
        echo 'Search too short';
    }
} else {
    echo 'Empty search';
}

// if (!empty($categories)) {
//     foreach ($categories as $category) {
//         echo $category->getName();
//         echo '<br>';
//         echo $category->getDescription();
//     }
// } else {
// }
echo '<div class="articles-container">';
if (!empty($articles)) {

    foreach ($articles as $article) {
        echo '<div class="article-item">';
             displayArticle($article);
        echo '</div>';
        // echo $article->getTitle();
        // echo '<br>';
        // echo $article->getExcerpt();
        // echo '<br>';
    }
}
echo '</div>';
