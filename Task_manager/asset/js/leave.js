// ==================== ADD LEAVE PAGE JS ====================

const leaveForm = document.getElementById('leaveForm');
if (leaveForm) {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const daysCount = document.getElementById('daysCount');
    const durationDisplay = document.getElementById('durationDisplay');
    const leaveTypeInput = document.getElementById('leaveType');

    // Initialize min date
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;

    // Update end date min when start date changes
    startDateInput.addEventListener('change', () => {
        endDateInput.min = startDateInput.value;
        calculateLeaveDays();
    });

    // Calculate leave days when end date changes
    endDateInput.addEventListener('change', calculateLeaveDays);

    function calculateLeaveDays() {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        if (start && end && start <= end) {
            let diff = 0;
            let current = new Date(start);
            while (current <= end) {
                const day = current.getDay();
                if (day !== 0 && day !== 6) diff++; // skip weekends
                current.setDate(current.getDate() + 1);
               
            }
            daysCount.textContent = diff;
            durationDisplay.classList.remove('hidden');
        }
    }

    // Leave type selection
    function selectLeaveType(el) {
        leaveTypeInput.value = el.dataset.type;
        document.querySelectorAll('.leave-type').forEach(d => d.classList.remove('bg-blue-100'));
        el.classList.add('bg-blue-100');
    }
    window.selectLeaveType = selectLeaveType;

    // Form submission via AJAX
    $('#leaveForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: 'submit_leave.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let res = (typeof response === "string") ? JSON.parse(response) : response;
                if (res.status === "success") {
                    Swal.fire("Success", res.message, "success");
                    $('#leaveForm')[0].reset();
                    $('#durationDisplay').addClass('hidden');
                } else if (res.status === "error") {
                    Swal.fire("Error", res.message, "error");
                } else if (res.status === "warning") {
                    Swal.fire("Warning", res.message, "warning");
                }
            },
            error: function() {
                Swal.fire("Error", "Something went wrong with the request.", "error");
            }
        });
    });
}


// ==================== ALL LEAVE PAGE JS ====================

// Data will come from API
let applications = [];
let currentPage = 1;
let totalPages = 1;
const limit = 5;

// Status colors mapping
const statusColors = {
    'pending': 'bg-yellow-100 text-yellow-700',
    'approved': 'bg-green-100 text-green-700',
    'rejected': 'bg-red-100 text-red-700'
};

// Load applications from API
async function loadApplications(page = 1) {
    currentPage = page;
    const res = await fetch(`get_leave.php?page=${page}&limit=${limit}`);
    const json = await res.json();

    applications = json.data || [];
    totalPages = json.totalPages || 1;

    renderApplications();
    renderPagination();
}

// Render applications
function renderApplications(filter = 'all') {
    const tbody = document.querySelector('#leaveTableBody');
    tbody.innerHTML = '';

    const filteredApps = filter === 'all'
        ? applications
        : applications.filter(app => app.status === filter);

    filteredApps.forEach(app => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
            <td class="p-3">
                <div>${app.name}</div>
                <div class="text-xs text-gray-500">${app.id}</div>
            </td>
            <td class="p-3">${app.type}</td>
            <td class="p-3">
                ${new Date(app.start).toLocaleDateString()} - 
                ${new Date(app.end).toLocaleDateString()}
            </td>
            <td class="p-3">
                <span class="px-2 py-1 rounded-full text-xs ${statusColors[app.status] || ''}">
                    ${app.status}
                </span>
            </td>
           <td class="p-2 text-center">
   <button onclick='openEditModal(${app.id})' class="text-blue-500 hover:text-blue-700">
      <i class="fas fa-edit"></i>
   </button>
</td>

        `;
        tbody.appendChild(row);
    });
}

// Open Edit Modal and prefill data
function openEditModal(id) {
  const application = applications.find(a => a.id == id);

  if (!application) return;

  document.getElementById("edit_leave_id").value = application.id;
  document.getElementById("edit_user_code").value = application.user_code;
  document.getElementById("edit_department").value = application.department || "";
  document.getElementById("edit_type").value = application.type || "";
  document.getElementById("edit_reason").value = application.reason || "";
  document.getElementById("edit_start").value = application.start || "";
  document.getElementById("edit_end").value = application.end || "";
  document.getElementById("edit_contact_name").value = application.contact_name || "";
  document.getElementById("edit_contact_no").value = application.contact_no || "";
  document.getElementById("edit_status").value = application.status || "pending";

  document.getElementById("editModal").classList.remove("hidden");
}


// Close modal
function closeEditModal() {
  document.getElementById("editModal").classList.add("hidden");
}


// Handle form submit
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('submit_leave.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(result => {
                if (result.status === "success") {   // ✅ match PHP
                    alert(result.message);
                    closeEditModal();
                    loadApplications(currentPage);
                } else {
                    alert("Error: " + result.message);
                }
            })
            .catch(err => {
                console.error("Update failed", err);
                alert("Something went wrong while updating leave!");
            });

        });
    }
});

function editApplication(application) {
  openEditModal(application);
}


// Render pagination
function renderPagination() {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = '';

    let html = `
        <nav>
          <ul class="pagination flex justify-center gap-2">
            <li>
                <button onclick="prevPage()" class="px-3 py-1 border rounded ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                    Prev
                </button>
            </li> `;

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <li>
                <button onclick="gotoPage(${i})" class="px-3 py-1 border rounded ${i === currentPage ? 'bg-blue-500 text-white' : ''}">
                    ${i}
                </button>
            </li>`;
    }

    html += `
            <li>
                <button onclick="nextPage()" class="px-3 py-1 border rounded ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}">
                     Next
                </button>
            </li>
        </ul>
    </nav>`;

    paginationContainer.innerHTML = html;
}

function prevPage() {
    if (currentPage > 1) loadApplications(currentPage - 1);
}

function nextPage() {
    if (currentPage < totalPages) loadApplications(currentPage + 1);
}

function gotoPage(page) {
    loadApplications(page);
}

// Filter applications
function filterApplications(filter) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-500', 'text-white', 'border-blue-500');
        btn.classList.add('border-gray-300');
    });

    const activeBtn = document.querySelector(`button[onclick="filterApplications('${filter}')"]`);
    activeBtn.classList.add('active', 'bg-blue-500', 'text-white', 'border-blue-500');
    activeBtn.classList.remove('border-gray-300');

    renderApplications(filter);
}

// Init
document.addEventListener('DOMContentLoaded', () => {
    loadApplications();
});


// ==================== ADD LEAVE PAGE JS ====================

// Select leave type
function selectLeaveType(el) {
    document.getElementById('leaveType').value = el.dataset.type;
    document.querySelectorAll('.leave-type').forEach(d => d.classList.remove('bg-blue-100'));
    el.classList.add('bg-blue-100');
}

// Close modal
function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
    if (document.getElementById('leaveForm')) {
        document.getElementById('leaveForm').reset();
    }
    document.querySelectorAll('.leave-type').forEach(el => {
        el.classList.remove('selected');
    });
}
