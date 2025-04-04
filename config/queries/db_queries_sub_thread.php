<?php

const GET_SUB_THREADS_BY_THREAD_ID = "SELECT * FROM `sub_thread` WHERE `thread_id` = :thread_id";
const GET_SUB_THREAD_BY_ID = "SELECT * FROM `sub_thread` WHERE `id` = :sub_thread_id";

const GET_SUB_THREADS_DATA = "SELECT st.*, u.role, u.username, u.image_name FROM `sub_thread` st 
LEFT JOIN `user` u ON u.email = st.author
WHERE `thread_id` = :thread_id ORDER BY st.created_at ASC";
const INSERT_SUB_THREAD = "INSERT INTO `sub_thread` (thread_id, author, content, main) VALUES (:thread_id, :author, :content, :main)";
const DELETE_SUB_THREAD = "DELETE FROM `sub_thread` WHERE `id` = :sub_thread_id";
const UPDATE_CONTENT_SUB_THREAD = "UPDATE `sub_thread` SET `content` = :content, `updated_at` = NOW() WHERE `id` = :sub_thread_id";