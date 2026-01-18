async function api(path, opts={}){
  const res = await fetch(path, opts);
  const txt = await res.text();
  try { return JSON.parse(txt); } catch(e) { return txt; }
}

// Auth
const authDiv = document.getElementById('auth');
const dash = document.getElementById('dashboard');
const loginBtn = document.getElementById('loginBtn');
const logoutBtn = document.getElementById('logoutBtn');
const authMsg = document.getElementById('authMsg');

// Sidebar nav wiring
const sidebar = document.querySelector('.admin-sidebar');
function showPanel(id){
  document.querySelectorAll('.admin-panel').forEach(p=>p.classList.add('hidden'));
  const el = document.getElementById(id);
  if (el) el.classList.remove('hidden');
  // mark active
  document.querySelectorAll('.admin-sidebar li').forEach(li=>li.classList.remove('active'));
  const li = document.querySelector(`.admin-sidebar li[data-panel="${id}"]`);
  if (li) li.classList.add('active');
}
if (sidebar){
  sidebar.addEventListener('click', (e)=>{
    const li = e.target.closest('li'); if(!li) return;
    const panel = li.dataset.panel; if(panel) showPanel(panel);
  });
}

loginBtn && (loginBtn.onclick = async () => {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  if (!email || !password) { authMsg.textContent = 'Please fill both fields'; return; }
  const r = await api('/api/auth/login',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify({email,password})});
  if (r && r.error) { authMsg.textContent = r.error; return; }
  authDiv.classList.add('hidden'); dash.classList.remove('hidden');
  showPanel('panel-overview');
  loadAll();
});

logoutBtn && (logoutBtn.onclick = async () => { await api('/api/auth/logout',{method:'POST'}); location.reload(); });

// Upload
const uploadForm = document.getElementById('uploadForm');
const uploadRes = document.getElementById('uploadRes');
uploadForm && uploadForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(uploadForm);
  const res = await fetch('/api/admin/upload',{method:'POST',body:fd});
  const j = await res.json();
  uploadRes.textContent = JSON.stringify(j,null,2);
});

// Render helpers
async function loadAll(){ await loadTeachers(); await loadCourses(); await loadPlaylists(); await loadVideos(); loadEnrollments(); }

async function loadTeachers(){
  const panel = document.getElementById('teachersPanel');
  panel.innerHTML = '<button id="newTeacherBtn" class="btn">New Teacher</button><div id="teacherList"></div>';
  document.getElementById('newTeacherBtn').onclick = ()=>{ showPanel('panel-teacher-add'); newTeacherForm(); };
  const list = document.getElementById('teacherList');
  const rows = await api('/api/admin/teachers');
  if (!Array.isArray(rows)) { list.textContent = 'Error: ' + JSON.stringify(rows); return; }
  const table = document.createElement('table');
  table.innerHTML = '<tr><th>ID</th><th>Name</th><th>Avatar</th><th>Actions</th></tr>';
  rows.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.name}</td><td><img src="${r.avatar||''}" style="height:40px"/></td><td><button data-id="${r.id}" class="btn edit-teacher">Edit</button> <button data-id="${r.id}" class="btn danger del-teacher">Delete</button></td>`;
    table.appendChild(tr);
  });
  list.appendChild(table);
  list.querySelectorAll('.del-teacher').forEach(b=>b.onclick = async (e)=>{ if(!confirm('Delete?'))return; const id=e.target.dataset.id; await fetch('/api/admin/teachers/'+id,{method:'DELETE'}); loadTeachers(); });
  list.querySelectorAll('.edit-teacher').forEach(b=>b.onclick = async (e)=>{ const id=e.target.dataset.id; editTeacherForm(id); });
}

function newTeacherForm(){
  const panel = document.getElementById('teacherAddPanel');
  panel.innerHTML = '';
  const form = document.createElement('form');
  form.innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;align-items:start">
      <div>
        <label>Name</label>
        <input name="name" required placeholder="Full name" />
        <label>Email (optional - creates login)</label>
        <input name="email" type="email" placeholder="teacher@example.com" />
        <label>Password (optional)</label>
        <input name="password" type="password" placeholder="create a password" />
        <label>Phone (optional)</label>
        <input name="phone" placeholder="+123..." />
      </div>
      <div>
        <label>Bio</label>
        <textarea name="bio" rows="6" placeholder="Short bio"></textarea>
        <label>Avatar URL (or /uploads/...)</label>
        <input name="avatar" placeholder="/uploads/avatar-123.jpg" />
        <div style="margin-top:8px;color:#666;font-size:0.9em">Check "Create account" to also create a teacher login with the email/password provided.</div>
        <label style="margin-top:6px"><input type="checkbox" name="create_account" /> Create account</label>
      </div>
    </div>
    <div style="margin-top:10px"><button class="btn">Create teacher</button></div>
  `;
  form.onsubmit = async (e)=>{
    e.preventDefault();
    const fd = new FormData(form); const obj = {}; fd.forEach((v,k)=>obj[k]=v);
    // create teacher record
    const tPayload = { name: obj.name, bio: obj.bio || null, avatar: obj.avatar || null };
    const r = await api('/api/admin/teachers',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify(tPayload)});
    if (!(r && r.id)) { alert('Error creating teacher: ' + JSON.stringify(r)); return; }
    // optionally create user account
    if (fd.get('create_account') === 'on' && obj.email && obj.password){
      const uPayload = { email: obj.email, password: obj.password, name: obj.name, role: 'teacher' };
  const ur = await fetch('/api/admin/users',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify(uPayload)});
      const uj = await ur.json();
      if (uj && uj.error) { alert('Teacher created but user creation failed: '+JSON.stringify(uj)); }
    }
    alert('Teacher created'); showPanel('panel-teachers'); loadTeachers();
  };
  panel.appendChild(form);
}

