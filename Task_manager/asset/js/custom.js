// ======= index .js =========//
// Sidebar toggle
    document.getElementById("menuToggle").addEventListener("click", function () {
      const sidebar = document.getElementById("sidebarMenu");
      sidebar.classList.toggle("d-none");
    });
  
  // Line Chart
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
        label: 'Tasks Completed',
        data: [10, 20, 15, 25],
        borderColor: 'blue',
        fill: false
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true } }
    }
  });

  // Bar Chart
  const ctxBar = document.getElementById('barChart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Checklist', 'Pending', 'Done'],
      datasets: [{
        label: 'Task Status',
        data: [5, 8, 12],
        backgroundColor: ['orange', 'red', 'green']
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } }
    }
  });

  // Pie Chart
  const ctxPie = document.getElementById('pieChart').getContext('2d');
  new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: ['Open', 'In Progress', 'Closed'],
      datasets: [{
        label: 'Tickets',
        data: [12, 5, 7],
        backgroundColor: ['#f39c12', '#3498db', '#2ecc71']
      }]
    },
    options: {
      responsive: true
    }
  });


  ///  ========   about.js start -----==========//
  // Basic form validation
    document.getElementById('contact-form').addEventListener('submit', (e) => {
      e.preventDefault();
      let valid = true;

      const nameInput = e.target.name;
      const emailInput = e.target.email;
      const interestInput = e.target.interest;

      // Name validation
      if (!nameInput.value.trim()) {
        valid = false;
        document.getElementById('name-error').classList.remove('hidden');
        nameInput.classList.add('border-yellow-300');
      } else {
        document.getElementById('name-error').classList.add('hidden');
        nameInput.classList.remove('border-yellow-300');
      }

      // Email validation (simple)
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailInput.value.trim() || !emailPattern.test(emailInput.value)) {
        valid = false;
        document.getElementById('email-error').classList.remove('hidden');
        emailInput.classList.add('border-yellow-300');
      } else {
        document.getElementById('email-error').classList.add('hidden');
        emailInput.classList.remove('border-yellow-300');
      }

      // Interest selection validation
      if (!interestInput.value) {
        valid = false;
        document.getElementById('interest-error').classList.remove('hidden');
        interestInput.classList.add('border-yellow-300');
      } else {
        document.getElementById('interest-error').classList.add('hidden');
        interestInput.classList.remove('border-yellow-300');
      }

      if (valid) {
        alert('Thank you for your submission! We will get back to you shortly.');
        e.target.reset();
      }
    });


    ///// ===== 