document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ DOM fully loaded, script starting...");

    /*============ FORM SUBMISSION =============*/
    const form = document.getElementById('helperForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log("🔹 Form submission triggered");

            // Simple validation
            const helperName = document.getElementById('helperName').value.trim();
            const taskTitle  = document.getElementById('taskTitle').value.trim();

            if (!helperName  || !taskTitle) {
                console.warn("⚠️ Validation failed");
                alert('Please fill in all required fields');
                return;
            }

        // Prepare form data for AJAX
        const formData = new FormData();
        formData.append('helper_name', helperName);
        formData.append('helper_role', document.getElementById('helperRole').value);
        formData.append('task_title', taskTitle);
        formData.append('task_description', document.getElementById('taskDescription').value);
        formData.append('deadline', document.getElementById('deadline').value);
        formData.append('estimated_time', document.getElementById('estimatedHours').value);

        //  Priority (must be selected)
        let priorityInput = document.querySelector('input[name="priority"]:checked');
        if (priorityInput) {
            formData.append('priority', priorityInput.value);
        } else {
            alert(" Please select a priority level before submitting!");
            return; // stop submission
        }

        console.log(" Sending AJAX request…");

            fetch('submit_help.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(text => {
                console.log(" Raw server response:", text);
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error("JSON parse error:", e, "\nResponse was:", text);
                    alert("Server did not return valid JSON.\nCheck PHP error logs!");
                    return;
                }

                console.log(" Parsed JSON response:", data);
                const successMessage = document.getElementById('successMessage');

                if (data.success) {
                    successMessage.querySelector('h3').textContent = data.message;
                    successMessage.classList.remove('hidden');
                    setTimeout(() => {
                        form.reset();
                        successMessage.classList.add('hidden');
                    }, 3000);
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(" AJAX Error caught:", err);
            });
        });
    } else {
        console.warn(" helperForm not found in DOM, skipping form binding.");
    }

    /*--------- FLOATING LABELS --------------*/
    document.querySelectorAll('.floating-input').forEach(input => {
        input.addEventListener('focus', () => {
            input.nextElementSibling.style.top = '-10px';
            input.nextElementSibling.style.left = '10px';
            input.nextElementSibling.style.background = 'white';
            input.nextElementSibling.style.padding = '0 8px';
            input.nextElementSibling.style.fontSize = '12px';
            input.nextElementSibling.style.color = '#2563eb';
        });

        input.addEventListener('blur', () => {
            if (!input.value) {
                input.nextElementSibling.style.top = '50%';
                input.nextElementSibling.style.left = '16px';
                input.nextElementSibling.style.background = 'transparent';
                input.nextElementSibling.style.padding = '0';
                input.nextElementSibling.style.fontSize = 'inherit';
                input.nextElementSibling.style.color = '#6b7280';
            }
        });
    });

    /*============     ALL HELPERS DATA      =============*/
  
    const helpersGrid = document.getElementById('helpersGrid');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortBy = document.getElementById('sortBy');
    const totalHelpers = document.getElementById('total-helpers');
    const availableHelpers = document.getElementById('available-helpers');
    const busyHelpers = document.getElementById('busy-helpers');
    const assignedHelpers = document.getElementById('assigned-helpers');

    let helpers = []; 
   let backendStats = {};

    // Fetch helpers + stats
    async function loadHelpers() {
        try {
            const response = await fetch("get_helper.php");
            const data = await response.json();

            helpers = data.helpers; 
            backendStats = data.stats; // keep backend stats fixed

            // Render helpers initially
            renderHelpers(helpers);

            // Show DB stats (always constant until reload)
            animateValue(totalHelpers, 0, backendStats.total, 1000);
            animateValue(availableHelpers, 0, backendStats.available, 1000);
            animateValue(busyHelpers, 0, backendStats.busy, 1000);
            animateValue(assignedHelpers, 0, backendStats.assigned, 1000);

        } catch (error) {
            console.error("Error loading helpers:", error);
        }
    }


    /*============ RENDER HELPERS =============*/
