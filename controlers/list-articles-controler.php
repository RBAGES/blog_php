<?php

require_once PATH_MODELS.'Article.php';

$articles = Article::all();

include_once PATH_VIEWS . 'list-articles.php';