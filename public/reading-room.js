const messagesList = document.querySelector('[data-reading-room-messages]');
const sessionState = document.querySelector('[data-session-state]');
const feedback = document.querySelector('[data-reading-room-feedback]');
const loginBtn = document.querySelector('[data-login]');
const logoutBtn = document.querySelector('[data-logout]');
const form = document.getElementById('reading-room-form');

async function fetchJSON(url, options) {
  const response = await fetch(url, {
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    ...options
  });
  if (response.status === 401) {
    throw new Error('unauthorized');
  }
  if (!response.ok) {
    const text = await response.text();
    throw new Error(text || 'Request failed');
  }
  return response.json();
}

function renderMessages(messages = []) {
  if (!messagesList) return;
  if (!messages.length) {
    messagesList.innerHTML = '<li class="text-slate-500">Room is silent. Be the first to post.</li>';
    return;
  }

  messagesList.innerHTML = messages
    .map(
      (msg) => `
        <li class="rounded-2xl border border-slate-800/60 bg-slate-950/60 p-3">
          <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.18em] text-slate-500">
            <span>${msg.user?.name || 'Watcher'}</span>
            <time>${new Date(msg.timestamp).toLocaleString()}</time>
          </div>
          <p class="mt-2 text-sm text-slate-200">${msg.content}</p>
        </li>`
    )
    .join('');
}

function setFormEnabled(enabled) {
  if (!form) return;
  if (enabled) {
    form.classList.remove('opacity-40', 'pointer-events-none');
    form.removeAttribute('aria-disabled');
  } else {
    form.classList.add('opacity-40', 'pointer-events-none');
    form.setAttribute('aria-disabled', 'true');
  }
}

async function refreshSession() {
  if (!sessionState) return;
  try {
    const data = await fetchJSON('/api/me');
    if (data.authenticated) {
      sessionState.textContent = `Signed in as ${data.user?.name || data.user?.email || 'Watcher'}`;
      loginBtn?.classList.add('hidden');
      logoutBtn?.classList.remove('hidden');
      setFormEnabled(true);
      await refreshMessages();
    } else {
      sessionState.textContent = 'You must log in to read or post.';
      loginBtn?.classList.remove('hidden');
      logoutBtn?.classList.add('hidden');
      setFormEnabled(false);
      renderMessages();
    }
  } catch (error) {
    sessionState.textContent = 'Reading Room offline. Try again soon.';
    console.error(error);
  }
}

async function refreshMessages() {
  try {
    const data = await fetchJSON('/api/reading-room/messages');
    renderMessages(data.messages);
  } catch (error) {
    if (error.message === 'unauthorized') {
      sessionState.textContent = 'Log in to load the room.';
      setFormEnabled(false);
    }
  }
}

form?.addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  const content = formData.get('content');
  if (!content) return;
  feedback.textContent = 'Sending…';
  try {
    await fetchJSON('/api/reading-room/messages', {
      method: 'POST',
      body: JSON.stringify({ content })
    });
    form.reset();
    feedback.textContent = 'Sent!';
    refreshMessages();
  } catch (error) {
    feedback.textContent = error.message.includes('unauthorized')
      ? 'Log in to post.'
      : 'Could not send. Try again.';
  }
});

refreshSession();
setInterval(refreshMessages, 15000);
