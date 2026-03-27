<style>
  #btnIrFim {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 57px;
    z-index: 99;
    border: none;
    outline: none;
    background-color: #0d6efd;
    color: white;
    cursor: pointer;
    padding: 2px 7px;
    border-radius: 50%;
    font-size: 14px;
    box-shadow: 0px 2px 6px rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 150ms ease;
    pointer-events: none;
  }

  #btnIrFim.is-visible {
    display: block;
    opacity: 1;
    pointer-events: auto;
  }

  #btnIrFim:hover {
    background-color: #0b5ed7;
  }
</style>

<div>
  <button id="btnIrFim" type="button">
    <i class="bi bi-arrow-down"></i>
  </button>
</div>

<script>
  (function () {
    const btn = document.getElementById('btnIrFim');
    if (!btn) return;

    const toggleBtn = () => {
      if (window.scrollY > 200) btn.classList.add('is-visible');
      else btn.classList.remove('is-visible');
    };

    window.addEventListener('scroll', toggleBtn, { passive: true });
    window.addEventListener('load', toggleBtn);

    btn.addEventListener('click', () => {
      window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    });
  })();
</script>
