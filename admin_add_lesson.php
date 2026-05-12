<?php
session_start();
include 'db.php';

// Security: Sirf Admin hi is page ko khol sakay
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$message = "";

if(isset($_POST['add_lesson'])){
    $course_id = $_POST['course_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);

    $sql = "INSERT INTO lessons (course_id, lesson_title, video_url) VALUES ('$course_id', '$title', '$video_url')";
    
    if(mysqli_query($conn, $sql)){
        $message = "Lesson successfully added!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Courses ki list nikalna takay dropdown mein nazar aaein
$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin - Add Lesson</title>
</head>
<body class="bg-gray-100 flex">

    <div class="w-64 bg-emerald-900 min-h-screen text-white p-6">
        <h2 class="text-2xl font-bold mb-10">Admin Panel</h2>
        <nav class="space-y-4">
            <a href="admin_dashboard.php" class="block p-3 hover:bg-emerald-700 rounded-lg">View Students</a>
            <a href="admin_add_lesson.php" class="block p-3 bg-emerald-700 rounded-lg">Add New Lesson</a>
            <a href="logout.php" class="block p-3 text-red-400">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-10">
        <div class="max-w-2xl bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-3xl font-bold text-emerald-900 mb-6 text-center text-center">Add New Video Lesson</h2>
            
            <?php if($message != "") echo "<p class='bg-emerald-100 text-emerald-700 p-3 rounded-lg mb-4 font-bold'>$message</p>"; ?>

            <form action="admin_add_lesson.php" method="POST" class="space-y-6">
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Select Course</label>
                    <select name="course_id" class="w-full p-4 bg-gray-50 border rounded-2xl outline-emerald-500" required>
                        <option value="">-- Choose Course --</option>
                        <?php while($row = mysqli_fetch_assoc($courses)): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['course_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-2">Lesson Title</label>
                    <input type="text" name="title" placeholder="e.g. Lesson 1: Introduction" class="w-full p-4 bg-gray-50 border rounded-2xl outline-emerald-500" required>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-2">Video Link (YouTube/Drive)</label>
                    <input type="text" name="video_url" placeholder="https://youtube.com/..." class="w-full p-4 bg-gray-50 border rounded-2xl outline-emerald-500" required>
                </div>

                <button type="submit" name="add_lesson" class="w-full bg-emerald-800 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-emerald-900 transition">
                    Upload Lesson
                </button>
            </form>
        </div>
    </div>

</body>
</html>