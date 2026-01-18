// Lightweight API client for edu-meeting
const API_BASE = window.API_BASE || '';

async function apiGet(path) {
  const res = await fetch(API_BASE + path);
  if (!res.ok) throw new Error(`API error ${res.status}`);
  return res.json();
}

function createCourseCard(course) {
  const div = document.createElement('div');
  div.className = 'box';
  div.innerHTML = `
    <div class="tutor">
      <img src="${course.thumbnail || 'images/pic-2.jpg'}" alt="">
      <div class="info">
        <h3>${course.teacher_name || 'Teacher'}</h3>
        <span>${new Date(course.created_at).toLocaleDateString()}</span>
      </div>
    </div>
    <div class="thumb">
      <img src="${course.thumbnail || 'images/thumb-1.png'}" alt="">
      <span>-- videos --</span>
    </div>
    <h3 class="title">${course.title}</h3>
    <a href="playlist.html?courseId=${course.id}" class="inline-btn">view playlist</a>
  `;
  return div;
}

async function renderCourses(selector) {
  try {
    const container = document.querySelector(selector);
    if (!container) return;
    const courses = await apiGet('/api/courses');
    container.innerHTML = '';
    courses.forEach(c => container.appendChild(createCourseCard(c)));
  } catch (err) {
    console.error(err);
  }
}

async function renderPlaylistDetails(playlistId, detailsContainerSelector, videosContainerSelector) {
  try {
    const details = await apiGet('/api/playlists/' + playlistId);
    // Support older detail container shape or new .playlist-meta / .playlist-info
    const dc = document.querySelector(detailsContainerSelector) || document.querySelector('.playlist-meta');
    const info = document.querySelector('.playlist-info');
    if (dc && dc.querySelector('.thumb img')) dc.querySelector('.thumb img').src = details.thumbnail || 'images/thumb-1.png';
    if (dc && dc.querySelector('.tutor h3')) dc.querySelector('.tutor h3').textContent = details.title || '';
    if (info && info.querySelector('.details h3')) info.querySelector('.details h3').textContent = details.title || '';
    if (info && info.querySelector('.details p')) info.querySelector('.details p').textContent = details.description || '';
    const vc = document.querySelector(videosContainerSelector);
    if (vc) {
      vc.innerHTML = '';
      details.videos.forEach(v => {
        const a = document.createElement('a');
        a.className = 'box';
        a.href = `watch-video.html?videoId=${v.id}`;
        a.innerHTML = `<i class="fas fa-play"></i><img src="images/post-1-1.png" alt=""><h3>${v.title}</h3>`;
        vc.appendChild(a);
      });
    }
  } catch (err) { console.error(err); }
}

async function renderVideoPlayer(videoId, videoContainerSelector) {
  try {
    const v = await apiGet('/api/videos/' + videoId);
    const c = document.querySelector(videoContainerSelector);
    if (!c) return;
    c.innerHTML = '';
    if (v.provider && v.provider.provider === 'youtube') {
      const iframe = document.createElement('iframe');
      // try to convert URL to embed if needed
      let embed = v.provider.url;
      if (embed.includes('watch?v=')) embed = embed.replace('watch?v=', 'embed/');
      if (embed.includes('youtu.be/')) embed = embed.replace('youtu.be/', 'www.youtube.com/embed/');
      iframe.src = embed;
      iframe.width = '100%';
      iframe.height = '500';
      iframe.allow = 'accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      c.appendChild(iframe);
    } else if (v.provider && v.provider.provider === 'vimeo') {
      const iframe = document.createElement('iframe');
      iframe.src = v.provider.url;
      iframe.width = '100%';
      iframe.height = '500';
      iframe.allow = 'autoplay; fullscreen; picture-in-picture';
      iframe.allowFullscreen = true;
      c.appendChild(iframe);
    } else if (v.provider && v.provider.provider === 'self') {
      const video = document.createElement('video');
      video.controls = true;
      video.width = '100%';
      const src = v.url || v.file_path;
      const source = document.createElement('source');
      source.src = src;
      video.appendChild(source);
      c.appendChild(video);
    } else {
      c.textContent = 'Cannot play this video format';
    }
    // set title/description if the page has them
    const titleEl = document.querySelector('.title');
    if (titleEl) titleEl.textContent = v.title || '';
    const descEl = document.querySelector('.description');
    if (descEl) descEl.textContent = v.description || '';
    // populate tutor info if possible
    try{
      if (v.course_id) {
        const course = await apiGet('/api/courses/' + v.course_id);
        if (course) {
          const tutorImg = document.querySelector('.video-container .tutor img');
          const tutorName = document.querySelector('.video-container .tutor h3');
          const tutorRole = document.querySelector('.video-container .tutor span');
          if (tutorImg && course.thumbnail) tutorImg.src = course.thumbnail;
          if (tutorName) tutorName.textContent = course.teacher_name || '';
          if (tutorRole) tutorRole.textContent = course.category || '';
        }
      }
      // set date if available
      const dateEl = document.querySelector('.video-container .info .date span');
      if (dateEl && v.created_at) dateEl.textContent = new Date(v.created_at).toLocaleDateString();
    }catch(e){/* non-fatal */}
  } catch (err) { console.error(err); }
}

export { renderCourses, renderPlaylistDetails, renderVideoPlayer };
