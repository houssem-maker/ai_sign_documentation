/**
 * AiSign API Docs — Client-Side Search
 * public/js/docs-search.js
 */
(function () {
  'use strict';

  const input      = document.getElementById('docs-search-input');
  const wrapper    = document.getElementById('docs-search-wrapper');
  const dropdown   = document.getElementById('docs-search-dropdown');
  const elLoading  = document.getElementById('docs-search-loading');
  const elEmpty    = document.getElementById('docs-search-empty');
  const elResults  = document.getElementById('docs-search-results');
  const elFooter   = document.getElementById('docs-search-footer');

  if (!input || !wrapper || !dropdown) return;

  let fuse        = null;
  let fuseReady   = false;
  let fuseError   = false;
  let resultItems = [];
  let activeIdx   = -1;

  const SECTIONS = {
    introduction:      { label:'Getting Started', img:'/images/documentation-guide-icon.png'     },
    authentication:    { label:'Authentication',  img:'/images/documentation-key-icon.png'       },
    templates:         { label:'Templates',       img:'/images/documentation-template-icon.png'  },
    documents:         { label:'Documents',       img:'/images/documentation-documents-icon.png' },
    tokens:            { label:'Tokens',          img:'/images/documentation-lock-icon.png'      },
    logs:              { label:'Logs',            img:'/images/documentation-logs-icon.png'      },
    webhooks:          { label:'Webhooks',        img:'/images/documentation-bell-icon.png'      },
    'error-handling':  { label:'Error Handling',  img:'/images/documentation-error-icon.png'     },
    limits:            { label:'Limits & Quotas', img:'/images/documentation-lock-icon.png'      },
    'status-lifecycle':{ label:'Status Lifecycle',img:'/images/documentation-lifecycle-icon.png' },
  };
  const DEFAULT_SECTION = { label:'Docs', img:'/images/documentation-documents-icon.png' };

  // ── Utilities ──────────────────────────────────────────────────────────────
  function esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function highlight(text, indices) {
    if (!indices || !indices.length) return esc(text);
    let out = '', cursor = 0;
    for (const [s, e] of [...indices].sort((a,b)=>a[0]-b[0])) {
      out += esc(text.slice(cursor, s));
      out += '<mark class="bg-yellow-100 text-yellow-800 rounded-sm not-italic font-semibold">' + esc(text.slice(s,e+1)) + '</mark>';
      cursor = e + 1;
    }
    return out + esc(text.slice(cursor));
  }

  function excerpt(text, indices) {
    const MAX = 110, LEAD = 35;
    if (!indices || !indices.length) return esc(text.slice(0,MAX)) + (text.length>MAX?'&hellip;':'');
    const start  = Math.max(0, indices[0][0] - LEAD);
    const slice  = text.slice(start, start + MAX);
    const shifted = indices.map(([s,e])=>[s-start,e-start]).filter(([s])=>s>=0&&s<slice.length);
    return (start>0?'&hellip;':'') + highlight(slice, shifted) + (start+MAX<text.length?'&hellip;':'');
  }

  // ── Panel switcher ─────────────────────────────────────────────────────────
  function showPanel(which) {
    // loading
    elLoading.classList.toggle('hidden', which !== 'loading');
    elLoading.classList.toggle('flex',   which === 'loading');
    // empty / error share the same element
    elEmpty.classList.toggle('hidden', which !== 'empty' && which !== 'error');
    if (which === 'error') {
      elEmpty.innerHTML =
        '<div class="py-6 px-4 text-center">' +
        '<svg class="w-7 h-7 text-red-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>' +
        '<p class="text-[13px] font-medium text-slate-500 mb-1">Search index could not be loaded</p>' +
        '<p class="text-[11px] text-slate-400 font-mono">Check that <strong>public/search-index.json</strong> exists</p>' +
        '</div>';
    }
    // results
    elResults.classList.toggle('hidden', which !== 'results');
    elFooter.classList.toggle('hidden',  which !== 'results');
  }

  function openDropdown()  { dropdown.classList.remove('hidden'); }
  function closeDropdown() { dropdown.classList.add('hidden'); activeIdx = -1; }

  // ── Render ─────────────────────────────────────────────────────────────────
  function renderResults(fuseResults, query) {
    resultItems = fuseResults.slice(0, 8);
    activeIdx   = -1;

    if (!resultItems.length) {
      showPanel('empty');
      elEmpty.innerHTML =
        '<div class="py-8 px-4 text-center">' +
        '<svg class="w-8 h-8 text-slate-200 mx-auto mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/></svg>' +
        '<p class="text-[13px] font-medium text-slate-500 mb-0.5">No results for &ldquo;' + esc(query) + '&rdquo;</p>' +
        '<p class="text-[12px] text-slate-400">Try a different keyword or browse the sidebar.</p>' +
        '</div>';
      return;
    }

    showPanel('results');
    elResults.innerHTML = resultItems.map((r, i) => {
      const item        = r.item;
      const sectionKey  = item.navKey.split('/')[0];
      const section     = SECTIONS[sectionKey] || DEFAULT_SECTION;
      const titleMatch  = (r.matches||[]).find(m=>m.key==='title');
      const contentMatch= (r.matches||[]).find(m=>m.key==='content');
      const titleHtml   = titleMatch   ? highlight(item.title,   titleMatch.indices)  : esc(item.title);
      const contentHtml = contentMatch ? excerpt(item.content, contentMatch.indices)
                        : (item.content.length>110 ? esc(item.content.slice(0,110))+'&hellip;' : esc(item.content));
      return (
        '<div class="search-result-item group flex items-start gap-3 px-4 py-3 cursor-pointer hover:bg-slate-50 transition-colors duration-100" data-navkey="' + esc(item.navKey) + '" data-idx="' + i + '">' +
        '<div class="w-[34px] h-[34px] rounded-lg bg-[linear-gradient(239deg,rgba(255,144,144,0.08)_0%,rgba(134,125,201,0.08)_42%,rgba(45,116,222,0.08)_100%)] border border-white/60 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">' +
        '<img src="' + esc(section.img) + '" alt="" class="w-[22px] h-[22px] object-contain"' +
        ' onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'block\'">' +
        '<svg style="display:none" class="w-4 h-4 text-[#4080E0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>' +
        '</div>' +
        '<div class="flex-1 min-w-0 py-0.5">' +
        '<div class="flex items-center gap-2 mb-0.5 flex-wrap">' +
        '<span class="text-[13px] font-semibold text-slate-800 group-hover:text-[#2D74DE] transition-colors duration-100 leading-snug">' + titleHtml + '</span>' +
        '<span class="text-[10px] font-medium text-slate-400 bg-slate-100 rounded px-1.5 py-[2px] leading-none shrink-0 whitespace-nowrap">' + esc(section.label) + '</span>' +
        '</div>' +
        '<p class="text-[12px] text-slate-500 leading-relaxed m-0 line-clamp-2">' + contentHtml + '</p>' +
        '</div>' +
        '<svg class="w-3.5 h-3.5 text-slate-300 shrink-0 mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>' +
        '</div>'
      );
    }).join('');

    elResults.querySelectorAll('.search-result-item').forEach(el => {
      el.addEventListener('click', () => docsSearchNavigate(el.dataset.navkey));
    });
  }

  // ── Keyboard row highlight ─────────────────────────────────────────────────
  function setActive(idx) {
    const rows = elResults.querySelectorAll('.search-result-item');
    if (!rows.length) return;
    rows.forEach(el => el.classList.remove('bg-slate-50'));
    activeIdx = Math.max(-1, Math.min(idx, rows.length-1));
    if (activeIdx >= 0) { rows[activeIdx].classList.add('bg-slate-50'); rows[activeIdx].scrollIntoView({block:'nearest'}); }
  }

  // ── Navigate on result select ──────────────────────────────────────────────
  function docsSearchNavigate(navKey) {
    if (typeof navTo === 'function') navTo(navKey);
    input.value = '';
    closeDropdown();
    input.blur();
  }

  // ── Run a query ────────────────────────────────────────────────────────────
  function runSearch(query) {
    if (!query) { closeDropdown(); return; }
    openDropdown();
    if (fuseError) { showPanel('error'); return; }
    if (!fuseReady) { showPanel('loading'); return; }
    renderResults(fuse.search(query), query);
  }

  // ── Bootstrap ─────────────────────────────────────────────────────────────
  function fetchIndex() {
    fetch('/search-index.json', { cache: 'default' })
      .then(function(r) {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
      })
      .then(function(data) {
        fuse = new Fuse(data, {
          keys: [
            { name:'title',   weight:0.60 },
            { name:'content', weight:0.30 },
            { name:'section', weight:0.10 },
          ],
          threshold: 0.35,
          includeScore: true,
          includeMatches: true,
          ignoreLocation: true,
          minMatchCharLength: 2,
        });
        fuseReady = true;
        // Re-run any pending query that arrived while we were loading
        var q = input.value.trim();
        if (q && !dropdown.classList.contains('hidden')) runSearch(q);
      })
      .catch(function(err) {
        console.error('[DocsSearch] Index load failed:', err);
        fuseError = true;
        var q = input.value.trim();
        if (q && !dropdown.classList.contains('hidden')) showPanel('error');
      });
  }

  function boot() {
    if (window.Fuse) { fetchIndex(); return; }
    var s   = document.createElement('script');
    s.src   = 'https://cdn.jsdelivr.net/npm/fuse.js@7.0.0/dist/fuse.min.js';
    s.onload  = fetchIndex;
    s.onerror = function() {
      console.error('[DocsSearch] Fuse.js CDN load failed.');
      fuseError = true;
      var q = input.value.trim();
      if (q && !dropdown.classList.contains('hidden')) showPanel('error');
    };
    document.head.appendChild(s);
  }

  boot();

  // ── Listeners ─────────────────────────────────────────────────────────────
  input.addEventListener('input', function() { runSearch(input.value.trim()); });

  input.addEventListener('focus', function() {
    var q = input.value.trim();
    if (q) runSearch(q);
  });

  input.addEventListener('keydown', function(e) {
    var isOpen = !dropdown.classList.contains('hidden');
    if (e.key === 'Escape')    { closeDropdown(); input.blur(); }
    else if (e.key === 'ArrowDown') { e.preventDefault(); if (!isOpen) runSearch(input.value.trim()); else setActive(activeIdx+1); }
    else if (e.key === 'ArrowUp')   { if (!isOpen) return; e.preventDefault(); setActive(activeIdx-1); }
    else if (e.key === 'Enter')     { if (!isOpen||activeIdx<0||!resultItems[activeIdx]) return; e.preventDefault(); docsSearchNavigate(resultItems[activeIdx].item.navKey); }
  });

  document.addEventListener('keydown', function(e) {
    if ((e.metaKey||e.ctrlKey) && e.key==='k') { e.preventDefault(); input.focus(); input.select(); }
  });

  document.addEventListener('mousedown', function(e) {
    if (!wrapper.contains(e.target)) closeDropdown();
  });

})();