<?php

require_once __DIR__ . '/../model/SubThreadModel.php';
class SubThreadController
{
    public static function addNewSubThread($subThread): int
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->addNewSubThread($subThread);
    }
}