function renderHelpers(helpersToRender) {
    helpersGrid.innerHTML = '';
    if (helpersToRender.length === 0) {
        helpersGrid.innerHTML = '<div class="no-results">No helpers found matching your criteria</div>';
        return;
    }
    helpersToRender.forEach(helper => {
        const card = document.createElement('div');
        card.className = 'helper-card';

        // Badge class mapping (based on normalized status)
        let badgeClass = '';
        switch(helper.status) {
            case 'pending': 
                badgeClass = 'status-low'; 
                break;
            case 'in progress': 
                badgeClass = 'status-medium'; 
                break;
            case 'working': 
                badgeClass = 'status-high'; 
                break;
            default: 
                badgeClass = 'status-unknown'; 
        }

        card.innerHTML = `
            <div class="card-header">
                <div class="profile-image">
                    <img src="${helper.image}" alt="Profile photo of ${helper.name} - ${helper.role}" />
                </div>
                <h3 class="helper-name">${helper.name}</h3>
                <p class="helper-role">${helper.role}</p>
            </div>
            <div class="card-body">
                <div class="info-item"><span class="info-label">Status:</span> <span class="status-badge">${helper.status}</span></div>
                <div class="info-item"><span class="info-label">Rating:</span> ${helper.rating} ⭐⭐</div>
                <div class="info-item"><span class="info-label">Assignments:</span> ${helper.assignments}</div>
                <div class="info-item"><span class="info-label">Assigned By:</span> ${helper.assignedBy}</div>
                <div class="info-item"><span class="info-label">Last Active:</span> ${helper.SubmitDate}</div>
                <div class="info-item"><span class="info-label">Skills:</span> ${helper.skills.join(', ')}</div>
            </div>
            <div class="card-footer">
                <span class="footer-badge ${badgeClass}">${helper.status}</span>
            </div>
        `;
        helpersGrid.appendChild(card);
    });
}



     /*============ FILTER & SORT =============*/
    function filterAndSortHelpers() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const sortValue = sortBy.value;

        let filteredHelpers = helpers.filter(helper => {
            const matchesSearch =
                helper.name.toLowerCase().includes(searchTerm) ||
                helper.role.toLowerCase().includes(searchTerm) ||
                helper.skills.some(skill => skill.toLowerCase().includes(searchTerm));

            const matchesStatus = statusValue === 'all' || helper.status.toLowerCase() === statusValue;

            return matchesSearch && matchesStatus;
        });

        // Sort
        filteredHelpers.sort((a, b) => {
            switch (sortValue) {
                case 'name': return a.name.localeCompare(b.name);
                case 'rating': return b.rating - a.rating;
                case 'assignments': return (b.assignments || '').localeCompare(a.assignments || '');
                default: return 0;
            }
        });

        renderHelpers(filteredHelpers);
    }

            /*============ EVENT LISTENERS =============*/
    searchInput.addEventListener('keyup', filterAndSortHelpers);  
    statusFilter.addEventListener('change', filterAndSortHelpers);
    sortBy.addEventListener('change', filterAndSortHelpers);

        /*============ UPDATE STATS =============*/
    function updateStats(list) {
        totalHelpers.textContent = list.length;
        availableHelpers.textContent = list.filter(h => h.status.toLowerCase() === 'in progress').length;
        busyHelpers.textContent = list.filter(h => h.status.toLowerCase() === 'pending').length;
        assignedHelpers.textContent = list.filter(h => h.status.toLowerCase() === 'working').length;
    }

    /*============ ANIMATION =============*/
    const animateValue = (element, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    };

    /*============ EVENT LISTENERS =============*/
    searchInput.addEventListener('input', filterAndSortHelpers);
    statusFilter.addEventListener('change', filterAndSortHelpers);
    sortBy.addEventListener('change', filterAndSortHelpers);

    helpersGrid.addEventListener('click', (e) => {
        if (e.target.classList.contains('assign-btn') && !e.target.disabled) {
            const card = e.target.closest('.helper-card');
            const helperName = card.querySelector('.helper-name').textContent;
            alert(`Assigning helper: ${helperName}`);
        }
    });

    loadHelpers();

});
