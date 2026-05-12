<?php
session_start();
// Database Connection
$conn = mysqli_connect("localhost", "root", "", "quran_academey");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$messageClass = "";

if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'student'; // Default role is student

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $message = "This email is already registered!";
        $messageClass = "bg-red-100 text-red-700 border-red-200";
    } else {
        // Insert user into database
        $sql = "INSERT INTO users (full_name, email, password, role) VALUES ('$full_name', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Registration Successful! You can now login.";
            $messageClass = "bg-emerald-100 text-emerald-700 border-emerald-200";
            // Optional: Redirect to login after 2 seconds
            header("refresh:2;url=login.php");
        } else {
            $message = "Error: " . mysqli_error($conn);
            $messageClass = "bg-red-100 text-red-700 border-red-200";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Now - Quran Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0fdf4; font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-lg">
        <div class="text-center mb-6">
            <a href="index.php" class="text-emerald-800 font-bold flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Website
            </a>
        </div>

        <div class="glass-card shadow-2xl rounded-[2rem] p-8 md:p-10 border border-emerald-100">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-emerald-900 mb-2">Create Account</h1>
                <p class="text-gray-500">Join our Academy and start your Quranic journey today.</p>
            </div>

            <?php if($message != ""): ?>
                <div class="<?php echo $messageClass; ?> p-4 rounded-xl mb-6 border flex items-center gap-3">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="text-sm font-bold"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-emerald-900 mb-2 ml-1">Full Name</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600"></i>
                        <input type="text" name="full_name" required 
                            class="w-full pl-11 pr-4 py-4 bg-emerald-50/50 border border-emerald-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                            placeholder="Muhammad Ilyas">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-emerald-900 mb-2 ml-1">Email Address</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600"></i>
                        <input type="email" name="email" required 
                            class="w-full pl-11 pr-4 py-4 bg-emerald-50/50 border border-emerald-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                            placeholder="ilyas@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-emerald-900 mb-2 ml-1">Set Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600"></i>
                        <input type="password" name="password" required 
                            class="w-full pl-11 pr-4 py-4 bg-emerald-50/50 border border-emerald-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" name="register" 
                    class="w-full bg-emerald-800 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-emerald-900 transform active:scale-95 transition-all duration-200 text-lg mt-4">
                    Register Now
                </button>
            </form>

            <div class="mt-8 text-center text-gray-600">
                Already have an account? 
                <a href="login.php" class="text-emerald-700 font-bold hover:underline">Sign In</a>
            </div>
        </div>
    </div>

</body>
</html>