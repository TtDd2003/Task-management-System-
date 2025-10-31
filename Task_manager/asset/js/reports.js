
    // Self-contained client JS — runs after DOM
    (function(){
      // Helpers
      const $ = id => document.getElementById(id);
      const msg = (text, type='info') => {
        const el = $('message');
        el.innerHTML = `<div class="alert alert-${type==='error'?'danger':type==='success'?'success':'secondary'}">${text}</div>`;
      };

      // Populate projects dropdown (expects get_project.php in same folder)
      fetch('get_projects.php')
        .then(r => r.json())
        .then(data => {
          const sel = $('project_id');
          sel.innerHTML = '<option value="">Select project</option>';
          if(Array.isArray(data) && data.length){
            data.forEach(p => {
              const o = document.createElement('option');
              o.value = p.project_id;
              o.textContent = p.project_name;
              sel.appendChild(o);
            });
          } else {
            sel.innerHTML = '<option value="">No projects found</option>';
          }
        })
        .catch(err => {
          console.error('Failed loading projects', err);
          msg('Failed to load projects from server', 'error');
        });

      // Attach submit handler
      const form = $('reportForm');
      if(!form){
        console.error('reportForm not found');
        return;
      }

      form.addEventListener('submit', function(e){
        e.preventDefault();
        console.log('Form submit intercepted');

        const projectId = $('project_id').value.trim();
        const userId = $('user_id').value.trim();
        const title = $('report_title').value.trim();
        const description = $('report_description').value.trim();
        const date = $('date_of_work').value;
        const hours = $('hours_spent').value;
        const status = $('task_status').value;

        // Basic validation
        if(!projectId || !userId || !title || !date || !hours){
          msg('Please fill all required fields', 'error');
          return;
        }

        const fd = new FormData(form); // includes file input automatically

        // Submit to submit_reports.php in same folder
        fetch('submit_reports.php', {
          method: 'POST',
          body: fd
        })
        .then(resp => resp.json())
        .then(json => {
          console.log('Server response', json);
          if(json.status === 'success'){
            msg(json.message || 'Report submitted', 'success');
            form.reset();
          } else {
            msg(json.message || 'Server error', 'error');
          }
        })
        .catch(err => {
          console.error('Submission failed', err);
          msg('Network or server error while submitting', 'error');
        });
      });

      // Debug: detect overlays that might block typing
      document.addEventListener('click', (ev) => {
        // if user clicks an input and it doesn't get focus, log suspect overlay
        const target = ev.target;
        if(target && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.tagName === 'SELECT')){
          requestAnimationFrame(() => {
            if(document.activeElement !== target){
              console.warn('Input clicked but not focused — possible overlay or pointer-events issue', target);
            }
          });
        }
      });

    })();
