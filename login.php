<?php
session_start();

// Database Connection - Name updated to match your SQL command
$conn = mysqli_connect("localhost", "root", "", "quran_academey");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user exists
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Sessions set karein
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];

        // Role ke mutabiq redirect karein
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quran Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="index.php" class="inline-flex items-center gap-2 text-emerald-800 font-bold text-2xl">
                <i class="fa-solid fa-book-quran text-yellow-500"></i>
                <span>Noor Al-Quran</span>
            </a>
        </div>

        <div class="glass border border-white shadow-2xl rounded-3xl p-8">
            <h2 class="text-3xl font-extrabold text-emerald-900 mb-2">Welcome Back</h2>
            <p class="text-gray-500 mb-8">Please enter your details to login.</p>

            <?php if($error != ""): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 flex items-center gap-3 border border-red-100">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="text-sm font-medium"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-emerald-900 mb-2 ml-1">Email Address</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required 
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                            placeholder="admin@gmail.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-emerald-900 mb-2 ml-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required 
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm py-2">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"> Remember me
                    </label>
                    <a href="#" class="text-emerald-700 font-bold hover:underline">Forgot Password?</a>
                </div>

                <button type="submit" name="login" 
                    class="w-full bg-emerald-800 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-emerald-900 transform active:scale-[0.98] transition-all duration-200">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center text-gray-600 text-sm">
    Don't have an account? 
    <a href="register.php" class="text-emerald-700 font-bold hover:underline">Register here</a>
</div>
        </div>
    </div>

</body>
</html>