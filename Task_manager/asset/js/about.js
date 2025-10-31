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