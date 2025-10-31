<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="../asset/css/leave.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-3xl">
            <!-- Header Section -->
            <div class="gradient-bg text-white rounded-t-xl p-6 text-center">
                <div class="flex justify-center mb-2">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f8201208-9116-4b2f-a868-794dcbb0d91e.png" alt="Company logo" class="h-16 w-auto" />
                    <img src="../asset/img/logo.PNG" alt="Logo" class="logo-img h-16 w-auto " />
                </div>
                <h1 class="text-2xl font-bold mb-2">Leave Application</h1>
                <p class="opacity-90">Submit your leave request with all necessary details</p>
            </div>

            <!-- Main Form -->
            <form id="leaveForm" class="bg-white p-6 rounded-b-xl card-shadow space-y-6" method="POST" action="submit_leave.php">
                
                <!-- Employee Info Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-user mr-2 text-blue-500"></i>Employee Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="employeeId" class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
                            <input type="text" id="employeeId" name="user_code" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" 
                                   placeholder="EMP-1234" required>
                        </div>
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select id="department" name="department" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" required>
                                <option value="" disabled selected>Select Department</option>
                                <option value="IT">IT</option>
                                <option value="HR">Human Resources</option>
                                <option value="Finance">Finance</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Operations">Operations</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Leave Details Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>Leave Details
                    </h2>
                    
                    <!-- Leave Type Selection -->
                    <div class="mb-6">
                        <p class="block text-sm font-medium text-gray-700 mb-2">Leave Type</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Casual Leave" onclick="selectLeaveType(this)">
                                <i class="fas fa-umbrella-beach text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Casual Leave</p>
                            </div>
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Sick Leave" onclick="selectLeaveType(this)">
                                <i class="fas fa-procedures text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Sick Leave</p>
                            </div>
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Earned Leave" onclick="selectLeaveType(this)">
                                <i class="fas fa-award text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Earned Leave</p>
                            </div>
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Maternity" onclick="selectLeaveType(this)">
                                <i class="fas fa-baby text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Maternity</p>
                            </div>
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Paternity" onclick="selectLeaveType(this)">
                                <i class="fas fa-child text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Paternity</p>
                            </div>
                            <div class="leave-type cursor-pointer p-3 border rounded-md text-center transition-colors" data-type="Other" onclick="selectLeaveType(this)">
                                <i class="fas fa-ellipsis-h text-blue-500 text-xl mb-1"></i>
                                <p class="text-sm">Other</p>
                            </div>
                        </div>
                        <input type="hidden" id="leaveType" name="leave_type" required>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" id="startDate" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" required>
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" id="endDate" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" required>
                        </div>
                    </div>

                    <!-- Reason for Leave -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Leave</label>
                        <textarea id="reason" name="leave_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" placeholder="Please provide details about your leave..." required></textarea>
                    </div>
                </div>

                <!-- Contact During Leave -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-phone-alt mr-2 text-blue-500"></i>Emergency Contact
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="contactName" class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                            <input type="text" id="contactName" name="contact_name" class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" placeholder="Name of emergency contact">
                        </div>
                        <div>
                            <label for="contactNumber" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="tel" id="contactNumber" name="contact_no" class="w-full px-3 py-2 border border-gray-300 rounded-md input-focus" placeholder="Emergency contact number">
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="pt-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <input type="checkbox" id="acknowledge" name="acknowledge" class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 mr-2" >
                            <label for="acknowledge" class="text-sm text-gray-700">I acknowledge that the information provided is accurate</label>
                        </div>
                        <button type="submit" name="btn" class="gradient-bg text-white px-6 py-2 rounded-md hover:opacity-90 transition-opacity">Submit Application</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


<!-- jQuery must come first -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Now your JS file that uses jQuery -->
 <script src="../asset/js/leave.js"></script>

  
</body>
</html>
