<?php

/* Consulta tabla thread*/

const GET_TITLE_STATUS = "SELECT title, status FROM thread WHERE id = :thread_id";
const GET_THREAD_BY_THEME = "SELECT t.*, u.username as updater 
FROM thread t
LEFT JOIN user u ON u.email = t.last_updater 
WHERE t.theme_id = :theme_id ORDER BY t.updated_at DESC";

const GET_THREAD_BY_ID = "SELECT * FROM thread WHERE id = :thread_id";

const INSERT_THREAD = "INSERT INTO thread (theme_id, title, status, last_updater, created_by) VALUES (:theme_id, :title, :status, :last_updater, :last_updater)";
const DELETE_THREAD = "DELETE FROM thread WHERE id = :thread_id";

const UPDATE_THREAD = "UPDATE thread SET  theme_id = :theme_id, status = :status, updated_at = NOW(),
last_updater = :last_updater, title = :title WHERE id = :thread_id";