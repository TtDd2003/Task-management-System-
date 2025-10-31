<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Tri Tech Solutions</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

  <style>
    /* Custom scroll for better aesthetic */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #bfa15a;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #a6873f;
    }
  </style>
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="flex items-center gap-4 p-6 bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-700 sticky top-0 z-30">
    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-tr from-yellow-500 via-yellow-400 to-yellow-600 shadow-[0_0_15px_#d4af37]">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-yellow-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 18h6M10 22h4M12 2a6 6 0 0 1 6 6c0 2-1 4-3 5a3 3 0 1 1-6 0c-2-1-3-3-3-5a6 6 0 0 1 6-6z" />
      </svg>
    </div>
    <div>
      <h1 class="text-3xl font-serif font-semibold text-yellow-400 drop-shadow-md tracking-wide">
        Tri Tech <span class="text-yellow-300">Solutions</span>
      </h1>
      <p class="text-xs font-mono uppercase tracking-widest text-yellow-600">Task Manager</p>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow container mx-auto px-6 py-10 max-w-7xl">

    <!-- About & Support Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <!-- About Article -->
      <article data-aos="zoom-in" class="bg-gray-800 rounded-lg shadow-lg p-8 border border-yellow-600 transform transition duration-500 hover:scale-150 hover:z-20 hover:shadow-yellow-400/40">
        <h2 class="text-2xl font-semibold mb-4 text-yellow-400">About Tri Tech Solutions</h2>
        <p class="mb-4 leading-relaxed text-gray-300">
          At Tri Tech Solutions, we combine innovation with technology to deliver efficient and scalable software solutions.
          Our flagship product, the <strong>Tri Tech Task Manager</strong>, helps businesses streamline project workflows and boost productivity through intelligent task management.
        </p>
        <ul class="list-disc list-inside text-gray-300 space-y-2">
          <li>Founded with a passion for empowering teams</li>
          <li>Focused on user-friendly and cutting-edge software</li>
          <li>Committed to 24/7 customer support and continuous improvements</li>
        </ul>
      </article>

      <!-- Support Article -->
      <article data-aos="zoom-in" class="bg-gray-800 rounded-lg shadow-lg p-8 border border-yellow-600 transform transition duration-500 hover:scale-150 hover:z-20 hover:shadow-yellow-400/40">
        <div>
          <h2 class="text-2xl font-semibold mb-4 text-yellow-400">Our Software & Support</h2>
          <p class="mb-4 text-gray-300 leading-relaxed">
            The Tri Tech Task Manager is designed to help you:
          </p>
          <ul class="list-inside space-y-2 text-gray-300">
            <li><strong>Organize Tasks</strong>: Categorize and prioritize your daily, weekly, and long-term goals seamlessly.</li>
            <li><strong>Collaborate Effortlessly</strong>: Real-time updates and shared progress keep your team in sync.</li>
            <li><strong>Automated Reminders</strong>: Never miss deadlines with customizable notifications.</li>
            <li><strong>Insightful Reporting</strong>: Track productivity trends with built-in analytics.</li>
          </ul>
          <p class="mt-6 mb-2 text-gray-300">
            Need help? We offer comprehensive guides, tutorials, and a dedicated support team to assist you anytime.
          </p>
          <a href="contact.php" class="inline-block mt-3 px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded shadow transition">
            Contact Support
          </a>
        </div>
      </article>
    </section>

    <!-- Feedback Form -->
    <section data-aos="fade-up" class="mt-14 bg-gray-800 rounded-lg shadow-lg p-8 border border-yellow-600 max-w-4xl mx-auto">
      <h2 class="text-2xl font-semibold mb-6 text-yellow-400 text-center">We Value Your Feedback & Preferences</h2>
      <form id="contact-form" class="space-y-6 text-gray-300" novalidate>
        <div>
          <label for="name" class="block mb-1 font-medium">Full Name</label>
          <input type="text" id="name" name="name" required placeholder="Enter your full name" autocomplete="name"
            class="w-full rounded border border-yellow-600 bg-gray-900 px-4 py-2 placeholder-yellow-400 focus:outline-none focus:ring focus:ring-yellow-400 focus:border-yellow-400" />
        </div>
        <div>
          <label for="email" class="block mb-1 font-medium">Email Address</label>
          <input type="email" id="email" name="email" required placeholder="you@example.com" autocomplete="email"
            class="w-full rounded border border-yellow-600 bg-gray-900 px-4 py-2 placeholder-yellow-400 focus:outline-none focus:ring focus:ring-yellow-400 focus:border-yellow-400" />
        </div>
        <div>
          <label for="interest" class="block mb-1 font-medium">What interests you most?</label>
          <select id="interest" name="interest" required
            class="w-full rounded border border-yellow-600 bg-gray-900 px-4 py-2 text-gray-300 focus:outline-none focus:ring focus:ring-yellow-400 focus:border-yellow-400">
            <option value="" disabled selected>Select an option</option>
            <option value="software">Software Features</option>
            <option value="support">Customer Support</option>
            <option value="customization">Customization Options</option>
            <option value="pricing">Pricing & Plans</option>
          </select>
        </div>
        <div>
          <label for="message" class="block mb-1 font-medium">Message or Suggestions</label>
          <textarea id="message" name="message" rows="4" placeholder="Let us know your thoughts..."
            class="w-full rounded border border-yellow-600 bg-gray-900 px-4 py-2 placeholder-yellow-400 focus:outline-none focus:ring focus:ring-yellow-400 focus:border-yellow-400"></textarea>
        </div>
        <button type="submit"
          class="w-full bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-600 rounded py-3 shadow transition">
          Submit Your Choice
        </button>
      </form>
      <p class="mt-6 text-center text-yellow-300 text-sm select-none">
        Thank you for helping us improve Tri Tech Solutions.
      </p>
    </section>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-700 text-yellow-400 text-sm select-none">
    &copy; 2025 Tri Tech Solutions. All rights reserved.
  </footer>

  <!-- AOS JS -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
  </script>

</body>
</html>
