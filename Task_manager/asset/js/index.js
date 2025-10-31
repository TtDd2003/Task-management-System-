// ===== Chart.js setups ===== //

 // Common chart options
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { position: 'top' } }
  };

  // Example Chart 1 - Line
  new Chart(document.getElementById('tasksChart'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
        label: 'Tasks Completed',
        data: [10, 20, 15, 25],
        borderColor: 'blue',
        backgroundColor: 'rgba(0, 0, 255, 0.1)',
        borderWidth: 2,
        tension: 0.3
      }]
    },
    options: chartOptions
  });

  // Example Chart 2 - Bar
  new Chart(document.getElementById('checklistChart'), {
    type: 'bar',
    data: {
      labels: ['Checklist', 'Pending', 'Done'],
      datasets: [{
        data: [6, 9, 12],
        backgroundColor: ['#f39c12', '#e74c3c', '#2ecc71']
      }]
    },
    options: chartOptions
  });

  // Example Chart 3 - Pie
  new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
      labels: ['Open', 'In Progress', 'Closed'],
      datasets: [{
        data: [30, 40, 30],
        backgroundColor: ['#f39c12', '#3498db', '#2ecc71']
      }]
    },
    options: chartOptions
  });

  
// ===== DOM Ready ===== //
document.addEventListener("DOMContentLoaded", () => {

  // ================== CHECKLIST NOTE MODAL ================== //
  const noteModal = document.getElementById('noteTaskModal');
  if (noteModal) {
    noteModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const taskId = button.getAttribute('data-task-id'); // numeric only
      noteModal.querySelector('#noteTaskId').value = taskId;

      // Reset textarea & success message
      const textarea = document.getElementById('noteDescription');
      if (textarea) textarea.value = "";
      document.getElementById('noteSuccessMessage').classList.add('d-none');
    });
  }

  // ================== CHECKLIST COMPLETE MODAL ================== //
  const completeModal = document.getElementById('completeTaskModal');
  if (completeModal) {
    completeModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const taskId = button.getAttribute('data-task-id'); // numeric only
      completeModal.querySelector('#completeTaskId').value = taskId;

      // Reset file input & preview
      const proofInput = document.getElementById('proofFile');
      const preview = document.getElementById('proofPreview');
      const previewImg = document.getElementById('previewImage');
      if (proofInput) proofInput.value = "";
      if (preview) preview.classList.add('d-none');
      if (previewImg) previewImg.src = "";
      document.getElementById("completeSuccessMessage").classList.add('d-none');
    });
  }

  // ================== CHECKLIST NOTE FORM AJAX ================== //
  const noteForm = document.getElementById("noteTaskForm");
  if (noteForm) {
    noteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(noteForm);

      try {
        const response = await fetch("Task/submit_task.php", {
          method: "POST",
          body: formData,
        });

        const text = await response.text();
        console.log("📩 Raw response (Note):", text);

        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          throw new Error("Invalid JSON response: " + text);
        }

        if (result.status === "success") {
          document.getElementById("noteSuccessMessage").classList.remove("d-none");
          noteForm.reset();
          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(noteModal);
            if (modal) modal.hide();
            document.getElementById("noteSuccessMessage").classList.add("d-none");
            location.reload();
          }, 1500);
        } else {
          alert(result.message);
        }

      } catch (err) {
        console.error("Error (Note):", err);
        alert("Something went wrong while saving note.");
      }
    });
  }

  // ================== CHECKLIST COMPLETE FORM AJAX ================== //
  const completeForm = document.getElementById("completeTaskForm");
  if (completeForm) {
    completeForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(completeForm);

      try {
        const response = await fetch("Task/submit_task.php", {
          method: "POST",
          body: formData,
        });

        const text = await response.text();
        console.log("📩 Raw response (Complete):", text);

        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          console.error("Invalid JSON:", text);
          alert("Server returned invalid JSON.");
          return;
        }

        if (result.status === "success") {
          document.getElementById("completeSuccessMessage").classList.remove("d-none");
          completeForm.querySelector("#proofFile").value = "";
          document.getElementById("proofPreview").classList.add("d-none");
          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(completeModal);
            if (modal) modal.hide();
            document.getElementById("completeSuccessMessage").classList.add("d-none");
            location.reload();
          }, 1500);
        } else {
          alert(result.message);
        }

      } catch (err) {
        console.error("Error (Complete):", err);
        alert("Something went wrong while completing task.");
      }
    });
  }

  // ================== CHECKLIST FILE PREVIEW ================== //
  const proofFileInput = document.getElementById("proofFile");
  if (proofFileInput) {
    proofFileInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      const previewContainer = document.getElementById("proofPreview");
      const previewImage = document.getElementById("previewImage");

      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (ev) {
          previewImage.src = ev.target.result;
          previewContainer.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
      } else {
        previewContainer.classList.add("d-none");
        previewImage.src = "";
      }
    });
  }

  // ================== HELPER NOTE MODAL ================== //
  const noteHelpModal = document.getElementById('noteHelpModal');
  if (noteHelpModal) {
    noteHelpModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const taskId = button.getAttribute('data-task-id');
      noteHelpModal.querySelector('#noteHelpTaskId').value = taskId;

      const textarea = document.getElementById('noteHelpDescription');
      if (textarea) textarea.value = "";
      document.getElementById('noteHelpSuccessMessage').classList.add('d-none');
    });
  }

  // ================== HELPER NOTE FORM AJAX ================== //
  const noteHelpForm = document.getElementById("noteHelpForm");
  if (noteHelpForm) {
    noteHelpForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(noteHelpForm);

      try {
        const response = await fetch("Help/submit_help.php", {
          method: "POST",
          body: formData,
        });

        const text = await response.text();
        console.log("📩 Raw response (Helper Note):", text);

        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          throw new Error("Invalid JSON response: " + text);
        }

        if (result.status === "success") {
          document.getElementById("noteHelpSuccessMessage").classList.remove("d-none");
          noteHelpForm.reset();
          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(noteHelpModal);
            if (modal) modal.hide();
            document.getElementById("noteHelpSuccessMessage").classList.add("d-none");
            location.reload();
          }, 1500);
        } else {
          alert(result.message);
        }

      } catch (err) {
        console.error("Error (Helper Note):", err);
        alert("Something went wrong while saving helper note.");
      }
    });
  }

  // ================== HELPER COMPLETE MODAL ================== //
  const completeHelpModal = document.getElementById('completeHelpModal');
  if (completeHelpModal) {
    completeHelpModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const taskId = button.getAttribute('data-task-id');
      completeHelpModal.querySelector('#completeHelpTaskId').value = taskId;

      const proofInput = document.getElementById('proofHelpFile');
      const preview = document.getElementById('proofHelpPreview');
      const previewImg = document.getElementById('previewHelpImage');
      if (proofInput) proofInput.value = "";
      if (preview) preview.classList.add("d-none");
      if (previewImg) previewImg.src = "";
      document.getElementById("completeHelpSuccessMessage").classList.add("d-none");
    });
  }

  // ================== HELPER COMPLETE FORM AJAX ================== //
  const completeHelpForm = document.getElementById("completeHelpForm");
  if (completeHelpForm) {
    completeHelpForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(completeHelpForm);

      try {
        const response = await fetch("Help/submit_help.php", {
          method: "POST",
          body: formData,
        });

        const text = await response.text();
        console.log("📩 Raw response (Helper Complete):", text);

        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          console.error("Invalid JSON:", text);
          alert("Server returned invalid JSON.");
          return;
        }

        if (result.status === "success") {
          document.getElementById("completeHelpSuccessMessage").classList.remove("d-none");
          completeHelpForm.querySelector("#proofHelpFile").value = "";
          document.getElementById("proofHelpPreview").classList.add("d-none");

          setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(completeHelpModal);
            if (modal) modal.hide();
            document.getElementById("completeHelpSuccessMessage").classList.add("d-none");
            location.reload();
          }, 1500);
        } else {
          alert(result.message);
        }

      } catch (err) {
        console.error("Error (Helper Complete):", err);
        alert("Something went wrong while completing helper task.");
      }
    });
  }

  // ================== HELPER FILE PREVIEW ================== //
  const proofHelpInput = document.getElementById("proofHelpFile");
  if (proofHelpInput) {
    proofHelpInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      const previewContainer = document.getElementById("proofHelpPreview");
      const previewImage = document.getElementById("previewHelpImage");

      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (ev) {
          previewImage.src = ev.target.result;
          previewContainer.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
      } else {
        previewContainer.classList.add("d-none");
        previewImage.src = "";
      }
    });
  }

  // ================== COMMENTS TABLE TOGGLE ================== //
  const commentsBtn = document.querySelector(".btn-2"); // "Comments" button
  const backBtn = document.getElementById("backToTasksBtn");
  const commentsWrapper = document.getElementById("commentsTableWrapper");
  const taskSection = document.querySelector(".task-box"); // Tasks card
  const tbody = document.getElementById("commentsTableBody");

  const renderComments = (data) => {
    tbody.innerHTML = "";
    if (data.length > 0) {
      data.forEach((row, index) => {
        tbody.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td><strong>${row.id}</strong></td>
            <td>${row.task_name}</td>
            <td>${row.comments}</td>
            <td>${row.date}</td>
          </tr>`;
      });
    } else {
      tbody.innerHTML = `<tr><td colspan="5" class="text-center">No comments found</td></tr>`;
    }
  };

  if (commentsBtn && backBtn && commentsWrapper && taskSection) {
    commentsBtn.addEventListener("click", async () => {
      try {
        const response = await fetch("Task/get_comments.php");
        if (!response.ok) throw new Error("Network response was not ok");
        const result = await response.json();
        if (result.status === "success") {
          renderComments(result.data);
        } else {
          renderComments([]);
        }
        taskSection.classList.add("d-none");
        commentsWrapper.classList.remove("d-none");
      } catch (err) {
        console.error("Error fetching comments:", err);
        alert("Failed to load comments. Please try again later.");
      }
    });

    backBtn.addEventListener("click", () => {
      commentsWrapper.classList.add("d-none");
      taskSection.classList.remove("d-none");
    });
  }

});

// ====== index toggleing all part -- ======= // 
//  ================== JS for Sidebar, Overlay & Dropdowns ================== //

document.addEventListener("DOMContentLoaded", () => {
  // ===== Elements =====
  const menuToggle = document.getElementById("menuToggle");
  const sidebar = document.getElementById("sidebarMenu");
  const overlay = document.getElementById("sidebarOverlay");
  const dropdownBtn = document.getElementById("navDropdownBtn");
  const navMenu = document.getElementById("navMenuDropdown");
  const settingsButton = document.getElementById("settingsButton");
  const settingsMenu = document.getElementById("settingsMenu");

 // ===== SIDEBAR TOGGLE =====
if (menuToggle && sidebar) {
  menuToggle.addEventListener("click", (e) => {
    e.stopPropagation();

    if (window.innerWidth <= 768) {
      sidebar.classList.toggle("active");
      overlay?.classList.toggle("active");
      document.body.classList.toggle("sidebar-open"); // prevent scroll behind sidebar
    } else {
      sidebar.classList.toggle("d-none");
    }
  });

  // Close sidebar when clicking outside (mobile only)
  document.addEventListener("click", (e) => {
    if (
      window.innerWidth <= 768 &&
      sidebar.classList.contains("active") &&
      !sidebar.contains(e.target) &&
      !menuToggle.contains(e.target)
    ) {
      sidebar.classList.remove("active");
      overlay?.classList.remove("active");
      document.body.classList.remove("sidebar-open");
    }
  });
}

// ===== OVERLAY CLICK TO CLOSE =====
if (overlay) {
  overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.classList.remove("sidebar-open");
  });
}


  // ===== NAVBAR DROPDOWN (Home, Contact, About) =====
  if (dropdownBtn && navMenu) {
    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      navMenu.style.display =
        navMenu.style.display === "block" ? "none" : "block";
    });

    // Close on outside click
    document.addEventListener("click", (e) => {
      if (!navMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
        navMenu.style.display = "none";
      }
    });
  }

  // ===== SETTINGS DROPDOWN (Gear Icon) =====
  if (settingsButton && settingsMenu) {
    settingsButton.addEventListener("click", (e) => {
      e.stopPropagation();
      settingsMenu.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
      if (!settingsMenu.contains(e.target) && !settingsButton.contains(e.target)) {
        settingsMenu.classList.remove("show");
      }
    });
  }
});







