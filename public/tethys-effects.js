document.addEventListener('DOMContentLoaded', () => {
  const root = document.documentElement;

  // Mouse-following orb
  const orb = document.createElement('div');
  orb.className = 'tethys-orb';
  document.body.appendChild(orb);

  const moveOrb = (event) => {
    const { clientX, clientY } = event;
    orb.style.transform = `translate(${clientX - 110}px, ${clientY - 110}px)`;
    orb.style.opacity = 1;
  };

  window.addEventListener('pointermove', moveOrb);
  window.addEventListener('pointerleave', () => {
    orb.style.opacity = 0;
  });

  // Inject modal if it doesn't exist
  let modal = document.querySelector('[data-tethys-modal]');
  if (!modal) {
    const template = document.createElement('div');
    template.innerHTML = `
      <div class="tethys-modal" data-tethys-modal aria-hidden="true" role="dialog" aria-label="Join the Tethys List">
        <div class="tethys-modal__backdrop" data-modal-backdrop></div>
        <div class="tethys-modal__panel">
          <span class="tethys-modal__glow" aria-hidden="true"></span>
          <button class="tethys-modal__close" data-close-tethys-modal aria-label="Close Tethys list">&times;</button>
          <p class="section-label inline-flex">Tethys list</p>
          <h2 class="font-display text-2xl text-slate-50 mt-3">Signals, lore, and launch alerts</h2>
          <p class="mt-2 text-sm text-slate-300">
            Drop your email to get the flight plans before they hit socials. Expect dispatch previews, creature dossiers, and patron-only unlocks.
          </p>
          <form>
            <input type="text" name="name" placeholder="Call sign / name" autocomplete="name">
            <input type="email" name="email" placeholder="Email" autocomplete="email" required>
            <button type="submit">Link me in</button>
          </form>
          <div class="tethys-modal__links">
            <a href="https://www.patreon.com/c/WorldofTethysDCBarletta" target="_blank" rel="noopener noreferrer">Patreon</a>
            <a href="https://dcbarletta.substack.com" target="_blank" rel="noopener noreferrer">Substack</a>
            <a href="https://www.youtube.com/@worldoftethysauthor" target="_blank" rel="noopener noreferrer">YouTube</a>
            <a href="https://www.tiktok.com/@worldoftethys_writer" target="_blank" rel="noopener noreferrer">TikTok</a>
          </div>
        </div>
      </div>`;
    document.body.appendChild(template.firstElementChild);
    modal = document.querySelector('[data-tethys-modal]');
  }

  // Modal controls
  if (modal) {
    const openers = document.querySelectorAll('[data-open-tethys-modal]');
    const closers = modal.querySelectorAll('[data-close-tethys-modal]');
    const backdrop = modal.querySelector('[data-modal-backdrop]');

    const openModal = () => {
      modal.classList.add('is-open');
      root.classList.add('tethys-modal-open');
      orb.style.opacity = 0;
    };

    const closeModal = () => {
      modal.classList.remove('is-open');
      root.classList.remove('tethys-modal-open');
    };

    openers.forEach((trigger) => trigger.addEventListener('click', (event) => {
      event.preventDefault();
      openModal();
    }));

    closers.forEach((btn) => btn.addEventListener('click', closeModal));
    backdrop?.addEventListener('click', closeModal);
    window.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && modal.classList.contains('is-open')) {
        closeModal();
      }
    });

    modal.querySelector('form')?.addEventListener('submit', (event) => {
      event.preventDefault();
      closeModal();
    });
  }
});
