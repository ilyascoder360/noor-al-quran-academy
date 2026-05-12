<?php
// Database connection using your folder-based name
$conn = mysqli_connect("localhost", "root", "", "quran_academey");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>