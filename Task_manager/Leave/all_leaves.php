<?php

include('../conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 1px #6366f1;
        }
        .leave-type.selected {
            background-color: #e0e7ff;
            border-color: #6366f1;
        }
        .datepicker-cell.selected {
            background-color: #6366f1 !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 ">
        <div class="w-full max-w-3xl border">
            <!-- Header Section -->
            <div class="gradient-bg text-white rounded-t-xl p-6 text-center">
                <div class="flex justify-center mb-2">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f8201208-9116-4b2f-a868-794dcbb0d91e.png" alt="Company logo with blue and purple gradient, showing a stylized building icon representing the organization" class="h-16 w-auto" />
                    <img src="../asset/img/logo.PNG" alt="Logo" class="logo-img h-16 w-auto " />
                </div>
                <h1 class="text-2xl font-bold mb-2">Leave Applications</h1>
                <p class="opacity-90">View and manage employee leave requests</p>
            </div>

            <!-- Application List -->
            <div class="bg-white p-6 rounded-b-xl card-shadow space-y-6">
                <!-- Filters -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button onclick="filterApplications('all')" class="filter-btn active px-4 py-2 rounded-full border border-blue-500 bg-blue-500 text-white">
                        All
                    </button>
                    <button onclick="filterApplications('pending')" class="filter-btn px-4 py-2 rounded-full border border-gray-300">
                        Pending
                    </button>
                    <button onclick="filterApplications('approved')" class="filter-btn px-4 py-2 rounded-full border border-gray-300">
                        Approved
                    </button>
                    <button onclick="filterApplications('rejected')" class="filter-btn px-4 py-2 rounded-full border border-gray-300">
                        Rejected
                    </button>
                </div>
                <!-- Applications Table -->
              
                <div class="overflow-x-auto">
                  <table class="min-w-full">
                    <thead>
                      <tr class="bg-gray-100 text-left text-gray-600 text-sm">
                        <th class="p-3">Employee</th>
                        <th class="p-3">Leave Type</th>
                        <th class="p-3">Dates</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="leaveTableBody" class="divide-y">
                      <!-- Application rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
                               
            </form>


            <!-- Success Modal -->
            <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white p-8 rounded-lg max-w-md">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check text-green-500 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Application Submitted!</h3>
                        <p class="text-sm text-gray-500 mb-6">
                            Your leave application has been successfully submitted. You will receive a confirmation email shortly.
                        </p>
                        <button onclick="closeModal()"
                                class="gradient-bg text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
            <!-- Pagination -->
            <div id="pagination" class="mt-6"></div>

    </div>

    <!-- EDIT LEAVE MODAL -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl p-6 shadow-2xl w-full max-w-lg relative">

    <button type="button" onclick="closeEditModal()" class="absolute right-3 top-3 text-gray-600 hover:text-gray-900">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="text-xl font-semibold mb-4">Edit Leave</h2>

    <form id="editForm">
      <!-- IMPORTANT: names must match submit_leave.php -->
      <input type="hidden" id="edit_leave_id" name="leave_id">
      <input type="hidden" id="edit_user_code" name="user_code">

      <div class="mb-3">
        <label class="block text-sm">Department</label>
        <input id="edit_department" name="department" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-3">
        <label class="block text-sm">Leave Type</label>
        <input id="edit_type" name="leave_type" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-3">
        <label class="block text-sm">Reason</label>
        <textarea id="edit_reason" name="leave_reason" class="w-full border p-2 rounded"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm">Start Date</label>
          <input id="edit_start" name="start_date" type="date" class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="block text-sm">End Date</label>
          <input id="edit_end" name="end_date" type="date" class="w-full border p-2 rounded" />
        </div>
      </div>

      <div class="mb-3 mt-3">
        <label class="block text-sm">Contact Name</label>
        <input id="edit_contact_name" name="contact_name" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-3">
        <label class="block text-sm">Contact No</label>
        <input id="edit_contact_no" name="contact_no" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-4">
        <label class="block text-sm">Status</label>
        <select id="edit_status" name="status" class="w-full border p-2 rounded">
          <option value="pending">pending</option>
          <option value="approved">approved</option>
          <option value="rejected">rejected</option>
        </select>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded">Cancel</button>
        <button type="submit" class="px-4 py-2 gradient-bg text-white rounded">Save</button>
      </div>
    </form>
  </div>
</div>
<!-- END EDIT MODAL -->


    <script src="../asset/js/leave.js"></script>
</body>
</html>

