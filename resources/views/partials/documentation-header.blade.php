<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white border-b border-slate-200 flex items-center gap-3 px-5"
        style="box-shadow:0 1px 3px rgba(0,0,0,0.06)">

  <!-- Logo (fixed width = same as sidebar) -->
  <img src="/images/Logomark-POS-GRADIENT.svg" class="w-17 h-8 shrink-0" alt="">

  <!-- Center: Search Bar -->
  <div class="flex-1 flex items-center justify-center px-2">
    <div id="docs-search-wrapper" class="relative w-full max-w-lg">

      <!-- ── Input ────────────────────────────────────────────────── -->
      <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-[7px]
                  focus-within:border-[#4080E0] focus-within:ring-2 focus-within:ring-[#4080E0]/10
                  transition-all duration-150 cursor-text"
           onclick="document.getElementById('docs-search-input').focus()">

        <!-- Search icon -->
        <img src="/images/documentation-search-icon.png" class="w-[18px] h-[18px] text-slate-400 shrink-0" >

        <input
          id="docs-search-input"
          type="text"
          placeholder="Search documentation..."
          autocomplete="off"
          spellcheck="false"
          class="flex-1 bg-transparent text-[13px] text-slate-700 placeholder-slate-400
                 outline-none border-0 min-w-0 leading-none"
        >
      </div>

      <!-- ── Dropdown ─────────────────────────────────────────────── -->
      <div id="docs-search-dropdown"
           class="absolute left-0 right-0 top-[calc(100%+8px)] z-[200] hidden
                  bg-white border border-slate-200 rounded-xl overflow-hidden"
           style="box-shadow:0 8px 30px rgba(0,0,0,0.10),0 2px 8px rgba(0,0,0,0.06)">

        <!-- Loading state -->
        <div id="docs-search-loading"
             class="hidden items-center gap-2 px-4 py-3.5 text-[13px] text-slate-400">
          <svg class="w-3.5 h-3.5 animate-spin text-[#4080E0] shrink-0"
               fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
          </svg>
          Loading index…
        </div>

        <!-- Empty state -->
        <div id="docs-search-empty" class="hidden px-4 py-8 text-center">
          <svg class="w-8 h-8 text-slate-200 mx-auto mb-2.5" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
          </svg>
          <p class="text-[13px] font-medium text-slate-500 mb-0.5">
            No results for
            <span id="docs-search-empty-term" class="text-slate-700"></span>
          </p>
          <p class="text-[12px] text-slate-400">Try a different keyword or browse the sidebar.</p>
        </div>

        <!-- Results list -->
        <div id="docs-search-results"
             class="hidden max-h-[360px] overflow-y-auto"></div>

        <!-- Footer hint -->
        <div id="docs-search-footer"
             class="hidden border-t border-slate-100 bg-slate-50/70 px-4 py-2
                    flex items-center gap-4">
          <span class="flex items-center gap-1 text-[11px] text-slate-400">
            <kbd class="px-1.5 py-0.5 rounded border border-slate-200 bg-white font-mono text-[10px] leading-none">↵</kbd>
            select
          </span>
          <span class="flex items-center gap-1 text-[11px] text-slate-400">
            <kbd class="px-1.5 py-0.5 rounded border border-slate-200 bg-white font-mono text-[10px] leading-none">↑↓</kbd>
            navigate
          </span>
          <span class="flex items-center gap-1 text-[11px] text-slate-400">
            <kbd class="px-1.5 py-0.5 rounded border border-slate-200 bg-white font-mono text-[10px] leading-none">Esc</kbd>
            close
          </span>
          <span class="ml-auto text-[11px] text-slate-300 font-mono">
            powered by Fuse.js
          </span>
        </div>
      </div><!-- /dropdown -->

    </div><!-- /wrapper -->
  </div><!-- /center -->

  <!-- Right: plan badge + user -->
  <div class="flex items-center gap-2.5 shrink-0">

    

    <!-- Plan Singin  -->
    <div class="hidden sm:flex items-center gap-1.5 border-[1.5px] border-[#2D74DE] rounded-lg p-1 w-56 text-xs whitespace-nowrap
                transition-shadow duration-200 hover:shadow-[0_0_0_3px_rgba(45,116,222,0.12)]">
      <button class="w-full border border-transparent rounded-md font-bold p-1 tracking-wide cursor-pointer
                     text-slate-700 bg-transparent
                     hover:bg-[#2D74DE]/[0.06] hover:text-[#2D74DE]
                     active:scale-[0.97]
                     text-[14px]
                     transition-all duration-200">
        Sign In Now
      </button>
    </div>
    <!-- Plan Create Account -->
    <div class="hidden sm:flex items-center gap-1.5 border-[1.5px] border-[#2D74DE] rounded-lg p-1 w-56 text-xs whitespace-nowrap
                transition-shadow duration-200 hover:shadow-[0_0_0_3px_rgba(45,116,222,0.15)]">
      <button class="w-full rounded-md font-bold p-1 tracking-wide cursor-pointer
                     text-white border border-white/20
                     bg-[linear-gradient(239deg,_#FF9090_0%,_#867DC9_42%,_#2D74DE_100%)]
                     hover:brightness-110 hover:shadow-[0_3px_12px_rgba(64,128,224,0.40)]
                     active:scale-[0.97]
                     text-[14px]
                     transition-all duration-200">
        Create an Account Now
      </button>
    </div>

    <!-- User name -->
    <div class="hidden sm:block text-right leading-tight">
      <div class="text-xs font-semibold text-slate-800">Name</div>
      <div class="text-[11px] text-slate-800">Surname</div>
    </div>

    <!-- Avatar -->
    <div class="w-8 h-8 rounded-full bg-slate-200 border-[1.5px] border-slate-300 flex items-center justify-center cursor-pointer shrink-0">
      <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
      </svg>
    </div>

    <!-- Mail -->
    <button class="w-8 h-8 flex items-center justify-center rounded-md text-[#2D74DE] hover:text-[#134ba0] hover:bg-slate-100 transition-colors border-0 bg-transparent cursor-pointer shrink-0">
      <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
      </svg>
    </button>
  </div>
</header>