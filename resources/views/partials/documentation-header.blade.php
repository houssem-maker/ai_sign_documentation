<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white border-b border-slate-200 flex items-center gap-3 px-5"
        style="box-shadow:0 1px 3px rgba(0,0,0,0.06)">

  <!-- Logo (fixed width = same as sidebar) -->
  <img src="/images/Logomark-POS-GRADIENT.svg" class="w-17 h-8" alt="">

  <!-- Center: token counter -->
  <div class="flex-1 flex items-center justify-center gap-1">
    <span class="text-sm text-orange-500">300</span>
    <span class="text-[13px] text-[#4080E0]">AI tokens Remaining</span>
  </div>

  <!-- Right: plan badge + user -->
  <div class="flex items-center gap-2.5 shrink-0">

    <!-- Plan badge -->
    <div class="hidden sm:flex items-center gap-1.5 border-[1.5px] border-[#2D74DE] rounded-lg py-1 pl-3 pr-1.5 text-xs whitespace-nowrap">
      <span class="text-[#2D74DE] font-medium">Current Plan:</span>
      <span class="text-[#2D74DE] font-bold">BUSINESS</span>
      <button class="bg-[linear-gradient(239deg,_#FF9090_0%,_#867DC9_42%,_#2D74DE_100%)] bg-no-repeat border border-white rounded-md text-white text-[11px] font-bold py-1 px-2.5 tracking-wide transition-colors cursor-pointer">
        UPGRADE
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