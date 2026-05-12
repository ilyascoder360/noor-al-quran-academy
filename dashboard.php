<?php session_start(); if(!isset($_SESSION['student'])) { header("Location: login.php"); } ?>

<div class="flex h-screen bg-gray-100">
    <div class="w-64 bg-emerald-800 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">LMS Panel</h2>
        <ul>
            <li class="mb-4"><a href="#" class="hover:text-yellow-400">My Courses</a></li>
            <li class="mb-4"><a href="#" class="hover:text-yellow-400">Video Lessons</a></li>
            <li class="mb-4"><a href="logout.php" class="text-red-300">Logout</a></li>
        </ul>
    </div>

    <div class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-6">Welcome, Student!</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded-xl shadow">
                <h3 class="font-bold mb-2">Lesson 1: Tajweed Basics</h3>
                <iframe class="w-full aspect-video rounded" src="https://drive.google.com/preview?id=YOUR_VIDEO_ID"></iframe>
            </div>
        </div>
    </div>
</div>