async function editTeacherForm(id){
  const t = await api('/api/admin/teachers/' + id);
  const panel = document.getElementById('teachersPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Name</label><input name="name" value="${t.name||''}" required/><label>Bio</label><textarea name="bio">${t.bio||''}</textarea><label>Avatar URL</label><input name="avatar" value="${t.avatar||''}"/><button class="btn">Save</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/teachers/'+id,{method:'PUT',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); loadTeachers(); };
  panel.appendChild(form);
}

async function loadCourses(){
  const panel = document.getElementById('coursesPanel');
  panel.innerHTML = '<div id="courseList"></div>';
  const newBtn = document.createElement('button'); newBtn.className='btn'; newBtn.textContent='New Course'; newBtn.onclick = ()=>{ showPanel('panel-course-add'); newCourseForm(); };
  panel.prepend(newBtn);
  const list = document.getElementById('courseList');
  const rows = await api('/api/admin/courses');
  if (!Array.isArray(rows)) { list.textContent = 'Error: ' + JSON.stringify(rows); return; }
  const table = document.createElement('table');
  table.innerHTML = '<tr><th>ID</th><th>Title</th><th>Teacher</th><th>Actions</th></tr>';
  rows.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.title}</td><td>${r.teacher_id||''}</td><td><button data-id="${r.id}" class="btn edit-course">Edit</button> <button data-id="${r.id}" class="btn danger del-course">Delete</button></td>`;
    table.appendChild(tr);
  });
  list.appendChild(table);
  list.querySelectorAll('.del-course').forEach(b=>b.onclick = async (e)=>{ if(!confirm('Delete?'))return; const id=e.target.dataset.id; await fetch('/api/admin/courses/'+id,{method:'DELETE'}); loadCourses(); });
  list.querySelectorAll('.edit-course').forEach(b=>b.onclick = async (e)=>{ const id=e.target.dataset.id; editCourseForm(id); });
}

function newCourseForm(){
  const panel = document.getElementById('courseAddPanel');
  panel.innerHTML = '';
  const form = document.createElement('form');
  form.style.display = 'grid';
  form.style.gridTemplateColumns = '1fr 300px';
  form.style.gap = '12px';
  form.innerHTML = `
    <div>
      <label>Title</label>
      <input name="title" required placeholder="Course title" />
      <label>Summary</label>
      <textarea name="description" rows="4" placeholder="Short course summary"></textarea>
      <label>Price (0 for free)</label>
      <input name="price" type="number" min="0" value="0" />
      <label>Teacher</label>
      <select name="teacher_id" id="course-teacher-select"></select>
      <label style="margin-top:8px">Course Image URL (or /uploads/...)</label>
      <input name="thumbnail" placeholder="/uploads/course-1.jpg" />
      <label>Category</label>
      <input name="category" placeholder="Category" />
    </div>
    <div style="border-left:1px solid #eee;padding-left:12px">
      <div style="background:#fafafa;padding:8px;border-radius:6px">Preview</div>
      <div id="course-preview" style="margin-top:8px"></div>
      <div style="margin-top:12px"><button class="btn">Create course</button></div>
    </div>
  `;
  // populate teachers
  setTimeout(async ()=>{
    const teachers = await api('/api/admin/teachers');
    const sel = form.querySelector('#course-teacher-select');
    sel.innerHTML = '<option value="">-- select teacher --</option>';
    teachers.forEach(t=>{ const o = document.createElement('option'); o.value = t.id; o.textContent = t.name; sel.appendChild(o); });
  },50);
  // preview logic
  form.addEventListener('input', ()=>{
    const title = form.title.value || 'Untitled course';
    const summary = form.description.value || '';
    const img = form.thumbnail.value || '/images/thumb-1.png';
    const preview = form.querySelector('#course-preview');
    preview.innerHTML = `<div style="display:flex;gap:8px"><img src="${img}" style="width:100px;height:60px;object-fit:cover;border-radius:6px"/><div><strong>${title}</strong><div style="font-size:0.9em;color:#666">${summary}</div></div></div>`;
  });
  form.onsubmit = async (e)=>{
    e.preventDefault(); const fd = new FormData(form); const obj = {}; fd.forEach((v,k)=>obj[k]=v);
    const payload = { title: obj.title, description: obj.description||null, image: obj.thumbnail||null, price: Number(obj.price||0), teacher_id: obj.teacher_id||null, category: obj.category||null };
    const r = await api('/api/admin/courses',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify({ title: payload.title, description: payload.description, price: payload.price, teacher_id: payload.teacher_id, thumbnail: payload.image, category: payload.category })});
    if(r && r.id){ alert('Course created'); showPanel('panel-courses'); loadCourses(); } else alert('Error: '+JSON.stringify(r));
  };
  panel.appendChild(form);
}

async function editCourseForm(id){
  const t = await api('/api/admin/courses/' + id);
  const panel = document.getElementById('coursesPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Title</label><input name="title" value="${t.title||''}" required/><label>Description</label><textarea name="description">${t.description||''}</textarea><label>Price</label><input name="price" value="${t.price||''}"/><label>Teacher ID</label><input name="teacher_id" value="${t.teacher_id||''}"/><label>Thumbnail URL</label><input name="thumbnail" value="${t.thumbnail||''}"/><label>Category</label><input name="category" value="${t.category||''}"/><button class="btn">Save</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/courses/'+id,{method:'PUT',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); loadCourses(); };
  panel.appendChild(form);
}

async function loadPlaylists(){
  const panel = document.getElementById('playlistsPanel');
  panel.innerHTML = '<button id="newPlaylistBtn" class="btn">New Playlist</button><div id="playlistList"></div>';
  document.getElementById('newPlaylistBtn').onclick = ()=>{ newPlaylistForm(); showPanel('panel-playlists'); };
  const list = document.getElementById('playlistList');
  const rows = await api('/api/admin/playlists');
  if (!Array.isArray(rows)) { list.textContent = 'Error: ' + JSON.stringify(rows); return; }
  const table = document.createElement('table');
  table.innerHTML = '<tr><th>ID</th><th>Title</th><th>Course</th><th>Actions</th></tr>';
  rows.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.title}</td><td>${r.course_id||''}</td><td><button data-id="${r.id}" class="btn edit-playlist">Edit</button> <button data-id="${r.id}" class="btn danger del-playlist">Delete</button></td>`;
    table.appendChild(tr);
  });
  list.appendChild(table);
  list.querySelectorAll('.del-playlist').forEach(b=>b.onclick = async (e)=>{ if(!confirm('Delete?'))return; const id=e.target.dataset.id; await fetch('/api/admin/playlists/'+id,{method:'DELETE'}); loadPlaylists(); });
  list.querySelectorAll('.edit-playlist').forEach(b=>b.onclick = async (e)=>{ const id=e.target.dataset.id; editPlaylistForm(id); });
}

