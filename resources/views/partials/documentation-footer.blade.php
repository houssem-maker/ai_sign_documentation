{{-- documentation-footer.blade.php --}}
<footer class="w-full bg-[#1A1A1A] border-t border-white/10">
    <div class="max-w-[100rem] mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-10 xl:gap-14">

            {{-- Brand Column --}}
            <div class="flex flex-col gap-4 lg:w-40 shrink-0">
                {{-- Logo --}}
                <img class="w-32 h-16 pb-4 border-b-[#4E4E4E] border-b-2" src="/images/Logomark-NEG-WHITE.png" alt="">

                {{-- Certification Label --}}
                <div class="mt-2">
                    <p class="text-[#9ca3af] text-xs mb-3 leading-relaxed">eSignature certificated by:</p>
                    <img src="/images/hipaa-compliant-1-250x94.png" alt="">
            </div>
        </div>

            {{-- Nav Columns Wrapper --}}
            <div class="flex flex-1 min-w-0 justify-between gap-4  pt-4 border-t-2 border-t-[#404040] lg:border-t-0 lg:pt-0 ">

                {{-- Website Column --}}
                <div class="min-w-[100px]">
                    <h4 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Website</h4>
                    <ul class="flex flex-col gap-3">
                        @foreach ([
                            ['label' => 'Home',     'href' => '/'],
                            ['label' => 'About us', 'href' => '/about'],
                            ['label' => 'Contacts', 'href' => '/contacts'],
                            ['label' => 'Support',  'href' => '/support'],
                            ['label' => 'Blog',     'href' => '/blog'],
                        ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}"
                               class="font-normal text-[16px] leading-[24px] text-white opacity-60 hover:opacity-100 transition-opacity duration-150">
                                {{ $link['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- The Product Column --}}
                <div class="min-w-[130px]">
                    <h4 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">The Product</h4>
                    <ul class="flex flex-col gap-3">
                        @foreach ([
                            ['label' => 'Features',             'href' => '/features'],
                            ['label' => 'Plans and pricing',    'href' => '/pricing'],
                            ['label' => 'Tutorial / how to use','href' => '/tutorial'],
                        ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}"
                               class="font-normal text-[16px] leading-[24px] text-white opacity-60 hover:opacity-100 transition-opacity duration-150">
                                {{ $link['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Helpful Links Column --}}
                <div class="min-w-[150px]">
                    <h4 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Helpful Links</h4>
                    <ul class="flex flex-col gap-3">
                        @foreach ([
                            ['label' => 'Privacy Policy',       'href' => '/privacy'],
                            ['label' => 'Refund Policy',        'href' => '/refund'],
                            ['label' => 'Terms of Service',     'href' => '/terms'],
                            ['label' => 'Compliance Overview',  'href' => '/compliance'],
                            ['label' => 'Consumer Disclosure',  'href' => '/disclosure'],
                        ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}"
                               class="font-normal text-[16px] leading-[24px] text-white opacity-60 hover:opacity-100 transition-opacity duration-150">
                                {{ $link['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- CTA Column --}}
                <div class="min-w-[180px]">
                    <h4 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Get Started</h4>

                    {{-- Country Selector --}}
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-[#9ca3af] text-sm">Country</span>
                        <div class="flex items-center gap-1 bg-[#2a2a2e] border border-white/20 rounded px-2 py-[3px] cursor-pointer hover:border-white/40 transition-colors">
                            <span class="text-white text-xs font-medium">US</span>
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Start Free Trial Button --}}
                    <a href="/register"
                       class="flex items-center justify-center gap-2 w-full bg-white shadow-[0px_6px_12px_#2D74DE34] border border-[#F8F9FD] rounded-[11px] px-4 py-[10px] mb-3 hover:bg-[#e7e4e4] transition-colors duration-150 group">
                        <span class="text-[#2D74DE] text-sm font-semibold">Start Free trial</span>
                        <svg class="w-4 h-4 text-[#2D74DE] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    {{-- Login Button --}}
                    <a href="/login"
                       class="flex items-center justify-between w-full border border-white/20 rounded-md px-4 py-[10px] mb-3 hover:bg-white/5 transition-colors duration-150 group">
                        <span class="text-[#FFF] text-sm">Login</span>
                        <svg class="w-4 h-4 text-[#FFF] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    {{-- Create New Account --}}
                    <a href="/register"
                       class="flex items-center gap-1 text-white text-sm hover:text-white/80 transition-colors duration-150 group">
                        <span>Create new account</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </div>

            {{-- Contact Info Card --}}
            <div class="bg-[#ffffff1F] border border-white/10 rounded-xl p-5 w-full lg:w-80 xl:w-90 shrink-0 self-start">
                <h4 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Contact Info</h4>

                <div class="space-y-1.5 mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-[#6b7280] text-xs w-10 shrink-0">Tel</span>
                        <a href="tel:8333663409" class="text-white text-sm hover:text-gray-300 transition-colors">(833) 366-3409</a>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-[#6b7280] text-xs w-10 shrink-0">e-mail</span>
                        <a href="mailto:support@aisign.ai" class="text-white text-sm hover:text-gray-300 transition-colors">support@aisign.ai</a>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-[#6b7280] text-xs uppercase tracking-widest mb-1.5">Address</p>
                    <p class="text-white text-sm leading-relaxed">
                        8211 W Broward Blvd, Ste 410,<br>
                        Plantation, FL 33324, USA
                    </p>
                </div>

                {{-- Send Email Button --}}
                <a href="mailto:support@aisign.ai"
                   class="flex items-center justify-between w-full border border-white/20 rounded-md px-4 py-[10px] hover:bg-white/5 transition-colors duration-150 group">
                    <span class="text-white text-sm">Send us an Email</span>
                    <svg class="w-4 h-4 text-white group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</footer>