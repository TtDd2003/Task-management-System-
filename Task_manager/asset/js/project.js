// =============================
// THEME SWITCHING FUNCTIONALITY
// =============================
function setTheme(theme) {
    const root = document.documentElement;

    switch(theme) {
        case 'blue':
            root.style.setProperty('--primary-color', '#4e73df');
            root.style.setProperty('--secondary-color', '#6f42c1');
            root.style.setProperty('--success-color', '#1cc88a');
            root.style.setProperty('--background-color', '#f8f9fc');
            root.style.setProperty('--card-color', '#ffffff');
            root.style.setProperty('--text-color', '#5a5c69');
            break;
        case 'green':
            root.style.setProperty('--primary-color', '#1cc88a');
            root.style.setProperty('--secondary-color', '#13855c');
            root.style.setProperty('--success-color', '#4e73df');
            root.style.setProperty('--background-color', '#f0f9f6');
            root.style.setProperty('--card-color', '#ffffff');
            root.style.setProperty('--text-color', '#2d4a3a');
            break;
        case 'yellow':
            root.style.setProperty('--primary-color', '#f6c23e');
            root.style.setProperty('--secondary-color', '#dda20a');
            root.style.setProperty('--success-color', '#1cc88a');
            root.style.setProperty('--background-color', '#fefdf6');
            root.style.setProperty('--card-color', '#ffffff');
            root.style.setProperty('--text-color', '#5a5c69');
            break;
        case 'red':
            root.style.setProperty('--primary-color', '#e74a3b');
            root.style.setProperty('--secondary-color', '#be2617');
            root.style.setProperty('--success-color', '#1cc88a');
            root.style.setProperty('--background-color', '#fef7f6');
            root.style.setProperty('--card-color', '#ffffff');
            root.style.setProperty('--text-color', '#5a5c69');
            break;
    }
}

// =============================
// DEFAULT DATES FOR PROJECT FORM
// =============================
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('startDate');
    const deadlineInput = document.getElementById('deadline');

    if(startDateInput && deadlineInput){
        const today = new Date();
        const nextWeek = new Date();
        nextWeek.setDate(today.getDate() + 7);

        startDateInput.valueAsDate = today;
        deadlineInput.valueAsDate = nextWeek;
    }

    // Load projects for report form
    const projectSelect = document.getElementById('project_id');
    if(projectSelect){
        fetch('get_projects.php')
        .then(res => res.json())
        .then(data => {
            projectSelect.innerHTML = '<option value="">Select Project</option>';
            data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.project_id;
                opt.text = p.project_name;
                projectSelect.add(opt);
            });
        });
    }
});

// =============================
// PROJECT FORM SUBMISSION (projectForm)
// =============================
const projectForm = document.getElementById("projectForm");
if(projectForm){
    projectForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const projectName = document.getElementById('projectName').value;
        const startDate   = document.getElementById('startDate').value;
        const deadline    = document.getElementById('deadline').value;

        if (!projectName || !startDate || !deadline) {
            Swal.fire({ icon: "warning", title: "Missing Fields", text: "Please fill in all required fields." });
            return;
        }

        const formData = new FormData(this);

        fetch("submit_project.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({ icon: "success", title: "Success", text: data.message, timer: 2000, showConfirmButton: false });
                this.reset();
            } else {
                Swal.fire({ icon: "error", title: "Oops...", text: data.message });
            }
        })
        .catch(err => {
            Swal.fire({ icon: "error", title: "Error", text: "Something went wrong!" });
            console.error(err);
        });
    });
}

// =============================
// REPORT FORM SUBMISSION (reportForm)
// =============================
const reportForm = document.getElementById('reportForm');
if(reportForm){
    reportForm.addEventListener('submit', function(e){
        e.preventDefault();

        const hours = parseFloat(document.getElementById('hours_spent').value);
        if(isNaN(hours) || hours < 0){
            Swal.fire({ icon: 'warning', title: 'Invalid Hours', text: 'Enter valid positive hours' });
            return;
        }

        const formData = new FormData(this);

        fetch('submit_reports.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                Swal.fire({ icon: 'success', title: 'Success', text: data.message, timer: 2000, showConfirmButton: false });
                this.reset();
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
        })
        .catch(err => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
            console.error(err);
        });
    });
}
