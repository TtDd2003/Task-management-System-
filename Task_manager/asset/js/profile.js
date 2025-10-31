// ==== Form validation for user_profile ====
const form = document.getElementById('profileForm');
const userInput = document.getElementById('username');
const phoneInput = document.getElementById('phone');

function showError(el, msg) {
  let e = el.nextElementSibling;
  if (!e || !e.classList.contains('error-msg')) {
    e = document.createElement('div');
    e.className = 'error-msg text-danger';
    el.insertAdjacentElement('afterend', e);
  }
  e.textContent = msg;
}

function clearError(el) {
  let e = el.nextElementSibling;
  if (e && e.classList.contains('error-msg')) e.textContent = '';
}

form.addEventListener('submit', e => {
  let valid = true;

  // Username validation
  if (userInput.value.trim().length === 0) {
    showError(userInput, 'Username is required.');
    valid = false;
  } else if (userInput.value.length > 20) {
    showError(userInput, 'Username must be ≤ 20 characters.');
    valid = false;
  } else {
    clearError(userInput);
  }

  // Phone validation
  const phoneVal = phoneInput.value.trim();
  if (!/^\d{10}$/.test(phoneVal)) {
    showError(phoneInput, 'Phone number must be exactly 10 digits.');
    valid = false;
  } else {
    clearError(phoneInput);
  }

  if (!valid) {
    e.preventDefault(); // cancel form if errors
  }
}); // ✅ <--- this closing parenthesis was missing


// ==== Profile image preview ====
const input = document.getElementById('profilePicInput');
const preview = document.getElementById('previewProfileImg');
const sidebarImg = document.getElementById('previewSidebarImg');

if (input && preview) {
  input.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.style.backgroundImage = `url('${e.target.result}')`;
        if (sidebarImg) {
          sidebarImg.style.backgroundImage = `url('${e.target.result}')`;
        }
      };
      reader.readAsDataURL(file);
    }
  });
}

// ==== Sidebar toggling ====
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('toggleSidebarBtn');
  const sidebar = document.getElementById('sidebar');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => {
      console.log("Toggling sidebar");
      sidebar.classList.toggle('d-none');
    });
  } else {
    console.error("Sidebar or toggle button not found!");
  }
});


// ==== Add alternative email field ====
const addEmailBtn = document.getElementById('addEmailBtn');
const container = document.getElementById('emailFieldContainer');

if (addEmailBtn && container) {
  addEmailBtn.addEventListener('click', () => {
    container.innerHTML = `
      <label for="alternative_email" class="block text-gray-700 font-medium mb-2">Alternative Email</label>
      <input type="email" name="alternative_email" id="alternative_email"
        class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        placeholder="Enter alternative email" />`;
  });
}



 const ntbtn = document.getElementById('notifications');
    const panel = document.getElementById('notificationPanel');
    const list = document.getElementById('notificationList');

    const dummyNotifications = [
  { icon: 'fas fa-file-invoice-dollar', color: '#facc15', title: 'Tax report submitted to finance', time: 'Today, 10:30 AM' },  // Yellow
  { icon: 'fas fa-clipboard-check', color: '#22c55e', title: 'Q3 Tax Form Approved', time: 'Yesterday, 5:00 PM' }, // Green
  { icon: 'fas fa-exclamation-circle', color: '#ef4444', title: 'Pending Tax Filing - Q4', time: 'Due in 3 days' } // Red
];

if (ntbtn && panel && list) {
  ntbtn.addEventListener('click', () => {
    panel.classList.toggle('hidden');

    if (!panel.classList.contains('hidden')) {
      list.innerHTML = ''; // Clear previous

      dummyNotifications.forEach(notif => {
        const item = document.createElement('div');
        item.className = 'notification-item d-flex align-items-center mb-3 p-3 rounded-4 shadow-sm';
        item.style.background = 'rgba(255, 255, 255, 0.8)';   // semi-transparent white
        item.style.backdropFilter = 'blur(6px)';              // frosted glass effect

        item.innerHTML = `
          <div class="d-flex align-items-center">
            <div class="icon text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                 style="width: 40px; height: 40px; background-color: ${notif.color};">
              <i class="${notif.icon}"></i>
            </div>
            <div>
              <div class="fw-semibold text-dark">${notif.title}</div>
              <div class="small text-muted">${notif.time}</div>
            </div>
          </div>
        `;

        list.appendChild(item);
      });
    }
  });
}

//======== edit bio ========//
  const editBtn = document.getElementById('editBioBtn');
  const bioView = document.getElementById('bioView');
  const bioText = document.getElementById('bioText');
  const bioInput = document.getElementById('bioInput');

  // Helper to switch to edit (show textarea)
  function enterEditMode() {
    bioInput.classList.remove('d-none');
    bioInput.focus();
    bioView.classList.add('d-none');
    editBtn.innerHTML = '<i class="fas fa-save"></i>';
    editBtn.classList.remove('btn-outline-secondary');
    editBtn.classList.add('btn-success');
  }

  // Helper to switch to view mode (show saved text)
  function enterViewMode(newBio) {
    bioText.textContent = newBio || ''; // keep exact text
    bioView.classList.remove('d-none');
    bioInput.classList.add('d-none');
    editBtn.innerHTML = '<i class="fas fa-pencil-alt"></i>';
    editBtn.classList.remove('btn-success');
    editBtn.classList.add('btn-outline-secondary');
  }

  editBtn.addEventListener('click', function () {
    // If we are currently in "view", go to edit
    if (bioInput.classList.contains('d-none')) {
      enterEditMode();
      return;
    }

    // Otherwise, save (AJAX)
    const newBio = bioInput.value.trim();

    // optional client-side length check
    if (newBio.length > 2000) {
      alert('Bio must be 2000 characters or fewer.');
      return;
    }

    // Disable button while saving
    editBtn.disabled = true;
    editBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    // Send AJAX request to save_profile.php (bio_only=1 tells server it's inline update)
    fetch('save_profile.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'bio=' + encodeURIComponent(newBio) + '&bio_only=1'
    })
    .then(response => response.json())
    .then(data => {
      editBtn.disabled = false;
      if (data.status === 'ok') {
        // update view & keep textarea value in sync (so full form will also have the updated value)
        bioInput.value = data.bio;
        enterViewMode(data.bio);
      } else {
        alert('Error saving bio: ' + (data.message || 'Unknown error'));
        // revert button icon
        editBtn.innerHTML = '<i class="fas fa-save"></i>';
      }
    })
    .catch(err => {
      editBtn.disabled = false;
      editBtn.innerHTML = '<i class="fas fa-save"></i>';
      console.error(err);
      alert('Network error while saving bio.');
    });
  });

