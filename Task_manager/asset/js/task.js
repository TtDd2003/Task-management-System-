/* ========== Form Submission Handler ========== */
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("taskAssignmentForm");
  
  const submitBtn = document.getElementById("submitBtn");
  const submitText = document.getElementById("submitText");
  const loadingSpinner = submitBtn.querySelector(".loading");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    submitBtn.disabled = true;
    submitText.textContent = "Submitting...";
    loadingSpinner.style.display = "inline-block";

    const formData = new FormData(form);

    fetch("assign_task.php", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        const raw = await response.text();
        console.log(" Raw Response:", raw);

        try {
          const data = JSON.parse(raw);
          console.log("Parsed JSON:", data);

          if (data.success) {
            Swal.fire("Success", data.message, "success").then(() => {
              form.reset();
            });
          } else {
            Swal.fire("Error", data.message || "Task not assigned.", "error");
          }
        } catch (err) {
          console.error(" JSON Parse Error:", err);
          Swal.fire("Error", "Server did not return valid JSON.", "error");
        }
      })
      .catch((err) => {
        console.error(" Fetch error:", err);
        Swal.fire("Error", "Something went wrong. Check console.", "error");
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitText.textContent = "Assign Task";
        loadingSpinner.style.display = "none";
      });
  });
});

/* ========== Priority Badge Toggle ========== */
document.addEventListener("DOMContentLoaded", () => {
  const priority = document.getElementById("priority");
  const high = document.querySelector(".priority-high");
  const medium = document.querySelector(".priority-medium");
  const low = document.querySelector(".priority-low");

  if (!priority) return;

  priority.addEventListener("change", () => {
    high.classList.add("d-none");
    medium.classList.add("d-none");
    low.classList.add("d-none");

    if (priority.value === "high") high.classList.remove("d-none");
    if (priority.value === "medium") medium.classList.remove("d-none");
    if (priority.value === "low") low.classList.remove("d-none");
  });
});

/* ========== Due Date Minimum ========== */
document.addEventListener("DOMContentLoaded", () => {
  const dueDate = document.getElementById("dueDate");
  if (!dueDate) return;

  const today = new Date().toISOString().split("T")[0];
  dueDate.setAttribute("min", today);
});



 /// ======= view all task details from view button ======= //

document.addEventListener("DOMContentLoaded", () => {
  const viewButtons = document.querySelectorAll(".view-tasks");

  viewButtons.forEach(button => {
    button.addEventListener("click", () => {
      const userId = button.getAttribute("data-userid");
      const taskDetailsBody = document.getElementById("taskDetailsBody");

      taskDetailsBody.innerHTML = '<tr><td colspan="6">Loading...</td></tr>';

      fetch(`task_view.php?user_id=${userId}`)
        .then(res => res.json())
        .then(data => {
          if (!data || data.length === 0) {
            taskDetailsBody.innerHTML = '<tr><td colspan="6">No tasks assigned.</td></tr>';
            return;
          }

          taskDetailsBody.innerHTML = "";

          data.forEach((task, index) => {
            const task_name = task.task_name ;
            const task_description = task.task_description ;
            const priority = task.priority ;
            const submission_date = task.submission_date ;
            const assigned_by = task.assigned_by ;

            let statusBadge = '';
            const status = task.status?.toLowerCase() || 'unknown';

            switch (status) {
              case 'completed':
                statusBadge = '<span class="badge bg-success">Completed</span>';
                break;
              case 'pending':
                statusBadge = '<span class="badge bg-danger">Pending</span>';
                break;
              case 'working':
                statusBadge = '<span class="badge bg-info text-dark">Working</span>';
                break;
              default:
                statusBadge = `<span class="badge bg-secondary">${status}</span>`;
            }

            taskDetailsBody.innerHTML += `
              <tr>
                <td>${index + 1}</td>
                <td>${task_name}</td>
                <td>${task_description}</td>
                <td>${priority}</td>
                <td>${submission_date}</td>
                <td>${assigned_by}</td>
                <td>${statusBadge}</td>
              </tr>
            `;
          });
        })
        .catch(err => {
          console.error("Error fetching tasks:", err);
          taskDetailsBody.innerHTML = '<tr><td colspan="6">Error loading tasks.</td></tr>';
        });
    });
  });
});



/* ========== SweetAlert Upload Notification ========== */
document.addEventListener("DOMContentLoaded", function () {
  const query = window.location.search;
  const status = new URLSearchParams(query).get("upload");

  if (status === "success") {
    Swal.fire({
      icon: "success",
      title: "Upload Successful",
      text: "Your task file was uploaded successfully.",
      confirmButtonColor: "#3085d6",
    });
    removeUploadParam();
  }

  if (status === "error") {
    Swal.fire({
      icon: "error",
      title: "Upload Failed",
      text: "There was a problem uploading your file. Please try again.",
      confirmButtonColor: "#d33",
    });
    removeUploadParam();
  }

  function removeUploadParam() {
    const params = new URLSearchParams(window.location.search);
    params.delete("upload");

    const baseUrl = window.location.pathname;
    const cleanUrl = params.toString() ? `${baseUrl}?${params}` : baseUrl;
    window.history.replaceState({}, document.title, cleanUrl);
  }
});

//== CSV uploadation-- =====//
document.addEventListener("DOMContentLoaded", function () {
    const csvForm = document.getElementById("csvUploadForm");

    csvForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const fileInput = document.getElementById("csvFile");
        if (!fileInput.files.length) {
            Swal.fire("Error", "Please select a CSV file.", "error");
            return;
        }

        const formData = new FormData();
        formData.append("csvFile", fileInput.files[0]);

        fetch("csv.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Show SweetAlert
            let message = `Inserted: ${data.inserted}\nFailed: ${data.failed}`;
            if (data.errors && data.errors.length > 0) {
                message += "\n\nErrors:\n" + data.errors.join("\n");
            }

            Swal.fire({
                title: "CSV Upload Result",
                icon: data.failed > 0 ? "warning" : "success",
                html: `<pre style="text-align:left;">${message}</pre>`,
            });
        })
        .catch(() => {
            Swal.fire("Error", "Something went wrong during CSV upload.", "error");
        });
    });
});




