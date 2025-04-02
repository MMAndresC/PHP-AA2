<?php

require_once __DIR__ . "/../model/ThemeModel.php";
class ThemeController
{
    public static function getAllThemes(): array
    {
        $themeModel = new ThemeModel();
        return $themeModel->getThemes();
    }

    public static function getTheme(int $id): array
    {
        $themeModel = new ThemeModel();
        return $themeModel->getTheme($id);
    }
}