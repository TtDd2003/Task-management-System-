<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.css"> -->
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- css styles-->
  <link rel="stylesheet" type="text/css" href="../asset/css/user.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl p-8 form-container">
          <div class="text-center mb-8">
                
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Create User Account</h2>
                <p class="mt-2 text-sm text-gray-600">Join our community today</p>
            </div>
            
            <div id="errorContainer" class="hidden bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p id="errorMessage" class="text-sm text-red-700"></p>
                    </div>
                </div>
            </div>
            
            <!-- form registration start ===== -->
            <form id="registrationForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                         <!-- First name-->
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                        <div class="mt-1 relative">
                            <input id="firstName" name="firstName" type="text" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 input-field focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="error-message text-red-500 text-xs mt-1" id="firstNameError">Please enter a valid first name</div>
                        </div>
                    </div>
                        <!-- last name-->
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <div class="mt-1 relative">
                            <input id="lastName" name="lastName" type="text" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 input-field focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="error-message text-red-500 text-xs mt-1" id="lastNameError">Please enter a valid last name</div>
                        </div>
                    </div>
                </div>
                      <!-- Email   -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 input-field focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div class="error-message text-red-500 text-xs mt-1" id="emailError">Please enter a valid email address</div>
                    </div>
                </div>
            
                          <!-- Password  -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 input-field focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div class="error-message text-red-500 text-xs mt-1" id="passwordError">Password must be at least 8 characters</div>
                    </div>
                </div>
                  <!-- Confirmation  -->
                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="mt-1 relative">
                        <input id="confirmPassword" name="confirmPassword" type="password" autocomplete="new-password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 input-field focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div class="error-message text-red-500 text-xs mt-1" id="confirmPasswordError">Passwords do not match</div>
                    </div>
                </div>
                  <!-- Checkbox -->
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        I agree to the <a href="../about.php" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                    </label>
                    <div class="error-message text-red-500 text-xs mt-1" id="termsError">You must agree to the terms</div>
                </div>
                
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" name='btn'>
                        Register
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a>
                </p>
            </div>
        </div>
        <!-- ====== form end === ------->
        
        <div class="mt-6 p-4 text-center text-xs text-gray-500">
            © 2025 Your Company. All rights reserved.
        </div>
    </div>


     <!-- ✅ Load jQuery before your user.js -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="path/to/user.js"></script>

    <script src="../asset/js/user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>

