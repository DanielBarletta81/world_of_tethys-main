(function () {
  const root = document.documentElement;
  const storageKey = 'tethysComments';
  const feed = document.querySelector('[data-comments-feed]');
  if (!feed) return;

  const emptyState = document.querySelector('[data-comments-empty]');
  const modal = document.querySelector('[data-comment-modal]');
  const form = modal?.querySelector('[data-comment-form]');
  const openers = document.querySelectorAll('[data-open-comment-modal]');
  const closers = modal?.querySelectorAll('[data-close-comment-modal]');
  const backdrop = modal?.querySelector('[data-modal-backdrop]');

  const fallbackComments = [
    {
      name: 'Ravel',
      location: 'Younger Woods healer',
      message: 'Signals 01 felt like the forest humming under my bones. The ashfall rhythm you described is exactly what I heard on last week’s hike.',
      timestamp: '2025-01-06T03:15:00.000Z'
    },
    {
      name: 'Igzier fan',
      location: 'Sky City lower tiers',
      message: 'Just re-read the exile scene with Stryker diving after him. The engineering jargon + emotion mix is *chef’s kiss*.',
      timestamp: '2025-01-04T17:41:00.000Z'
    },
    {
      name: 'Estuary scout',
      location: 'Narragansett Bay',
      message: 'Real-science page made me nostalgic for oyster sampling days. Please keep the lab notes coming.',
      timestamp: '2025-01-02T12:05:00.000Z'
    }
  ];

  const readComments = () => {
    try {
      const raw = localStorage.getItem(storageKey);
      if (!raw) return null;
      const parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed : null;
    } catch (error) {
      console.warn('Unable to read stored comments', error);
      return null;
    }
  };

  const saveComments = (comments) => {
    try {
      localStorage.setItem(storageKey, JSON.stringify(comments));
    } catch (error) {
      console.warn('Unable to save comment', error);
    }
  };

  let comments = readComments() ?? fallbackComments.slice();

  const formatTimestamp = (value) => {
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return 'Just now';
    return date.toLocaleString(undefined, {
      dateStyle: 'medium',
      timeStyle: 'short'
    });
  };

  const renderComments = () => {
    if (!comments.length) {
      feed.innerHTML = '';
      emptyState?.removeAttribute('hidden');
      return;
    }

    emptyState?.setAttribute('hidden', 'hidden');
    feed.innerHTML = comments
      .map((entry) => `
        <article class="rounded-3xl border border-slate-800/60 bg-slate-950/60 p-5 shadow-soft-bronze comment-card">
          <div class="flex items-center justify-between gap-3 text-xs uppercase tracking-[0.2em] text-slate-500">
            <span>${entry.location?.trim() || 'Unknown origin'}</span>
            <span>${formatTimestamp(entry.timestamp)}</span>
          </div>
          <h3 class="mt-2 text-lg font-semibold text-slate-50">${entry.name?.trim() || 'Anon scout'}</h3>
          <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">${entry.message}</p>
        </article>
      `)
      .join('');
  };

  const openModal = () => {
    modal?.classList.add('is-open');
    root.classList.add('tethys-modal-open');
  };

  const closeModal = () => {
    modal?.classList.remove('is-open');
    root.classList.remove('tethys-modal-open');
  };

  openers.forEach((button) => button.addEventListener('click', (event) => {
    event.preventDefault();
    openModal();
  }));

  closers.forEach((button) => button.addEventListener('click', closeModal));
  backdrop?.addEventListener('click', closeModal);
  window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
      closeModal();
    }
  });

  form?.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const message = (formData.get('message') || '').toString().trim();
    if (!message) return;

    const newEntry = {
      name: (formData.get('name') || 'Anon scout').toString().trim(),
      location: (formData.get('location') || 'Unknown origin').toString().trim(),
      message,
      timestamp: new Date().toISOString()
    };

    comments = [newEntry, ...comments].slice(0, 50);
    saveComments(comments);
    renderComments();
    form.reset();
    closeModal();
  });

  renderComments();
})();
