<?php

require_once __DIR__ . "/../model/ThreadModel.php";
class ThreadController
{
    public static function getThreadsByTheme(int $theme_id): array
    {
        $threadModel = new ThreadModel();
        return $threadModel->getThreadsByTheme($theme_id);
    }
}