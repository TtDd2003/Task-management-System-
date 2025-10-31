<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Help Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .faq-item {
            transition: all 0.3s ease;
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .active .faq-answer {
            max-height: 500px;
        }
        .active .faq-toggle {
            transform: rotate(45deg);
        }
        .logo-img{width: 20%;}
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-indigo-700 text-white">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            
             <div class="d-flex align-items-center col-2 ps-0 bg-dark">
                <img src="asset/img/logo.PNG" alt="Logo" class="logo-img" />
                
              </div>
            
            <button class="md:hidden">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/14cd20cd-8239-4d4c-af1e-18538e84f105.png" alt="Mobile menu icon - three horizontal white lines" class="h-6">
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">How can we help you today?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Find answers to common questions or get in touch with our support team.</p>
            <div class="max-w-2xl mx-auto relative">
                <input type="text" placeholder="Search help articles..." class="w-full py-4 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800">
                <button class="absolute right-2 top-2 bg-indigo-700 text-white p-2 rounded-full">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/d960fc5a-a7e2-43be-bf09-447c5930cf82.png" alt="Magnifying glass icon for search functionality" class="h-5">
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Help Categories -->
            <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-md h-fit">
                <h3 class="text-xl font-bold mb-4 text-indigo-700">Help Categories</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="block py-2 px-4 rounded hover:bg-indigo-50 text-indigo-600 font-medium">Getting Started</a></li>
                    <li><a href="#" class="block py-2 px-4 rounded bg-indigo-100 text-indigo-700 font-medium">FAQs</a></li>
                    <li><a href="#" class="block py-2 px-4 rounded hover:bg-indigo-50 text-indigo-600 font-medium">Task Management</a></li>
                    <li><a href="#" class="block py-2 px-4 rounded hover:bg-indigo-50 text-indigo-600 font-medium">Collaboration</a></li>
                    <li><a href="User/user_profile.php" class="block py-2 px-4 rounded hover:bg-indigo-50 text-indigo-600 font-medium">Account Settings</a></li>
                    <li><a href="#" class="block py-2 px-4 rounded hover:bg-indigo-50 text-indigo-600 font-medium">Billing</a></li>
                </ul>
            </div>

            <!-- FAQ Section -->
            <div class="md:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Frequently Asked Questions</h2>
                    
                    <div class="space-y-4">
                        <!-- Getting Started Section -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3 border-b pb-2">Getting Started</h3>
                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group active">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">How do I create my first task?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>To create your first task:</p>
                                <ol class="list-decimal pl-5 mt-2 space-y-1">
                                    <li>Click the "+ New Task" button in the top right corner</li>
                                    <li>Enter a clear task title and description</li>
                                    <li>Set a due date and priority level if needed</li>
                                    <li>Assign the task to yourself or a team member</li>
                                    <li>Click "Create Task" to add it to your list</li>
                                </ol>
                            </div>
                        </div>

                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">Can I import tasks from other apps?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>Yes! Task Manger  supports importing tasks from several popular apps:</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>Trello (CSV export/import)</li>
                                    <li>Asana (through our dedicated importer)</li>
                                    <li>Google Tasks (via our Chrome extension)</li>
                                    <li>Any spreadsheet with our CSV template</li>
                                </ul>
                                <p class="mt-2">Visit Settings > Import to get started.</p>
                            </div>
                        </div>

                        <!-- Task Management Section -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3 border-b pb-2">Task Management</h3>
                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">How do I set up recurring tasks?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>To create a recurring task:</p>
                                <ol class="list-decimal pl-5 mt-2 space-y-1">
                                    <li>Create a new task or edit an existing one</li>
                                    <li>Click on the "Repeat" option below the due date</li>
                                    <li>Choose your recurrence pattern (daily, weekly, monthly)</li>
                                    <li>Set the end date if required</li>
                                    <li>Save the task - it will automatically regenerate based on your settings</li>
                                </ol>
                            </div>
                        </div>

                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">What's the difference between labels and categories?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>Labels and categories help organize tasks differently:</p>
                                <div class="grid md:grid-cols-2 gap-4 mt-2">
                                    <div class="bg-blue-50 p-3 rounded">
                                        <p class="font-medium text-blue-700">Categories</p>
                                        <p class="text-sm">Fixed groups (like "Work", "Personal") that help segment tasks by area of life. Each task can have one category.</p>
                                    </div>
                                    <div class="bg-purple-50 p-3 rounded">
                                        <p class="font-medium text-purple-700">Labels</p>
                                        <p class="text-sm">Flexible tags (like "Urgent", "Client A") that allow cross-category organization. Tasks can have multiple labels.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Collaboration Section -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3 border-b pb-2">Collaboration</h3>
                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">How do I share a task with a team member?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>Sharing tasks with teammates is easy:</p>
                                <ol class="list-decimal pl-5 mt-2 space-y-1">
                                    <li>Open the task you want to share</li>
                                    <li>Click on the "Assign" dropdown in the top right</li>
                                    <li>Start typing the team member's name or email</li>
                                    <li>Select the person from the list</li>
                                    <li>They'll receive a notification about the shared task</li>
                                </ol>
                                <p class="mt-2">Note: You can only share tasks with users in your organization.</p>
                            </div>
                        </div>

                        <div class="faq-item border-b pb-3">
                            <div class="flex justify-between items-center cursor-pointer group">
                                <h4 class="text-lg font-medium text-indigo-600 group-[.active]:text-indigo-800">Can I get notifications when tasks are updated?</h4>
                                <span class="faq-toggle text-xl text-indigo-500">+</span>
                            </div>
                            <div class="faq-answer mt-2 text-gray-700">
                                <p>Yes, TaskFlow offers flexible notification options:</p>
                                <div class="mt-2 space-y-2">
                                    <p><span class="font-medium">Browser notifications:</span> Enable in Settings > Notifications</p>
                                    <p><span class="font-medium">Email alerts:</span> Choose which updates trigger emails</p>
                                    <p><span class="font-medium">Mobile push:</span> Available in our iOS and Android apps</p>
                                    <p><span class="font-medium">Daily digest:</span> Get a summary of all updates at your preferred time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Need Help Section -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4 text-indigo-700">Still need help?</h3>
                    <p class="mb-6">Our support team is here to assist you. Send us a message and we'll get back to you within 24 hours.</p>
                    
                    <form class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                            <input type="text" id="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <select id="subject" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select a topic</option>
                                <option value="account">Account Help</option>
                                <option value="billing">Billing Questions</option>
                                <option value="features">Feature Requests</option>
                                <option value="bugs">Report a Bug</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/adba1b22-f73c-4ceb-8dbd-7cf274630983.png" alt="TaskFlow logo mark in white" class="h-10">
                        <h3 class="text-xl font-bold">TaskFlow</h3>
                    </div>
                    <p class="text-gray-300">The intuitive task management platform for teams and individuals.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">API Documentation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Community Forum</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Status Page</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Contact Us</a></li>
                    </ul>
                </div>

                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#"><img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/0c842c8c-fc4a-4391-b91c-768d545e916d.png" alt="Twitter social media icon" class="h-6"></a>
                    <a href="#"><img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f8ef9cf8-ae75-43b2-8f4b-5f5faf75fa11.png" alt="Facebook social media icon" class="h-6"></a>
                    <a href="#"><img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/a2c0fc89-97f5-4887-9907-8cef5f156833.png" alt="LinkedIn social media icon" class="h-6"></a>
                    <a href="#"><img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/abdab21b-5b92-40ce-b2fe-2c8756596104.png" alt="Instagram social media icon" class="h-6"></a>
                </div>
            </div>
                
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 flex justify-center items-center">
  <p class="text-gray-300 text-center">© 2025 TaskFlow. All rights reserved.</p>
</div>

    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ toggle functionality
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const toggle = item.querySelector('.faq-toggle');
                item.addEventListener('click', () => {
                    item.classList.toggle('active');
                    // Close other open FAQs when opening a new one
                    if(item.classList.contains('active')) {
                        faqItems.forEach(otherItem => {
                            if(otherItem !== item && otherItem.classList.contains('active')) {
                                otherItem.classList.remove('active');
                            }
                        });
                    }
                });
            });

            // Form submission
            const form = document.querySelector('form');
            if(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Show confirmation message
                    alert('Thank you for your message! Our team will get back to you soon.');
                    form.reset();
                });
            }
        });
    </script>
</body>
</html>