async function loadEnrollments(){
  const panel = document.getElementById('enrollmentsPanel');
  if (!panel) return;
  const rows = await api('/api/enrollments');
  if (rows && rows.error) { panel.textContent = JSON.stringify(rows); return; }
  // rows will be per-user; admin endpoint for course enrollments exists at /api/enrollments/course/:courseId
  // For admin overview, request recent enrollments by querying enrollments for first course
  panel.innerHTML = '';
  if (!Array.isArray(rows) || rows.length === 0){ panel.textContent = 'No enrollments found (for this admin session)'; return; }
  const table = document.createElement('table');
  table.innerHTML = '<tr><th>ID</th><th>Course</th><th>Date</th></tr>';
  rows.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.course_title||r.course_id}</td><td>${new Date(r.created_at).toLocaleString()}</td>`;
    table.appendChild(tr);
  });
  panel.appendChild(table);
}

function newPlaylistForm(){
  const panel = document.getElementById('playlistsPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Course ID</label><input name="course_id" required/><label>Title</label><input name="title" required/><label>Description</label><textarea name="description"></textarea><label>Thumbnail</label><input name="thumbnail"/><button class="btn">Create</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/playlists',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); if(r && r.id) loadPlaylists(); else alert(JSON.stringify(r)); };
  panel.prepend(form);
}

async function editPlaylistForm(id){
  const t = await api('/api/admin/playlists/' + id);
  const panel = document.getElementById('playlistsPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Course ID</label><input name="course_id" value="${t.course_id||''}" required/><label>Title</label><input name="title" value="${t.title||''}" required/><label>Description</label><textarea name="description">${t.description||''}</textarea><label>Thumbnail</label><input name="thumbnail" value="${t.thumbnail||''}"/><button class="btn">Save</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/playlists/'+id,{method:'PUT',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); loadPlaylists(); };
  panel.appendChild(form);
}

async function loadVideos(){
  const panel = document.getElementById('videosPanel');
  panel.innerHTML = '<button id="newVideoBtn" class="btn">New Video</button><div id="videoList"></div>';
  document.getElementById('newVideoBtn').onclick = newVideoForm;
  const list = document.getElementById('videoList');
  const rows = await api('/api/admin/videos');
  if (!Array.isArray(rows)) { list.textContent = 'Error: ' + JSON.stringify(rows); return; }
  const table = document.createElement('table');
  table.innerHTML = '<tr><th>ID</th><th>Title</th><th>Provider</th><th>Actions</th></tr>';
  rows.forEach(r=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${r.id}</td><td>${r.title}</td><td>${r.provider}</td><td><button data-id="${r.id}" class="btn edit-video">Edit</button> <button data-id="${r.id}" class="btn danger del-video">Delete</button></td>`;
    table.appendChild(tr);
  });
  list.appendChild(table);
  list.querySelectorAll('.del-video').forEach(b=>b.onclick = async (e)=>{ if(!confirm('Delete?'))return; const id=e.target.dataset.id; await fetch('/api/admin/videos/'+id,{method:'DELETE'}); loadVideos(); });
  list.querySelectorAll('.edit-video').forEach(b=>b.onclick = async (e)=>{ const id=e.target.dataset.id; editVideoForm(id); });
}

