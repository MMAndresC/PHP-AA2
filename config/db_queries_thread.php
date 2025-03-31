<?php

/* Consulta tabla thread*/

//const GET_THREAD_BY_THEME = "SELECT t. FROM thread t INNER JOIN WHERE theme_id = :theme_id ORDER BY updated_at DESC";
const GET_THREAD_BY_THEME = "SELECT t.id, t.title, t.status, t.updated_at, u1.username as updater, u2.username as author 
FROM thread t
INNER JOIN user u1 ON u1.email = t.last_updater 
INNER JOIN sub_thread st ON t.id = st.thread_id AND st.main = TRUE
INNER JOIN user u2 ON st.author = u2.email
WHERE t.theme_id = :theme_id ORDER BY t.updated_at DESC";

const INSERT_THREAD = "INSERT INTO thread (theme_id, title, status, last_updater) VALUES (:theme_id, :title, :status, :last_updater)";