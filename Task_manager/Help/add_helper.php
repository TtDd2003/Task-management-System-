<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Helper - Find Your Perfect Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../asset/css/help.css">
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <i class="fas fa-hands-helping text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Find Your Perfect Task Helper</h1>
            <p class="text-gray-600 text-lg">Add a helper to assist you in completing your important tasks</p>
        </div>

        <!-- Form Container -->
        <div class="form-container rounded-xl shadow-2xl p-6 md:p-8 lg:p-10">
              <form id="helperForm" class="space-y-6" method="post" action="submit_help.php">
            <!-- Helper Information Section -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="relative">
                    <input type="text" name="helper_name" id="helperName" class="floating-input w-full px-4 py-3 border border-gray-300 rounded-lg input-focus" placeholder=" ">
                    <label for="helperName" class="floating-label left-4 text-gray-500">Helper's Full Name</label>
                </div>
                                
                <div class="relative">
                    <select name="helper_role" id="helperRole" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus bg-white">
                        <option value="">Select Helper Role</option>
                        <option value="technical">Technical Assistant</option>
                        <option value="creative">Creative Helper</option>
                        <option value="administrative">Administrative Support</option>
                        <option value="research">Research Assistant</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Task Information Section -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                    <i class="fas fa-tasks mr-2"></i> Task Title
                </h3>
                
                <div class="relative mb-4">
                    <input type="text" name="task_title" id="taskTitle" class="floating-input w-full px-4 py-3 border border-gray-300 rounded-lg input-focus" placeholder=" ">
                    <label for="taskTitle" class="floating-label left-4 text-gray-500">Task Details</label>
                </div>
                
                <div class="relative">
                    <textarea name="task_description" id="taskDescription" rows="4" class="floating-input w-full px-4 py-3 border border-gray-300 rounded-lg input-focus resize-none" placeholder=" "></textarea>
                    <label for="taskDescription" class="floating-label left-4 text-gray-500">Task Description</label>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="relative">
                        <input type="date" name="deadline" id="deadline" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus">
                        <span class="absolute right-3 top-3 text-gray-400"></span>
                    </div>
                    
                    <div class="relative">
                        <input type="number" name="estimated_hours" id="estimatedHours" min="1" max="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus" placeholder="Estimated hours">
                        <span class="absolute right-3 top-3 text-gray-400"><i class="fas fa-clock"></i></span>
                    </div>
                </div>
            </div>

            <!-- Priority Level -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Priority Level</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="flex flex-col items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                        <input type="radio" name="priority" value="low" class="sr-only" required>
                        <i class="fas fa-arrow-down text-green-500 text-xl mb-2"></i>
                        <span class="text-sm font-medium">Low</span>
                    </label>
                    <label class="flex flex-col items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                        <input type="radio" name="priority" value="medium" class="sr-only">
                        <i class="fas fa-minus text-yellow-500 text-xl mb-2"></i>
                        <span class="text-sm font-medium">Medium</span>
                    </label>
                    <label class="flex flex-col items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                        <input type="radio" name="priority" value="high" class="sr-only">
                        <i class="fas fa-arrow-up text-red-500 text-xl mb-2"></i>
                        <span class="text-sm font-medium">High</span>
                    </label>
                </div>
             </div>


            <!-- Submit Button -->
            <button type="submit" class="submit-btn w-full py-4 px-6 text-white font-semibold rounded-lg shadow-md">
                <i class="fas fa-user-plus mr-2"></i> Add Helper & Assign Task
            </button>

        </form>

            <!-- Success Message (Initially hidden) -->
            <div id="successMessage" class="hidden mt-8 p-6 bg-green-50 border border-green-200 rounded-lg text-center">
                <div class="success-checkmark flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check check-icon"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-800 mb-2">Helper Added Successfully!</h3>
                <p class="text-green-600">Your helper has been notified and can now assist you with your task.</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center text-gray-600 text-sm">
            <p>Your helper will receive an invitation email with all the task details</p>
        </div>
    </div>

   <script src="../asset/js/help.js"></script>
</body>
</html>