function newVideoForm(){
  const panel = document.getElementById('videosPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Playlist ID</label><input name="playlist_id"/><label>Course ID</label><input name="course_id"/><label>Title</label><input name="title" required/><label>Description</label><textarea name="description"></textarea><label>URL (YouTube/Vimeo)</label><input name="url"/><label>File path (after upload, e.g. /uploads/..)</label><input name="file_path"/><label>Position</label><input name="position" type="number" value="0"/><button class="btn">Create</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/videos',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); if(r && r.id) loadVideos(); else alert(JSON.stringify(r)); };
  panel.appendChild(form);
}

async function editVideoForm(id){
  const t = await api('/api/admin/videos/' + id);
  const panel = document.getElementById('videosPanel');
  const form = document.createElement('form');
  form.innerHTML = `<label>Title</label><input name="title" value="${t.title||''}" required/><label>Description</label><textarea name="description">${t.description||''}</textarea><label>Position</label><input name="position" type="number" value="${t.position||0}"/><button class="btn">Save</button>`;
  form.onsubmit = async (e)=>{ e.preventDefault(); const fd=new FormData(form); const obj={}; fd.forEach((v,k)=>obj[k]=v); const r = await api('/api/admin/videos/'+id,{method:'PUT',headers:{'content-type':'application/json'},body:JSON.stringify(obj)}); loadVideos(); };
  panel.appendChild(form);
}

// On load, attempt to check session
(async ()=>{
  try {
    const me = await api('/api/auth/me');
    if (me && !me.error) { authDiv.classList.add('hidden'); dash.classList.remove('hidden'); loadAll(); }
  } catch(e){}
})();

// Quick actions on overview
document.addEventListener('DOMContentLoaded', ()=>{
  const cT = document.getElementById('quickCreateTeacher');
  if (cT) cT.onclick = ()=>{ showPanel('panel-teacher-add'); newTeacherForm(); };
  const cC = document.getElementById('quickCreateCourse');
  if (cC) cC.onclick = ()=>{ showPanel('panel-course-add'); newCourseForm(); };
});
