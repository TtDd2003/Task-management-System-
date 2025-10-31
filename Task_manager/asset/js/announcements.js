(function() {
    const form = document.getElementById('announcementForm'); // may not exist on list page
    const announcementsContainer = document.querySelector('.announcements-grid')
        || document.getElementById('announcementsContainer'); // support both patterns

    // If the container used is the upload page's container, mark as "recent"
    const isRecentContainer = announcementsContainer && announcementsContainer.id === 'announcementsContainer';
    if (isRecentContainer) {
        announcementsContainer.classList.add('recent-announcements');
    }

    // Category map
    const categoryMap = {
        general: {class: 'category-general', text: 'General'},
        urgent: {class: 'category-urgent', text: 'Urgent'},
        project: {class: 'category-project', text: 'Project Update'},
        meeting: {class: 'category-meeting', text: 'Meeting Notice'}
    };

    // create card items for notice
    function createCard(notice, fullWidth = false) {
        const col = document.createElement('div');
        col.className = fullWidth ? 'col-12' : 'col-12 col-md-6';

        const card = document.createElement('div');
        card.className = 'announcement-card';
        if (fullWidth) card.classList.add('full-width');

        const h3 = document.createElement('h3');
        h3.className = 'announcement-title';
        h3.textContent = notice.title;
        card.appendChild(h3);

        const meta = document.createElement('div');
        meta.className = 'announcement-meta';

        const badge = document.createElement('span');
        badge.className = `badge-category ${categoryMap[notice.category]?.class || ''}`;
        badge.textContent = categoryMap[notice.category]?.text || notice.category;
        meta.appendChild(badge);

        if (notice.notice_date) {
            const dateSpan = document.createElement('span');
            dateSpan.textContent = `Date: ${notice.notice_date}`;
            meta.appendChild(dateSpan);
        }

        card.appendChild(meta);

        const p = document.createElement('p');
        p.className = 'announcement-message';
        p.textContent = notice.message;
        card.appendChild(p);

        col.appendChild(card);
        return col;
    }

    //  Function to fetch and render notices (for list page)
    async function loadNotices() {
        if (!announcementsContainer) return; // no container, skip
        try {
            let url = 'get_announcements.php';
            // Only request a single most-recent item when we are on the upload page container
            if (isRecentContainer) url += '?limit=1';

            const response = await fetch(url);
            const result = await response.json();

            if (result.success) {
                announcementsContainer.innerHTML = '';
                result.notices.forEach(notice => {
                    const card = createCard(notice, isRecentContainer);
                    announcementsContainer.appendChild(card);
                });
            }
        } catch (err) {
            console.error('Error fetching notices:', err);
        }
    }

    // ✅ Handle form submission (for upload page)
    if (form) {
        let msgContainer = document.getElementById('msgContainer');
        if (!msgContainer) {
            msgContainer = document.createElement('div');
            msgContainer.id = 'msgContainer';
            msgContainer.style.marginBottom = '15px';
            form.parentNode.insertBefore(msgContainer, form);
        }

        function showMessage(message, type = 'success') {
            msgContainer.textContent = message;
            msgContainer.style.padding = '10px';
            msgContainer.style.borderRadius = '5px';
            msgContainer.style.color = '#fff';
            msgContainer.style.marginBottom = '15px';

            if (type === 'success') {
                msgContainer.style.backgroundColor = '#28a745';
            } else {
                msgContainer.style.backgroundColor = '#dc3545';
            }

            setTimeout(() => {
                msgContainer.textContent = '';
                msgContainer.style.backgroundColor = '';
            }, 5000);
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            try {
                const response = await fetch('save_notice.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(result.message, 'success');
                    // Use the same isRecentContainer flag so new notice shows full-width on upload page
                    const card = createCard(result.notice, isRecentContainer);
                    if (announcementsContainer) {
                        announcementsContainer.prepend(card);
                    }
                    form.reset();
                    form.classList.remove('was-validated');
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (err) {
                console.error(err);
                showMessage('An error occurred while saving the notice.', 'error');
            }
        });
    }

    // ✅ Auto-load notices if container exists (for list page)
    window.addEventListener('DOMContentLoaded', loadNotices);
})();
