<?php

require_once __DIR__ . '/../model/SubThreadModel.php';
class SubThreadController
{

    public static function getSubThreadsData(int $thread_id, int $limit, int $offset): array
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->getSubThreadsData($thread_id, $limit, $offset);
    }
    public static function addNewSubThread($subThread): int
    {
        $subThreadModel = new SubThreadModel();
        return $subThreadModel->addNewSubThread($subThread);
    }
}