<?php

/* Consulta tabla thread*/

const GET_TITLE_STATUS = "SELECT title, status FROM thread WHERE id = :thread_id";
const GET_THREAD_BY_THEME = "SELECT t.id, t.title, t.status, t.updated_at, u1.username as updater, u2.username as author 
FROM thread t
INNER JOIN user u1 ON u1.email = t.last_updater 
INNER JOIN sub_thread st ON t.id = st.thread_id AND st.main = TRUE
INNER JOIN user u2 ON st.author = u2.email
WHERE t.theme_id = :theme_id ORDER BY t.updated_at DESC";

const GET_THREAD_BY_ID = "SELECT * FROM thread WHERE id = :thread_id";

const INSERT_THREAD = "INSERT INTO thread (theme_id, title, status, last_updater) VALUES (:theme_id, :title, :status, :last_updater)";
const DELETE_THREAD = "DELETE FROM thread WHERE id = :thread_id";

const UPDATE_THREAD = "UPDATE thread SET  theme_id = :theme_id, status = :status, updated_at = NOW(),
last_updater = :last_updater, title = :title WHERE id = :thread_id";