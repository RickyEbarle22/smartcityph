/* SmartCity PH — Service search autocomplete */

(function () {
  'use strict';
  const input = document.getElementById('finder-q');
  const list  = document.getElementById('finder-suggest');
  const region = document.getElementById('finder-region');
  if (!input || !list) return;

  let timer = null;
  let lastQuery = '';

  const apiBase = (window.SCPH_BASE || '').replace(/\/$/, '');

  const renderItems = (items) => {
    if (!items.length) {
      list.innerHTML = '<li style="color:var(--text-muted)">No matching services found</li>';
      list.classList.add('open');
      return;
    }
    list.innerHTML = items.map((it) => {
      const label = `${it.name} <span style="color:var(--text-muted);font-size:0.78rem">${it.category}${it.agency ? ' · ' + it.agency : ''}</span>`;
      return `<li data-slug="${it.slug}">${label}</li>`;
    }).join('');
    list.classList.add('open');
    list.querySelectorAll('li[data-slug]').forEach((li) => {
      li.addEventListener('click', () => {
        window.location.href = apiBase + '/services/' + li.dataset.slug;
      });
    });
  };

  const fetchSuggest = (q) => {
    const params = new URLSearchParams();
    params.set('q', q);
    if (region && region.value) params.set('region_id', region.value);
    fetch(apiBase + '/api/services/search?' + params.toString())
      .then((r) => r.json())
      .then((res) => renderItems(res.data || []))
      .catch(() => list.classList.remove('open'));
  };

  input.addEventListener('input', () => {
    const q = input.value.trim();
    if (q === lastQuery) return;
    lastQuery = q;
    if (timer) clearTimeout(timer);
    if (q.length < 2) { list.classList.remove('open'); return; }
    timer = setTimeout(() => fetchSuggest(q), 220);
  });

  input.addEventListener('focus', () => {
    if (input.value.trim().length >= 2) fetchSuggest(input.value.trim());
  });

  document.addEventListener('click', (e) => {
    if (!list.contains(e.target) && e.target !== input) list.classList.remove('open');
  });
})();
