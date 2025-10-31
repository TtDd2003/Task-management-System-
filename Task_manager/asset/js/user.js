document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');
    const errorContainer = document.getElementById('errorContainer');
    const errorMessage = document.getElementById('errorMessage');

    const validateField = (field, validationFn, errorElement) => {
        const isValid = validationFn(field.value.trim());
        field.classList.toggle('border-red-300', !isValid);
        field.classList.toggle('border-gray-300', isValid);
        errorElement.classList.toggle('hidden', isValid);
        return isValid;
    };

    const validateName = (name) => /^[a-zA-Z' -]{2,}$/.test(name);
    const validateEmail = (email) => /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email);
    const validatePassword = (password) => password.length >= 8;

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // prevent page reload

        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const terms = document.getElementById('terms'); // if used

        let formIsValid = true;

        formIsValid &= validateField(firstName, validateName, document.getElementById('firstNameError'));
        formIsValid &= validateField(lastName, validateName, document.getElementById('lastNameError'));
        formIsValid &= validateField(email, validateEmail, document.getElementById('emailError'));
        formIsValid &= validateField(password, validatePassword, document.getElementById('passwordError'));

        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add('border-red-300');
            document.getElementById('confirmPasswordError').classList.remove('hidden');
            formIsValid = false;
        } else {
            confirmPassword.classList.remove('border-red-300');
            document.getElementById('confirmPasswordError').classList.add('hidden');
        }

        if (terms && !terms.checked) {
            document.getElementById('termsError').classList.remove('hidden');
            formIsValid = false;
        } else if (terms) {
            document.getElementById('termsError').classList.add('hidden');
        }

        if (!formIsValid) {
            errorContainer.classList.remove('hidden');
            errorMessage.textContent = 'Please correct the errors in the form and try again.';
            return;
        }

        // Submit data to PHP
        const formData = new FormData(form);

        try {
            const response = await fetch('insert_user.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                form.reset();
            } else {
                errorContainer.classList.remove('hidden');
                errorMessage.textContent = data.message || 'Registration failed.';
            }
        } catch (error) {
            errorContainer.classList.remove('hidden');
            errorMessage.textContent = 'Error submitting form. Please try again.';
        }
    });
});



  // ======= this section for getting user_id from row  =========//

  $(document).ready(function () {
    $('.editUserBtn').on('click', function (e) {
      e.preventDefault();

      var userId = $(this).data('id');

      $.ajax({
        url: 'user_data.php', // herer user_id getting fetched--
        type: 'GET',
        data: { id: userId },
        dataType: 'json',
        success: function (data) {
          if (data.error) {
            alert(data.error);
          } else {
            $('#edit-id').val(data.id);
            $('#edit-username').val(data.username);
            $('#edit-firstname').val(data.first_name);
            $('#edit-lastname').val(data.last_name);
            $('#edit-email').val(data.email);
            $('#edit-phone').val(data.phone_number);
          }
        },
        error: function () {
          alert('Something went wrong while fetching user data.');
        }
      });
    });
  });

  // ===== this is for updation after submission data ====== // 

 $('#editUserForm').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: 'update_user.php', // where updated data stores---
    type: 'POST',
    data: $(this).serialize(),
    success: function (response) {
      if (response.trim() === "success") {
        Swal.fire({
            title: 'Updated!',
            text: 'User updated successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => 
        {
            if (result.isConfirmed) {
              $('#editUserModal').modal('hide');
              location.reload(); // Reload **after** alert is closed
            }
          });
      } else {
        alert("Something went wrong: " + response);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", xhr.responseText);
      alert('Update failed: ' + xhr.responseText);
    }
  });
});

  // ========== delete user confirmation ===== //

  $(document).ready(function () {
  $('.delete').on('click', function () {
    var userId = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "User will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_user.php',
          type: 'POST',
          data: { id: userId },
          success: function (response) {
            if (response.trim() === "success") {
              Swal.fire(
                'Deleted!',
                'User has been deleted.',
                'success'
              ).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', 'Could not delete user.', 'error');
            }
          },
          error: function () {
            Swal.fire('Error!', 'Something went wrong.', 'error');
          }
        });
      }
    });
  });
});

  // reset filtering button ======== 

 function resetFilter() {
    const form = document.querySelector('#filterForm');
    if (!form) return;

    form.reset();
    window.location.href = window.location.pathname;
  }
  document.addEventListener('DOMContentLoaded', function () {
  const profilePicInput = document.getElementById('profilePicInput');
  if (profilePicInput) {
    profilePicInput.addEventListener('change', function (event) {
      const preview = document.querySelector('#previewProfileImg img');
      const file = event.target.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
          if (preview) {
            preview.src = e.target.result;
          }
        };
        reader.readAsDataURL(file);
      }
    });
  }
});

