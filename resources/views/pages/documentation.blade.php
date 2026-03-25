<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AiSign API Documentation</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js" defer></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter', 'system-ui', 'sans-serif'],
          mono: ['Fira Code', 'monospace'],
        }
      }
    }
  }
</script>
<style>
  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  .nav-active::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: #4080E0;
    border-radius: 0 2px 2px 0;
  }

  .slide-open  { max-height: 600px; opacity: 1;  overflow: hidden; transition: max-height .25s ease, opacity .2s ease; }
  .slide-close { max-height: 0;     opacity: 0;  overflow: hidden; transition: max-height .25s ease, opacity .2s ease; }

  pre[class*="language-"] { margin: 0 !important; border: none !important; border-radius: 0 !important; background: #f8fafc !important; }
  code[class*="language-"] { font-family: 'Fira Code', monospace !important; font-size: 12.5px !important; }

  /* ── Image hover-lift (translate offset + hard black shadow) ── */
  .img-lift-wrap {
    position: relative;
    display: block;
  }
  .img-lift-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: #000;
    border-radius: inherit;
    z-index: 0;
    opacity: 0;
    transform: translate(0, 0);
    transition: opacity 0.18s ease;
    pointer-events: none;
  }
  .img-lift-wrap:hover::after { opacity: 1; }
  .img-lift-inner {
    position: relative;
    z-index: 1;
    transform: translate(0, 0);
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    border-radius: inherit;
    overflow: hidden;
  }
  .img-lift-wrap:hover .img-lift-inner {
    transform: translate(-4px, -4px);
    box-shadow: 6px 6px 0 0 rgba(0,0,0,0.88);
  }

  /* ── Card hover lift (for feature cards) ── */
  .card-lift {
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    position: relative;
  }
  .card-lift:hover {
    transform: translate(-3px, -3px);
    box-shadow: 5px 5px 0 0 rgba(0,0,0,0.75);
  }

  /* ── Responsive doc content ── */
  #doc-content { width: 100%; }
  @media (max-width: 640px) {
    #doc-content { padding-left: 1rem !important; padding-right: 1rem !important; }
    .grid-cols-resp-3 { grid-template-columns: 1fr !important; }
  }
  @media (max-width: 900px) {
    .hero-two-col { flex-direction: column !important; }
    .hero-img-col { width: 100% !important; }
  }
</style>
</head>
<script src="/js/docs-search.js" defer></script>
<body class="font-sans bg-slate-50 text-slate-800 antialiased">

@include('partials.documentation-header')


<div class="mt-16 flex flex-col h-[calc(100vh-64px)]">
  @include('partials.documentation-sidebar')
  <main id="main-content" class="flex-1 flex flex-col overflow-y-auto">
    <div class="md:ml-[288px] flex flex-col flex-1">
      <div class="bg-blue-50 border-b border-blue-100 px-6 sm:px-10 lg:px-14 py-3.5 flex items-center gap-1.5 text-[13px] text-slate-500">
        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
        </svg>
        <span id="breadcrumb-text" class="text-slate-600 font-medium"></span>
      </div>
      <div id="doc-content" class="px-24 py-10 max-w-[860px]"></div>
      @include('partials.documentation-footer')
    </div>
  </main>
</div>



<script>
// ─────────────────────────────────────────────────
// NAV TREE
// ─────────────────────────────────────────────────
const NAV_TREE = [
  { id:1,  title:'Getting Started',    open:true,
    pages:[{ id:1, title:'Overview',         slug:'overview',     section:'introduction' },
           { id:2, title:'Quick Start Guide',slug:'quick-start',  section:'introduction' }]},
  { id:2,  title:'Authentication',     open:false,
    pages:[{ id:3, title:'API Keys',         slug:'api-keys',     section:'authentication' }]},
  { id:3,  title:'Templates',          open:false,
    pages:[{ id:4, title:'List Templates',   slug:'list-templates',  section:'templates' },
           { id:5, title:'View Template',    slug:'view-template',   section:'templates' },
           { id:6, title:'Use Template',     slug:'use-template',    section:'templates' }]},
  { id:4,  title:'Documents',          open:false,
    pages:[{ id:7,  title:'Upload Document',       slug:'upload',          section:'documents' },
           { id:8,  title:'Add Recipients',        slug:'add-recipients',  section:'documents' },
           { id:9,  title:'Add Fields',            slug:'add-fields',      section:'documents' },
           { id:10, title:'Activate Document',     slug:'activate',        section:'documents' },
           { id:11, title:'List Documents',        slug:'list-documents',  section:'documents' },
           { id:12, title:'Check Document Status', slug:'document-status', section:'documents' },
           { id:13, title:'List Draft Documents',  slug:'drafts',          section:'documents' },
           { id:14, title:'Delete Draft Documents',slug:'delete-drafts',   section:'documents' },
           { id:15, title:'Download Completed Doc',slug:'download',        section:'documents' }]},
  { id:5,  title:'Tokens',             open:false,
    pages:[{ id:16, title:'Check Token Balance',   slug:'balance',         section:'tokens' }]},
  { id:6,  title:'Logs',               open:false,
    pages:[{ id:17, title:'API Logs',              slug:'api-logs',        section:'logs' }]},
  { id:7,  title:'Webhooks',           open:false,
    pages:[{ id:18, title:'Webhooks Overview',     slug:'overview',        section:'webhooks' },
           { id:19, title:'Register Webhook',      slug:'register-webhook',section:'webhooks' },
           { id:20, title:'List Webhooks',         slug:'list-webhooks',   section:'webhooks' },
           { id:21, title:'Get Webhook Details',   slug:'get-webhook-details',section:'webhooks'},
           { id:22, title:'Update Webhook',        slug:'update-webhook',  section:'webhooks' },
           { id:23, title:'Delete Webhook',        slug:'delete-webhook',  section:'webhooks' }]},
  { id:8,  title:'Error Handling',     open:false,
    pages:[{ id:24, title:'Error Reference',       slug:'errors',          section:'error-handling' }]},
  { id:9,  title:'Limits & Quotas',    open:false,
    pages:[{ id:25, title:'Limits & Quotas',       slug:'limits',          section:'limits' }]},
  { id:10, title:'Status Lifecycle',   open:false,
    pages:[{ id:26, title:'Document Status Lifecycle', slug:'lifecycle',   section:'status-lifecycle' }]},
];

// ─────────────────────────────────────────────────
// PAGES DATA
// ─────────────────────────────────────────────────
const PAGES = {

  // ═══════════════════════════════════════════
  // INTRODUCTION
  // ═══════════════════════════════════════════
  'introduction/overview': {
    title: 'AiSign API',
    meta: 'Programmatically manage documents, templates, recipients, fields, and signing workflows. Any language, any platform — if it speaks HTTP, it works with AiSign.',
    blocks: [
      { type:'overview_hero', data:{
          badge: 'v1.0.0',
          baseUrl: 'https://dev1.aisign.ai/api/v1',
          actions: [
            { label:'Start Free Trial', href:'https://dev4.aisign.ai/plan/api-access/onboarding/form/free-trial', primary:true },
            { label:'View Plans',       href:'https://dev4.aisign.ai/plan/api-access/onboarding/index',           primary:false },
          ],
          features: [
            'JSON responses on every endpoint',
            'API key authentication in one header',
            '1 token = 1 activated document',
          ]
      }},

      { type:'section_header', data:{ title:'What You Can Build', anchor:'what', level:2 }},
      { type:'text', data:{ content:'The AiSign API covers the complete document signing lifecycle — from upload to signed PDF download.' }},
      { type:'feature_cards', data:{ items:[
        {
          icon: 'key',
          label: 'API Reference',
          desc: 'Secure every request with a private API key. Get technical details about API requests, parameters, code examples, and possible errors.',
          navKey: 'authentication/api-keys',
        },
        {
          icon: 'template',
          label: 'Templates',
          desc: 'Reuse pre-built signing templates. Send a document for signatures with a single API call — fastest path to a signed document.',
          navKey: 'templates/list-templates',
        },
        {
          icon: 'doc',
          label: 'Documents',
          desc: 'Upload PDFs, assign recipients, place fields, activate for signing, and download the completed file — full control over every step.',
          navKey: 'documents/upload',
        },
        {
          icon: 'webhook',
          label: 'Webhooks',
          desc: 'Subscribe to real-time events like <code class="font-mono text-xs">document.completed</code> or <code class="font-mono text-xs">field.signed</code> and react instantly in your app.',
          navKey: 'webhooks/overview',
        },
        {
          icon: 'token',
          label: 'Tokens',
          desc: 'Monitor your token balance at any time. Each document activation consumes exactly 1 token — no hidden charges.',
          navKey: 'tokens/balance',
        },
        {
          icon: 'log',
          label: 'Logs',
          desc: 'Retrieve a full 30-day history of every API call made with your key for debugging and auditing.',
          navKey: 'logs/api-logs',
        },
      ]}},

      { type:'section_header', data:{ title:'Explore the AiSign API', anchor:'explore', level:2 }},
      { type:'text', data:{ content:'Jump directly to the topic you need:' }},
      { type:'explore_grid', data:{ items:[
        {
          icon: 'auth',
          label: 'API Keys',
          desc: 'Learn the three authentication methods and understand permission scopes.',
          navKey: 'authentication/api-keys',
        },
        {
          icon: 'quickstart',
          label: 'Quick Start Guide',
          desc: 'Get a document signed in minutes — two complete workflows with cURL examples.',
          navKey: 'introduction/quick-start',
        },
        {
          icon: 'template',
          label: 'Use a Template',
          desc: 'Instantiate a template with real recipients. One call creates the document and generates signing URLs.',
          navKey: 'templates/use-template',
        },
        {
          icon: 'upload',
          label: 'Upload a Document',
          desc: 'Upload PDF, DOC, or DOCX files up to 10 MB. Add recipients and fields before activation.',
          navKey: 'documents/upload',
        },
        {
          icon: 'webhook',
          label: 'Register a Webhook',
          desc: 'Subscribe to document and field events with a URL endpoint in your application.',
          navKey: 'webhooks/register-webhook',
        },
        {
          icon: 'error',
          label: 'Error Reference',
          desc: 'Full list of HTTP status codes, error shapes, and how to handle them gracefully.',
          navKey: 'error-handling/errors',
        },
        {
          icon: 'status',
          label: 'Document Lifecycle',
          desc: 'Understand UPLOADED → PREPARED → PENDING → COMPLETED state transitions.',
          navKey: 'status-lifecycle/lifecycle',
        },
        {
          icon: 'limits',
          label: 'Limits & Quotas',
          desc: 'File size, rate limits, field counts, and other platform constraints.',
          navKey: 'limits/limits',
        },
        {
          icon: 'download',
          label: 'Download Completed Doc',
          desc: 'Retrieve the fully signed PDF once all recipients have completed their actions.',
          navKey: 'documents/download',
        },
      ]}},

      { type:'section_header', data:{ title:'Response Format', anchor:'response-format', level:2 }},
      { type:'text', data:{ content:'Every endpoint returns a consistent JSON envelope with a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">success</code> flag, a human-readable <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">message</code>, a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">data</code> payload, and an <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">errors</code> object on failure.' }},
      { type:'code', data:{ language:'json', label:'Standard Response Envelope', content:`{
  "success": true,
  "message": "Descriptive message",
  "data": { ... },
  "errors": { ... }
}`}},
      { type:'section_header', data:{ title:'HTTP Status Codes', anchor:'status-codes', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'200', label:'OK',                    desc:'Request succeeded.' },
        { code:'201', label:'Created',               desc:'Resource was successfully created.' },
        { code:'401', label:'Unauthorized',          desc:'Invalid or missing API key.' },
        { code:'402', label:'Payment Required',      desc:'No API tokens available.' },
        { code:'404', label:'Not Found',             desc:'The requested resource does not exist.' },
        { code:'409', label:'Conflict',              desc:'Resource already exists (e.g. duplicate webhook).' },
        { code:'422', label:'Unprocessable Entity',  desc:'Validation failed or business rule violated.' },
        { code:'500', label:'Internal Server Error', desc:'Unexpected server-side error.' },
      ]}},
    ]
  },

  'introduction/quick-start': {
    title: 'Quick Start Guide',
    meta: 'Get a document signed in minutes using the AiSign API.',
    blocks: [
      /* ── Intro ── */
      { type:'qs_hero', data:{
          title: 'Get started with the AiSign API',
          desc: 'This quickstart guide walks you through obtaining your API key and sending your first signing request — two complete workflows with cURL examples.',
      }},

      /* ── Setup Step 1 ── */
      { type:'qs_setup_step', data:{
          title: 'Choose a plan',
          content: 'Start with a free trial (100 tokens, no credit card required) or pick a paid plan that fits your signing volume. Each document activation consumes exactly 1 token.',
          note: 'Uploading documents, adding recipients, and placing fields do not consume tokens — only the final activation step does.',
          image: '/images/api-plan-section.png',
      }},

      /* ── Setup Step 2 ── */
      { type:'qs_setup_step', data:{
          title: 'Get your API key',
          content: 'Once your account is active, open the API dashboard. Your API key is generated automatically. Copy it from the <strong>API Keys</strong> tab — you\'ll pass it in every request as a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">Bearer</code> token.',
          image: '/images/api-dashboard.jpeg',
      }},

      /* ── Calling the API ── */
      { type:'qs_api_step', data:{
          title: 'Calling the API',
          content: 'There are two main ways to call the AiSign API:',
          bullets: [
            'Copy the cURL examples below to send requests from your terminal or an HTTP client like Postman.',
            'Integrate the code samples into your application using any language that can make HTTP requests.',
          ],
      }},

      { type:'note', data:{ variant:'info', content:'Documents signed in development/trial mode will have a watermark. Upgrade to a paid plan to remove it.' }},

      /* ── Workflow A ── */
      { type:'section_header', data:{ title:'Workflow A — Use a Template (Fastest)', anchor:'workflow-a', level:2 }},
      { type:'text', data:{ content:'If you already have signing templates created in the AiSign dashboard, this is the fastest path to getting a document signed. Just one API call does the heavy lifting.' }},
      { type:'steps', data:{ steps:[
        { n:1, title:'List your templates',      desc:'Call <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">GET /templates</code> to see available templates and how many placeholders each one has.' },
        { n:2, title:'Use the template',         desc:'Call <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">POST /templates/{id}/use</code> with a matching number of recipients. This creates the document, generates signing URLs, and consumes 1 token.' },
        { n:3, title:'Share signing URLs',       desc:'Each recipient in the response receives a unique <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">signing_url</code>. Embed it in an iframe or email it directly.' },
        { n:4, title:'Track completion',         desc:'Poll <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">GET /documents/{id}/status</code> or register a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">document.completed</code> webhook.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'Minimal Template Example', content:`# Step 1: Find a template
curl -X GET https://dev1.aisign.ai/api/v1/templates \\
  -H "Authorization: Bearer sk_your_key"

# Step 2: Use it (2 placeholders → 2 recipients)
curl -X POST https://dev1.aisign.ai/api/v1/templates/2794/use \\
  -H "Authorization: Bearer sk_your_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "title": "Service Agreement",
    "recipients": [
      { "name": "Alice Martin",  "email": "alice@example.com", "action": "sign" },
      { "name": "Bob Johnson",   "email": "bob@example.com",   "action": "approve" }
    ],
    "include_iframe": true
  }'`}},

      /* ── Workflow B ── */
      { type:'section_header', data:{ title:'Workflow B — Upload Your Own Document', anchor:'workflow-b', level:2 }},
      { type:'text', data:{ content:'Use this workflow when you need full control over the document, recipients, and field placement.' }},

      /* Step 1 - Upload */
      { type:'qs_api_step', data:{
          title: 'Step 1. Upload a document',
          content: 'Upload a PDF, DOC, or DOCX file up to 10 MB using the Upload Document request.',
          bullets: [
            'Paste your <strong>API key</strong> into the <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">Authorization</code> header after <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">Bearer</code>.',
            'The response returns a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">document_id</code> — copy it for the next step.',
          ],
          codeLabel: 'POST /documents/upload — cURL',
          code: `curl -X POST https://dev1.aisign.ai/api/v1/documents/upload \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -F "file=@/path/to/document.pdf"`,
      }},

      /* Step 2 - Add fields */
      { type:'qs_api_step', data:{
          title: 'Step 2. Add recipients & fields',
          content: 'Assign signers, then place signature and text fields on the document pages.',
          bullets: [
            'Use <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">POST /documents/{id}/recipients</code> to add signers, approvers, or viewers.',
            'Use <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">POST /documents/{id}/fields</code> to place signature, date, and text fields.',
            'Paste the <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">document_id</code> from Step 1 into the URL.',
          ],
          codeLabel: 'POST /documents/{id}/fields — cURL',
          code: `curl -X POST https://dev1.aisign.ai/api/v1/documents/1234/fields \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "fields": [
      {
        "type": "SIGNATURE",
        "recipient_index": 1,
        "page_number": 1,
        "x": 10, "y": 70,
        "width": 25, "height": 8
      }
    ]
  }'`,
      }},

      /* Step 3 - Activate */
      { type:'qs_api_step', data:{
          title: 'Step 3. Activate the document',
          content: 'Activate the document to lock it, generate signing URLs for each recipient, and consume 1 API token.',
          bullets: [
            'Paste your <strong>API key</strong> and the <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">document_id</code> from Step 1.',
            'The response includes a unique <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">signing_url</code> per recipient.',
          ],
          codeLabel: 'POST /documents/{id}/use — cURL',
          code: `curl -X POST https://dev1.aisign.ai/api/v1/documents/1234/use \\
  -H "Authorization: Bearer sk_your_api_key"`,
      }},

      { type:'token_note', data:{ content:'Only the final activation step (POST /documents/{id}/use or POST /templates/{id}/use) consumes a token. Uploading, adding recipients, and adding fields are all free.' }},

      /* ── Explore advanced workflows ── */
      { type:'qs_explore', data:{ links:[
        { label:'Embedded signing',  navKey:'documents/activate',      desc:'Build a seamless signing experience directly within your website using the signing URL in an iframe.' },
        { label:'Webhooks',          navKey:'webhooks/register-webhook', desc:'Receive real-time event notifications for document completion, field signing, and more.' },
        { label:'Error handling',    navKey:'error-handling/errors',    desc:'Full list of HTTP status codes, error shapes, and how to handle them gracefully.' },
        { label:'Document lifecycle',navKey:'status-lifecycle/lifecycle',desc:'Understand UPLOADED → PREPARED → PENDING → COMPLETED state transitions.' },
      ]}},

      /* ── Go live ── */
      { type:'qs_go_live', data:{
          content: 'You can test eSignature workflows on the free trial plan as long as you need. When you are ready to launch in production, upgrade to a paid plan to remove watermarks and increase your token quota.',
      }},
    ]
  },

  // ═══════════════════════════════════════════
  // AUTHENTICATION
  // ═══════════════════════════════════════════
  'authentication/api-keys': {
    title: 'API Keys',
    meta: 'All AiSign API requests require authentication via a private API key. Keys are prefixed with sk_ and carry scoped permissions.',
    blocks: [
      { type:'section_header', data:{ title:'Key Format', anchor:'format', level:2 }},
      { type:'text', data:{ content:'Private API keys always begin with the prefix <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">sk_</code>. Keep your key secret — treat it like a password.' }},
      { type:'section_header', data:{ title:'Authentication Methods', anchor:'methods', level:2 }},
      { type:'text', data:{ content:'You can authenticate using any of the three methods below. The Authorization header is recommended.' }},
      { type:'code', data:{ language:'bash', label:'Method 1 — Authorization Header (Recommended)', content:`curl -X GET https://dev1.aisign.ai/api/v1/templates \\
  -H "Authorization: Bearer sk_your_private_api_key"`}},
      { type:'code', data:{ language:'bash', label:'Method 2 — X-API-Key Header', content:`curl -X GET https://dev1.aisign.ai/api/v1/templates \\
  -H "X-API-Key: sk_your_private_api_key"`}},
      { type:'code', data:{ language:'bash', label:'Method 3 — Query Parameter', content:`curl -X GET "https://dev1.aisign.ai/api/v1/templates?token=sk_your_private_api_key"`}},
      { type:'section_header', data:{ title:'Permissions', anchor:'permissions', level:2 }},
      { type:'text', data:{ content:'Each API key carries scoped permissions. Endpoints declare which permission they require:' }},
      { type:'param_table', data:{ location:'Permission', params:[
        { name:'templates:read',  type:'scope', required:false, description:'Read templates and their placeholder details.' },
        { name:'templates:write', type:'scope', required:false, description:'Use templates to create new documents.' },
        { name:'documents:read',  type:'scope', required:false, description:'List documents, check status, view drafts, retrieve logs.' },
        { name:'documents:write', type:'scope', required:false, description:'Upload documents, add recipients/fields, activate, delete drafts.' },
      ]}},
      { type:'section_header', data:{ title:'Authentication Errors', anchor:'auth-errors', level:2 }},
      { type:'response', data:{ status:401, label:'Invalid API Key', content:`{
  "success": false,
  "message": "Invalid API Key"
}`}},
      { type:'note', data:{ variant:'danger', content:'Never expose your API key in client-side code, public repositories, or log files. Rotate it immediately if compromised.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // TEMPLATES
  // ═══════════════════════════════════════════
  'templates/list-templates': {
    title: 'List Templates',
    meta: 'Retrieve all signing templates available to the authenticated user.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/templates', permission:'templates:read', consumesToken:false, description:'Returns an array of all templates belonging to the authenticated API key, including placeholder counts.' }},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/templates \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": [
    {
      "id": 2794,
      "template_name": "Service Agreement",
      "template_description": "Standard template for service contracts",
      "template_subject": "Signature Required",
      "original_filename": "service_agreement.pdf",
      "created_at": "2024-09-26T20:58:42.000000Z",
      "updated_at": "2024-09-26T20:58:42.000000Z",
      "placeholders_count": 2
    }
  ],
  "count": 1
}`}},
      { type:'section_header', data:{ title:'Response Fields', anchor:'fields', level:2 }},
      { type:'param_table', data:{ location:'Response', params:[
        { name:'id',                   type:'integer', required:false, description:'Unique template ID used in subsequent requests.' },
        { name:'template_name',        type:'string',  required:false, description:'Human-readable name of the template.' },
        { name:'template_description', type:'string',  required:false, description:'Brief description of the template.' },
        { name:'template_subject',     type:'string',  required:false, description:'Email subject sent to recipients.' },
        { name:'original_filename',    type:'string',  required:false, description:'Name of the PDF file the template is based on.' },
        { name:'placeholders_count',   type:'integer', required:false, description:'Number of placeholder recipients the template has. You must provide exactly this many recipients when using the template.' },
      ]}},
    ]
  },

  'templates/view-template': {
    title: 'View Template Details',
    meta: 'Retrieve detailed information for a specific template, including all its placeholders.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/templates/{id}', permission:'templates:read', consumesToken:false, description:'Returns full template metadata plus a list of each placeholder and the action assigned to it.' }},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/templates/2794 \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'id', type:'integer', required:true, description:'The template ID obtained from GET /templates.' },
      ]}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": {
    "template": {
      "id": 2794,
      "name": "Service Agreement",
      "description": "Standard template for service contracts",
      "subject": "Signature Required",
      "message": "Please review and sign the attached document",
      "filename": "service_agreement.pdf",
      "created_at": "2024-09-26T20:58:42.000000Z",
      "updated_at": "2024-09-26T20:58:42.000000Z"
    },
    "placeholders": [
      {
        "placeholder_number": "1",
        "placeholder_email": "placeholder1@aisign.ai",
        "placeholder_name": "placeholder1",
        "request_id": 3485,
        "action": "sign"
      },
      {
        "placeholder_number": "2",
        "placeholder_email": "placeholder2@aisign.ai",
        "placeholder_name": "placeholder2",
        "request_id": 3486,
        "action": "sign"
      }
    ],
    "placeholders_count": 2
  }
}`}},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:404, label:'Template Not Found', content:`{
  "success": false,
  "message": "Template not found"
}`}},
    ]
  },

  'templates/use-template': {
    title: 'Use Template',
    meta: 'Create a new document from an existing template by supplying real recipient details. The number of recipients must exactly match the template placeholder count.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/templates/{id}/use', permission:'templates:write', consumesToken:true, description:'Instantiates a template into a live document, assigns real recipients in place of placeholders, generates unique signing URLs, and consumes 1 API token.' }},
      { type:'token_note', data:{ content:'This endpoint consumes 1 API token. Ensure you have available tokens before calling it. Check your balance at GET /tokens/balance.' }},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'param_table', data:{ location:'Body', params:[
        { name:'title',            type:'string',  required:false, description:'Document title shown to recipients. Max 512 characters.' },
        { name:'message',          type:'string',  required:false, description:'Custom message included in the signing invitation email.' },
        { name:'recipients',       type:'array',   required:true,  description:'Array of recipient objects. Count must exactly match placeholders_count.' },
        { name:'recipients[].name',type:'string',  required:true,  description:'Full name of the recipient.' },
        { name:'recipients[].email',type:'email',  required:true,  description:'Email address of the recipient. Max 255 characters.' },
        { name:'recipients[].action',type:'enum',  required:false, description:'Action assigned to this recipient.', default:'sign', enum:['sign','approve','view'] },
        { name:'include_iframe',   type:'boolean', required:false, description:'When true, each recipient in the response will include an iframe_code field ready for embedding.' },
        { name:'iframe_width',     type:'string',  required:false, description:'Width of the generated iframe HTML element.', default:'100%' },
        { name:'iframe_height',    type:'string',  required:false, description:'Height of the generated iframe HTML element.', default:'600px' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X POST https://dev1.aisign.ai/api/v1/templates/2794/use \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "title": "Service Agreement — Client ABC",
    "message": "Please review and sign at your earliest convenience.",
    "recipients": [
      { "name": "Alice Martin", "email": "alice@example.com", "action": "sign"    },
      { "name": "Bob Johnson",  "email": "bob@example.com",   "action": "approve" }
    ],
    "include_iframe": true,
    "iframe_width": "800px",
    "iframe_height": "600px"
  }'`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:201, label:'Created', content:`{
  "success": true,
  "message": "Template used successfully",
  "data": {
    "document_id": 2806,
    "document_uuid": "39bfac07-6ef2-43e3-adc3-937245cb6682",
    "security_token": "eyJpdiI6InZXRU1Qdngy...",
    "title": "Service Agreement — Client ABC",
    "status": "UPLOADED",
    "recipients": [
      {
        "name": "Alice Martin",
        "email": "alice@example.com",
        "action": "sign",
        "signing_url": "https://dev1.aisign.ai/signing-ceremony/eyJpdiI6...",
        "signing_token": "eyJpdiI6InVjaVZle...",
        "iframe_code": "<iframe src=\"...\" width=\"800px\" height=\"600px\" style=\"border:none\" allow=\"camera;microphone\"></iframe>"
      },
      {
        "name": "Bob Johnson",
        "email": "bob@example.com",
        "action": "approve",
        "signing_url": "https://dev1.aisign.ai/signing-ceremony/eyJpdiI6...",
        "signing_token": "eyJpdiI6ImFiYZR1...",
        "iframe_code": "<iframe src=\"...\" width=\"800px\" height=\"600px\" style=\"border:none\" allow=\"camera;microphone\"></iframe>"
      }
    ],
    "created_at": "2024-10-01T23:42:47.000000Z"
  }
}`}},
      { type:'section_header', data:{ title:'Embedding the Signing Ceremony', anchor:'iframe', level:2 }},
      { type:'text', data:{ content:'When <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">include_iframe: true</code> is sent, each recipient includes a ready-to-use <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">iframe_code</code> string. You can also build the iframe manually from the <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">signing_url</code>:' }},
      { type:'code', data:{ language:'javascript', label:'JavaScript — Embed signing iframe', content:`fetch('https://dev1.aisign.ai/api/v1/templates/2794/use', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_your_api_key',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({ recipients: [ /* ... */ ], include_iframe: true })
})
.then(r => r.json())
.then(data => {
  // Option 1: set src directly
  document.getElementById('signing-iframe').src =
    data.data.recipients[0].signing_url;

  // Option 2: inject the ready-made iframe HTML
  document.getElementById('container').innerHTML =
    data.data.recipients[0].iframe_code;
});`}},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:422, label:'Recipient Count Mismatch', content:`{
  "success": false,
  "message": "Template requires exactly 2 recipients, but 3 provided"
}`}},
      { type:'response', data:{ status:422, label:'Validation Failed', content:`{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "recipients": ["The recipients field is required."],
    "recipients.0.email": ["The email must be a valid email address."]
  }
}`}},
      { type:'note', data:{ variant:'danger', content:'The number of recipients must <strong>exactly</strong> match the template\'s <code class="font-mono">placeholders_count</code>. Too few or too many will result in a 422 error.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // DOCUMENTS
  // ═══════════════════════════════════════════
  'documents/upload': {
    title: 'Upload Document',
    meta: 'Upload a PDF, DOC, or DOCX file to begin the document signing workflow. This step does not consume an API token.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/documents/upload', permission:'documents:write', consumesToken:false, description:'Uploads a document and places it in UPLOADED status. The document is a draft until recipients, fields, and activation are completed.' }},
      { type:'note', data:{ variant:'success', content:'This endpoint does <strong>not</strong> consume an API token. Only the final activation step does.' }},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'text', data:{ content:'The request must be sent as <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">multipart/form-data</code>.' }},
      { type:'param_table', data:{ location:'Body (multipart/form-data)', params:[
        { name:'file',    type:'file',   required:true,  description:'The document to upload. Accepted formats: PDF, DOC, DOCX. Maximum size: 10 MB.' },
        { name:'title',   type:'string', required:true,  description:'Document title shown to recipients and in the dashboard. Max 512 characters.' },
        { name:'message', type:'string', required:false, description:'Optional message included in the signing invitation sent to recipients.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X POST https://dev1.aisign.ai/api/v1/documents/upload \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -F "file=@/path/to/contract.pdf" \\
  -F "title=Employment Contract" \\
  -F "message=Please review and sign this document"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:201, label:'Created', content:`{
  "success": true,
  "data": {
    "document_id": 2850,
    "document_uuid": "a7c8f3e2-9d4b-4e8a-b6c1-3f7e9a2d5c8b",
    "security_token": "eyJpdiI6InZXRU1Qdngy...",
    "title": "Employment Contract",
    "filename": "employment_contract.pdf",
    "status": "UPLOADED",
    "created_at": "2024-10-29T15:30:45.000000Z"
  },
  "draft_info": {
    "current_draft_documents": 3,
    "draft_documents_limit": 10,
    "remaining_draft_slots": 7,
    "can_create_more": true
  }
}`}},
      { type:'section_header', data:{ title:'Draft Document Limits', anchor:'drafts', level:2 }},
      { type:'text', data:{ content:'Each API key has a maximum number of draft documents (documents in UPLOADED or PREPARED status) that can exist simultaneously. When the limit is reached, you must activate or delete existing drafts before uploading new ones.' }},
      { type:'param_table', data:{ location:'draft_info Fields', params:[
        { name:'current_draft_documents', type:'integer', required:false, description:'Number of documents currently in draft status.' },
        { name:'draft_documents_limit',   type:'integer', required:false, description:'Maximum draft documents allowed. Default: 10.' },
        { name:'remaining_draft_slots',   type:'integer', required:false, description:'How many more drafts can be created.' },
        { name:'can_create_more',         type:'boolean', required:false, description:'false when the draft limit is reached.' },
      ]}},
    ]
  },

  'documents/add-recipients': {
    title: 'Add Recipients',
    meta: 'Assign one or more recipients to an uploaded document. Recipients must be added before fields can be assigned to them.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/documents/{document_id}/recipients', permission:'documents:write', consumesToken:false, description:'Adds recipients to a document in UPLOADED or PREPARED status. Recipients can be assigned the role of signer, approver, viewer, or CC.' }},
      { type:'note', data:{ variant:'success', content:'This endpoint does <strong>not</strong> consume an API token.' }},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'document_id', type:'integer', required:true, description:'The document ID returned by POST /documents/upload.' },
      ]}},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'param_table', data:{ location:'Body', params:[
        { name:'recipients',          type:'array',   required:true,  description:'Array of recipient objects. Minimum 1 recipient required.' },
        { name:'recipients[].name',   type:'string',  required:true,  description:'Recipient\'s full name. Max 255 characters.' },
        { name:'recipients[].email',  type:'email',   required:true,  description:'Recipient\'s email address. Max 255 characters. Must be unique within the document.' },
        { name:'recipients[].action', type:'enum',    required:false, description:'Action assigned to the recipient.', default:'sign', enum:['sign','approve','view','CC'] },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X POST https://dev1.aisign.ai/api/v1/documents/2850/recipients \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "recipients": [
      { "name": "John Smith", "email": "john@example.com", "action": "sign"    },
      { "name": "Jane Doe",   "email": "jane@example.com", "action": "approve" }
    ]
  }'`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:201, label:'Created', content:`{
  "success": true,
  "message": "Recipients added successfully",
  "data": {
    "document_id": 2850,
    "recipients_added": 2,
    "recipients": [
      { "name": "John Smith", "email": "john@example.com", "action": "sign"    },
      { "name": "Jane Doe",   "email": "jane@example.com", "action": "approve" }
    ]
  }
}`}},
      { type:'note', data:{ variant:'warning', content:'Recipients must be added to the document <strong>before</strong> you can assign fields to them. If you try to add a field with an email that has not been registered as a recipient, you will receive a 422 error.' }},
    ]
  },

  'documents/add-fields': {
    title: 'Add Fields',
    meta: 'Add signature and form fields to a document using absolute coordinates or OCR-based text positioning.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/documents/{id}/fields', permission:'documents:write', consumesToken:false, description:'Adds form fields to an uploaded document. Supports absolute (x/y) and OCR-based relative positioning. Transitions document from UPLOADED → PREPARED.' }},
      { type:'note', data:{ variant:'success', content:'This endpoint does <strong>not</strong> consume an API token.' }},
      { type:'section_header', data:{ title:'Common Field Properties', anchor:'common', level:2 }},
      { type:'param_table', data:{ location:'Common Fields (All Types)', params:[
        { name:'type',            type:'enum',    required:true,  description:'Field type.', enum:['SIGNATURE','TEXT','DATE','NUMBER','EMAIL','COMPANY','NOTES','CHECKBOX'] },
        { name:'recipient_email', type:'email',   required:true,  description:'Email of the recipient who will fill this field. Must already be added as a recipient.' },
        { name:'page',            type:'integer', required:false, description:'Page number where the field appears (1-indexed). Ignored when using OCR positioning.' },
        { name:'width',           type:'number',  required:false, description:'Field width on a 0–100 scale.', default:'10' },
        { name:'height',          type:'number',  required:false, description:'Field height on a 0–100 scale.', default:'10' },
        { name:'placeholder',     type:'string',  required:false, description:'Placeholder text shown inside the field. Max 255 characters.' },
        { name:'font_family',     type:'string',  required:false, description:'Font family.', default:'Helvetica' },
        { name:'color',           type:'string',  required:false, description:'Text color in hex format.', default:'#000000' },
        { name:'bold',            type:'integer', required:false, description:'Bold text. 0 = off, 1 = on.', default:'0' },
        { name:'underline',       type:'integer', required:false, description:'Underline text. 0 = off, 1 = on.', default:'0' },
        { name:'italic',          type:'integer', required:false, description:'Italic text. 0 = off, 1 = on.', default:'0' },
      ]}},
      { type:'section_header', data:{ title:'Mode 1 — Absolute Positioning', anchor:'abs', level:2 }},
      { type:'text', data:{ content:'Place fields using exact x/y coordinates on a <strong>0–100 scale</strong> where (0, 0) is the top-left corner and (100, 100) is the bottom-right corner of the page.' }},
      { type:'param_table', data:{ location:'Absolute Positioning', params:[
        { name:'x', type:'number', required:false, description:'Horizontal position (0–100). 0 = left edge, 100 = right edge.', default:'80' },
        { name:'y', type:'number', required:false, description:'Vertical position (0–100). 0 = top edge, 100 = bottom edge.', default:'80' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL — Absolute Positioning', content:`curl -X POST https://dev1.aisign.ai/api/v1/documents/3138/fields \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "fields": [{
      "type": "SIGNATURE",
      "page": 1,
      "x": 50, "y": 80,
      "width": 20, "height": 10,
      "recipient_email": "john@example.com"
    }]
  }'`}},
      { type:'section_header', data:{ title:'Mode 2 — OCR Relative Positioning', anchor:'ocr', level:2 }},
      { type:'text', data:{ content:'The OCR engine scans the entire document for a reference word or phrase and places the field relative to where it is found. The <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">page</code> parameter is ignored — the field lands on whichever page the reference text appears.' }},
      { type:'param_table', data:{ location:'OCR Positioning', params:[
        { name:'reference_text',       type:'string',  required:true,  description:'Word or phrase to locate in the document. Case-insensitive. Punctuation is ignored. Max 255 characters.' },
        { name:'reference_occurrence', type:'integer', required:false, description:'Which occurrence to use (1-indexed). Use -1 to place a field at every occurrence.', default:'1' },
        { name:'relative_position',    type:'enum',    required:false, description:'Where to place the field relative to the found text.', default:'below', enum:['above','below','left','right'] },
        { name:'offset_pixels',        type:'integer', required:false, description:'Distance in pixels between the reference text and the field (0–100).', default:'10' },
      ]}},
      { type:'note', data:{ variant:'info', content:'OCR processing adds approximately <strong>2–5 seconds</strong> of latency per document. Batch all fields into a single request for best performance.' }},
      { type:'note', data:{ variant:'warning', content:'A field <strong>cannot</strong> have both absolute coordinates (<code class="font-mono">x</code>, <code class="font-mono">y</code>) AND OCR positioning (<code class="font-mono">reference_text</code>) at the same time. This results in an <code class="font-mono">AMBIGUOUS_POSITIONING</code> error.' }},
      { type:'code', data:{ language:'json', label:'OCR — Single Occurrence', content:`{
  "fields": [{
    "type": "SIGNATURE",
    "reference_text": "Client Signature",
    "reference_occurrence": 1,
    "relative_position": "below",
    "offset_pixels": 15,
    "width": 20, "height": 10,
    "recipient_email": "john@example.com"
  }]
}`}},
      { type:'code', data:{ language:'json', label:'OCR — All Occurrences (reference_occurrence: -1)', content:`{
  "fields": [{
    "type": "DATE",
    "reference_text": "Date",
    "reference_occurrence": -1,
    "relative_position": "right",
    "offset_pixels": 10,
    "width": 15, "height": 5,
    "recipient_email": "john@example.com"
  }]
}`}},
      { type:'section_header', data:{ title:'TEXT Field Extra Properties', anchor:'text-extra', level:2 }},
      { type:'param_table', data:{ location:'TEXT Field Only', params:[
        { name:'text',       type:'string',  required:false, description:'Pre-filled text value placed inside the field.' },
        { name:'font_size',  type:'integer', required:false, description:'Font size in pixels (8–72).', default:'12' },
        { name:'max_length', type:'integer', required:false, description:'Maximum character length allowed (1–500). Minimum enforced: 20.', default:'20' },
      ]}},
      { type:'section_header', data:{ title:'Mixed Example — Absolute + OCR', anchor:'mixed', level:2 }},
      { type:'code', data:{ language:'json', label:'Mixed Positioning', content:`{
  "fields": [
    {
      "type": "SIGNATURE",
      "reference_text": "Authorized Signature",
      "relative_position": "below",
      "offset_pixels": 20,
      "width": 25, "height": 12,
      "recipient_email": "manager@company.com"
    },
    {
      "type": "DATE",
      "page": 1,
      "x": 75, "y": 85,
      "width": 15, "height": 5,
      "recipient_email": "manager@company.com"
    },
    {
      "type": "TEXT",
      "reference_text": "Employee Name",
      "relative_position": "right",
      "offset_pixels": 10,
      "width": 30, "height": 5,
      "text": "John Doe",
      "font_size": 14,
      "max_length": 50,
      "recipient_email": "employee@company.com"
    }
  ]
}`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:201, label:'Created', content:`{
  "success": true,
  "message": "Fields added successfully",
  "data": {
    "document_id": 3138,
    "fields_added": 2,
    "fields": [
      {
        "field_id": 14814,
        "type": "SIGNATURE",
        "page": 1,
        "position": { "x": 39.29, "y": 12.45, "width": 20, "height": 10, "coordinate_source": "relative" },
        "recipient": "john@example.com",
        "text": "",
        "status": "PENDING"
      },
      {
        "field_id": 14815,
        "type": "DATE",
        "page": 2,
        "position": { "x": 70, "y": 30, "width": 15, "height": 5, "coordinate_source": "absolute" },
        "recipient": "john@example.com",
        "text": "",
        "status": "PENDING"
      }
    ]
  }
}`}},
      { type:'note', data:{ variant:'info', content:'The <code class="font-mono">coordinate_source</code> field in the response indicates how each field was positioned: <code class="font-mono">absolute</code>, <code class="font-mono">relative</code> (OCR), or <code class="font-mono">default</code>.' }},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:422, label:'Ambiguous Positioning', content:`{
  "success": false,
  "message": "Field cannot have both absolute coordinates and relative positioning at the same time",
  "error_code": "AMBIGUOUS_POSITIONING",
  "field_index": 0,
  "hint": "Use EITHER absolute coordinates (x, y) OR relative positioning (reference_text), not both"
}`}},
      { type:'response', data:{ status:422, label:'Reference Word Not Found', content:`{
  "success": false,
  "message": "Reference word 'Client Signature' not found in document (occurrence 1)",
  "error_code": "REFERENCE_WORD_NOT_FOUND",
  "field_index": 0,
  "reference_text": "Client Signature",
  "occurrence": 1
}`}},
      { type:'response', data:{ status:422, label:'Recipient Not Found', content:`{
  "success": false,
  "message": "Recipient john@example.com not found. Please add recipients first."
}`}},
      { type:'response', data:{ status:422, label:'Document Not Editable', content:`{
  "success": false,
  "message": "Cannot add fields. Document is in PENDING status and cannot be edited.",
  "error_code": "DOCUMENT_NOT_EDITABLE",
  "current_status": "PENDING",
  "allowed_statuses": ["UPLOADED", "PREPARED"]
}`}},
    ]
  },

  'documents/activate': {
    title: 'Activate Document',
    meta: 'Finalize a document for signing. This generates signing URLs for all recipients, locks the document from further editing, and consumes 1 API token.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/documents/{document_id}/use', permission:'documents:write', consumesToken:true, description:'Activates a PREPARED document. The document transitions to PENDING status and signing URLs are generated for every recipient.' }},
      { type:'token_note', data:{ content:'This endpoint consumes 1 API token. Make sure you have available balance before calling it.' }},
      { type:'section_header', data:{ title:'Prerequisites', anchor:'prereqs', level:2 }},
      { type:'text', data:{ content:'Before a document can be activated, all of the following must be true:' }},
      { type:'steps', data:{ steps:[
        { n:1, title:'At least one recipient',  desc:'The document must have at least one recipient added via POST /documents/{id}/recipients.' },
        { n:2, title:'At least one field',      desc:'The document must have at least one field added via POST /documents/{id}/fields.' },
        { n:3, title:'All recipients have fields', desc:'Every recipient must have at least one field assigned to them specifically.' },
        { n:4, title:'Available tokens',        desc:'Your API key must have at least 1 available (unused, unexpired) token.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X POST https://dev1.aisign.ai/api/v1/documents/2850/use \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK — Document Activated', content:`{
  "success": true,
  "message": "Document activated successfully. Signing URLs generated and API token consumed.",
  "data": {
    "document_id": 2850,
    "document_uuid": "a7c8f3e2-9d4b-4e8a-b6c1-3f7e9a2d5c8b",
    "title": "Employment Contract",
    "status": "PENDING",
    "recipients_count": 2,
    "fields_count": 3,
    "signing_urls": [
      {
        "recipient_name": "John Smith",
        "recipient_email": "john@example.com",
        "action": "sign",
        "signing_url": "https://dev1.aisign.ai/signing-ceremony/eyJpdiI6InZXRU1Qdngy...",
        "signing_token": "eyJpdiI6InZXRU1Qdngy..."
      },
      {
        "recipient_name": "Jane Doe",
        "recipient_email": "jane@example.com",
        "action": "approve",
        "signing_url": "https://dev1.aisign.ai/signing-ceremony/eyJpdiI6ImFiYZR1...",
        "signing_token": "eyJpdiI6ImFiYZR1..."
      }
    ],
    "api_tokens_remaining": 44
  }
}`}},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:422, label:'No Recipients', content:`{
  "success": false,
  "message": "Document has no recipients. Please add recipients first.",
  "error_code": "NO_RECIPIENTS",
  "next_step": "POST /api/v1/documents/2850/recipients"
}`}},
      { type:'response', data:{ status:422, label:'No Fields', content:`{
  "success": false,
  "message": "Document has no fields. Please add fields first.",
  "error_code": "NO_FIELDS",
  "next_step": "POST /api/v1/documents/2850/fields"
}`}},
      { type:'response', data:{ status:422, label:'Incomplete Fields', content:`{
  "success": false,
  "message": "Some recipients have no fields assigned.",
  "error_code": "INCOMPLETE_FIELDS",
  "recipients_without_fields": ["jane@example.com"],
  "next_step": "POST /api/v1/documents/2850/fields"
}`}},
      { type:'response', data:{ status:402, label:'No Tokens Available', content:`{
  "success": false,
  "message": "No API tokens available. Please contact support to purchase more tokens.",
  "available_tokens": 0
}`}},
    ]
  },

  'documents/list-documents': {
    title: 'List Documents',
    meta: 'Retrieve a paginated list of all documents belonging to the authenticated user.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/documents', permission:'documents:read', consumesToken:false, description:'Returns a paginated list of documents. Supports filtering by signing status.' }},
      { type:'section_header', data:{ title:'Query Parameters', anchor:'query', level:2 }},
      { type:'param_table', data:{ location:'Query', params:[
        { name:'status', type:'enum',    required:false, description:'Filter documents by signing status.', default:'all', enum:['all','completed','pending'] },
        { name:'limit',  type:'integer', required:false, description:'Number of results per page (1–100).', default:'50' },
        { name:'page',   type:'integer', required:false, description:'Page number for pagination.', default:'1' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET "https://dev1.aisign.ai/api/v1/documents?status=completed&limit=20&page=1" \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": [
    {
      "document_id": 2806,
      "document_uuid": "39bfac07-6ef2-43e3-adc3-937245cb6682",
      "title": "Service Agreement — Client ABC",
      "original_filename": "service_agreement.pdf",
      "status": "UPLOADED",
      "signing_status": "completed",
      "is_fully_signed": true,
      "statistics": {
        "total_signers": 2,
        "pending": 0,
        "completed": 2,
        "voided": 0,
        "progress_percentage": 100
      },
      "created_at": "2024-10-01T23:42:47.000000Z",
      "updated_at": "2024-10-01T23:45:12.000000Z"
    }
  ],
  "pagination": {
    "total": 45,
    "count": 20,
    "per_page": 20,
    "current_page": 1,
    "total_pages": 3
  },
  "filter_applied": "completed"
}`}},
    ]
  },

  'documents/document-status': {
    title: 'Check Document Status',
    meta: 'Retrieve the current status of a document and detailed per-signer progress.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/documents/{documentId}/status', permission:'documents:read', consumesToken:false, description:'Returns the document\'s current signing status, per-recipient completion details, and overall signing statistics.' }},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'documentId', type:'integer', required:true, description:'The numeric document ID.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/documents/2806/status \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": {
    "document_id": 2806,
    "document_uuid": "39bfac07-6ef2-43e3-adc3-937245cb6682",
    "title": "Service Agreement — Client ABC",
    "status": "UPLOADED",
    "signing_status": "partially_signed",
    "is_fully_signed": false,
    "statistics": {
      "total_signers": 2,
      "pending": 1,
      "completed": 1,
      "voided": 0,
      "progress_percentage": 50
    },
    "signers": [
      {
        "name": "John Smith",
        "email": "john@example.com",
        "action": "sign",
        "status": "COMPLETED",
        "signed_at": "2024-10-01T23:45:12.000000Z",
        "is_pending": false
      },
      {
        "name": "Jane Doe",
        "email": "jane@example.com",
        "action": "approve",
        "status": "PENDING",
        "signed_at": null,
        "is_pending": true
      }
    ],
    "created_at": "2024-10-01T23:42:47.000000Z",
    "updated_at": "2024-10-01T23:45:12.000000Z"
  }
}`}},
      { type:'note', data:{ variant:'info', content:'For real-time notifications instead of polling, register a <code class="font-mono">document.completed</code> webhook. See the Webhooks section.' }},
    ]
  },

  'documents/drafts': {
    title: 'List Draft Documents',
    meta: 'Retrieve documents currently in draft status (UPLOADED or PREPARED) with optional sorting and date filtering.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/documents/drafts/info', permission:'documents:read', consumesToken:false, description:'Lists all draft documents along with a summary of draft slot usage. Supports sorting and date range filtering.' }},
      { type:'section_header', data:{ title:'Query Parameters', anchor:'query', level:2 }},
      { type:'param_table', data:{ location:'Query', params:[
        { name:'sort_by',        type:'enum',    required:false, description:'Field to sort results by.', default:'created_at', enum:['created_at','title','days_old'] },
        { name:'sort_order',     type:'enum',    required:false, description:'Sort direction.',            default:'desc',       enum:['asc','desc'] },
        { name:'created_after',  type:'date',    required:false, description:'Include only documents created after this date (YYYY-MM-DD).' },
        { name:'created_before', type:'date',    required:false, description:'Include only documents created before this date (YYYY-MM-DD).' },
        { name:'limit',          type:'integer', required:false, description:'Maximum number of results to return (1–100).' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET "https://dev1.aisign.ai/api/v1/documents/drafts/info?sort_by=title&sort_order=asc&limit=10" \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": {
    "draft_info": {
      "current_draft_documents": 3,
      "draft_documents_limit": 50,
      "remaining_draft_slots": 47,
      "can_create_more": true
    },
    "draft_documents": [
      {
        "document_id": 2955,
        "document_uuid": "31540ad2-2eee-4768-96f9-41596d531ca7",
        "title": "Contract Agreement",
        "created_at": "2025-12-02T23:26:28+00:00",
        "days_old": 7
      },
      {
        "document_id": 2956,
        "document_uuid": "42651be3-8f5c-5g9b-c7d2-4g8f0b3e6d9c",
        "title": "NDA Document",
        "created_at": "2025-12-05T10:15:30+00:00",
        "days_old": 4
      }
    ],
    "filters_applied": {
      "sort_by": "title",
      "sort_order": "asc",
      "limit": 10
    }
  }
}`}},
    ]
  },

  'documents/delete-drafts': {
    title: 'Delete Draft Documents',
    meta: 'Permanently delete one or more draft documents. You can target specific document IDs or delete all drafts at once.',
    blocks: [
      { type:'endpoint', data:{ method:'DELETE', url:'/documents/cleanup', permission:'documents:write', consumesToken:false, description:'Deletes draft documents (UPLOADED or PREPARED status). Removing related records and physical files is transactional — a failure rolls back all changes.' }},
      { type:'note', data:{ variant:'danger', content:'Deletion is <strong>permanent</strong>. Associated records (signer requests, document changes) and physical PDF files are deleted from both local storage and Azure Blob Storage.' }},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'param_table', data:{ location:'Body (optional)', params:[
        { name:'document_ids',   type:'array',   required:false, description:'Array of document IDs to delete. If omitted, <strong>all</strong> draft documents are deleted.' },
        { name:'document_ids.*', type:'integer', required:false, description:'Each ID must belong to the authenticated user and be in draft status.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL — Delete Specific Documents', content:`curl -X DELETE https://dev1.aisign.ai/api/v1/documents/cleanup \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{ "document_ids": [2955, 2956, 2957] }'`}},
      { type:'code', data:{ language:'bash', label:'cURL — Delete ALL Drafts', content:`curl -X DELETE https://dev1.aisign.ai/api/v1/documents/cleanup \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Deletion Rules', anchor:'rules', level:2 }},
      { type:'text', data:{ content:'The endpoint will <strong>refuse</strong> to delete documents that:' }},
      { type:'feature_list', data:{ items:[
        { icon:'doc', label:'Already sent',       desc:'Documents where is_sent = 1 cannot be deleted.' },
        { icon:'doc', label:'PENDING status',     desc:'Documents currently being signed cannot be deleted.' },
        { icon:'doc', label:'Template documents', desc:'Documents marked as templates (is_template = 1) are protected.' },
        { icon:'doc', label:'Not owned by you',   desc:'You can only delete documents belonging to your API key.' },
      ]}},
      { type:'section_header', data:{ title:'Response — All Deleted', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK — All Deleted', content:`{
  "success": true,
  "message": "Documents deleted successfully",
  "data": {
    "deleted_count": 3,
    "deleted_ids": [2955, 2956, 2957],
    "failed_count": 0,
    "failed_deletions": [],
    "total_scanned": 3,
    "current_draft_info": {
      "current_draft_documents": 0,
      "draft_documents_limit": 50,
      "remaining_draft_slots": 50,
      "can_create_more": true
    },
    "operation": "specific_documents"
  }
}`}},
      { type:'response', data:{ status:200, label:'OK — Partial Deletion', content:`{
  "success": true,
  "message": "Partial deletion completed",
  "data": {
    "deleted_count": 2,
    "deleted_ids": [2955, 2956],
    "failed_count": 1,
    "failed_deletions": [
      { "document_id": 2957, "error": "Document has already been sent or is pending" }
    ],
    "total_scanned": 3,
    "current_draft_info": {
      "current_draft_documents": 1,
      "draft_documents_limit": 50,
      "remaining_draft_slots": 49,
      "can_create_more": true
    },
    "operation": "specific_documents"
  }
}`}},
    ]
  },

  'documents/download': {
    title: 'Download Completed Document',
    meta: 'Download the final signed PDF once all recipients have completed the signing process.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/documents/{uuid}/download', permission:'documents:read', consumesToken:false, description:'Returns the completed, signed PDF as binary data. The document must be in COMPLETED status (all recipients finished).' }},
      { type:'note', data:{ variant:'warning', content:'The document must be <strong>fully completed</strong> (all recipients have signed/approved). Attempting to download a PENDING document returns a 400 error.' }},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'uuid', type:'string', required:true, description:'The document UUID (not the numeric ID). Found in the document_uuid field of upload or status responses.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL — Save to file', content:`curl -X GET https://dev1.aisign.ai/api/v1/documents/1c4bd452-2768-4c43-9674-76c89a0ec301/download \\
  -H "Authorization: Bearer sk_your_api_key" \\
  --output signed_contract.pdf`}},
      { type:'section_header', data:{ title:'Response Headers', anchor:'headers', level:2 }},
      { type:'code', data:{ language:'bash', label:'Response Headers (200 OK)', content:`Content-Type: application/pdf
Content-Disposition: attachment; filename="Employment_Contract.pdf"
Content-Length: 245632`}},
      { type:'text', data:{ content:'The response body is the raw binary PDF data. Use <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">--output</code> (curl) or save the response buffer in your language of choice.' }},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:400, label:'Document Not Completed', content:`{
  "success": false,
  "message": "Document is not completed yet",
  "current_status": "PENDING"
}`}},
      { type:'response', data:{ status:404, label:'Document Not Found', content:`{
  "success": false,
  "message": "Document not found or access denied"
}`}},
      { type:'response', data:{ status:404, label:'PDF File Missing', content:`{
  "success": false,
  "message": "Document file not found"
}`}},
      { type:'note', data:{ variant:'info', content:'The <code class="font-mono">document.completed</code> webhook payload includes a <code class="font-mono">download_url</code> field you can use directly without constructing the URL manually.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // TOKENS
  // ═══════════════════════════════════════════
  'tokens/balance': {
    title: 'Check Token Balance',
    meta: 'Retrieve the current API token balance for the authenticated user, broken down by available, used, and expired tokens.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/tokens/balance', permission:'templates:read', consumesToken:false, description:'Returns detailed token accounting for the current API key. Does not consume a token.' }},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/tokens/balance \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": {
    "available_tokens": 45,
    "used_tokens": 5,
    "expired_tokens": 0,
    "total_tokens": 50,
    "user_info": {
      "user_id": 123,
      "email": "user@example.com",
      "name": "John Doe"
    }
  }
}`}},
      { type:'section_header', data:{ title:'Token Lifecycle', anchor:'lifecycle', level:2 }},
      { type:'param_table', data:{ location:'Token States', params:[
        { name:'available_tokens', type:'integer', required:false, description:'Tokens ready to use. Not yet consumed and not expired.' },
        { name:'used_tokens',      type:'integer', required:false, description:'Tokens that have been consumed by activating a document.' },
        { name:'expired_tokens',   type:'integer', required:false, description:'Tokens that reached their expiration date before being used. Cannot be recovered.' },
        { name:'total_tokens',     type:'integer', required:false, description:'Sum of all tokens ever assigned: available + used + expired.' },
      ]}},
      { type:'section_header', data:{ title:'Token Consumption Reference', anchor:'consumption', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'✅',  label:'POST /templates/{id}/use',      desc:'Consumes 1 token.' },
        { code:'✅',  label:'POST /documents/{id}/use',      desc:'Consumes 1 token.' },
        { code:'❌',  label:'POST /documents/upload',        desc:'Free — no token consumed.' },
        { code:'❌',  label:'POST /documents/{id}/recipients',desc:'Free — no token consumed.' },
        { code:'❌',  label:'POST /documents/{id}/fields',   desc:'Free — no token consumed.' },
        { code:'❌',  label:'GET /tokens/balance',           desc:'Free — no token consumed.' },
        { code:'❌',  label:'GET /documents/drafts/info',    desc:'Free — no token consumed.' },
        { code:'❌',  label:'All GET endpoints',             desc:'Free — no token consumed.' },
      ]}},
      { type:'note', data:{ variant:'warning', content:'Expired tokens <strong>cannot be refunded or reactivated</strong>. Tokens have an expiration date — check the dashboard for token expiry details.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // LOGS
  // ═══════════════════════════════════════════
  'logs/api-logs': {
    title: 'API Logs',
    meta: 'Retrieve a history of API calls made with the authenticated key. Logs are retained for 30 days.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/logs', permission:'templates:read', consumesToken:false, description:'Returns a list of API requests made with the current API key on a given date. Maximum 30-day retention.' }},
      { type:'section_header', data:{ title:'Query Parameters', anchor:'query', level:2 }},
      { type:'param_table', data:{ location:'Query', params:[
        { name:'date',  type:'string',  required:false, description:'Date to retrieve logs for, in YYYY-MM-DD format.', default:'Today' },
        { name:'limit', type:'integer', required:false, description:'Maximum number of log entries to return (1–100).', default:'100' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET "https://dev1.aisign.ai/api/v1/logs?date=2024-10-08&limit=50" \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": [
    {
      "timestamp": "2024-10-08T14:30:45.000000Z",
      "endpoint": "api/v1/templates/2794/use",
      "method": "POST",
      "status": 201,
      "response_time_ms": 245,
      "template_id": "2794",
      "document_id": "2806",
      "ip": "192.168.1.100"
    },
    {
      "timestamp": "2024-10-08T14:28:30.000000Z",
      "endpoint": "api/v1/templates",
      "method": "GET",
      "status": 200,
      "response_time_ms": 48,
      "template_id": null,
      "document_id": null,
      "ip": "192.168.1.100"
    }
  ],
  "count": 2,
  "date": "2024-10-08"
}`}},
      { type:'note', data:{ variant:'warning', content:'Log history is retained for <strong>30 days</strong> only. Logs older than 30 days are automatically purged. Download and store logs you need long-term.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // WEBHOOKS
  // ═══════════════════════════════════════════
  'webhooks/overview': {
    title: 'Webhooks Overview',
    meta: 'Webhooks deliver real-time event notifications to your server when specific actions occur — no polling required. Each event type carries its own secret for signature verification.',
    blocks: [
      { type:'section_header', data:{ title:'How Webhooks Work', anchor:'how', level:2 }},
      { type:'text', data:{ content:'When an event occurs, AiSign sends an HTTP POST request to your registered endpoint. Your server must respond with <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">200 OK</code> within <strong>10 seconds</strong>. Do all heavy processing <strong>after</strong> returning the response.' }},
      { type:'note', data:{ variant:'warning', content:'Webhooks only fire for documents created via the API (<code class="font-mono">is_from_api = true</code>). Documents created through the web dashboard do not trigger webhook events.' }},

      { type:'section_header', data:{ title:'Available Events', anchor:'events', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'document.uploaded',  label:'Document Uploaded',   desc:'PDF successfully uploaded via API.' },
        { code:'recipient.added',    label:'Recipient Added',     desc:'One or more recipients added to a document.' },
        { code:'field.added',        label:'Field Added',         desc:'Signature or form fields placed on a document.' },
        { code:'document.activated', label:'Document Activated',  desc:'Document finalised and sent to all recipients.' },
        { code:'document.viewed',    label:'Document Viewed',     desc:'A recipient opened the signing ceremony for the first time.' },
        { code:'field.signed',       label:'Field Signed',        desc:'A recipient signed a signature field.' },
        { code:'document.completed', label:'Document Completed',  desc:'All recipients finished. Payload includes <code class="font-mono">download_url</code> for the signed PDF.' },
      ]}},

      { type:'section_header', data:{ title:'Payload Structure', anchor:'payload', level:2 }},
      { type:'text', data:{ content:'Every event uses the same envelope. The <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">type</code> field tells you which event fired; <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">id</code> is a unique delivery ID you can use for idempotency.' }},
      { type:'code', data:{ language:'json', label:'Envelope', content:`{
  "id":          "evt_abc123...",
  "type":        "document.completed",
  "created":     1234567890,
  "api_version": "v1",
  "data": { }
}`}},

      { type:'section_header', data:{ title:'Per-Event Secrets', anchor:'secrets', level:2 }},
      { type:'text', data:{ content:'Each webhook registration returns its <strong>own</strong> secret. When your server receives a request, look up the secret that matches the incoming event type before verifying the signature.' }},
      { type:'note', data:{ variant:'danger', content:'The <code class="font-mono">secret</code> is returned <strong>only once</strong> — at webhook creation time. Store each secret against its event type immediately (e.g. in environment variables).' }},
      { type:'text', data:{ content:'A practical naming convention used in production is to concatenate a common prefix with the event type value:' }},
      { type:'code', data:{ language:'bash', label:'.env — per-event secrets', content:`WEBHOOK_SECRETdocument.uploaded=whsec_abc...
WEBHOOK_SECRETrecipient.added=whsec_def...
WEBHOOK_SECRETfield.added=whsec_ghi...
WEBHOOK_SECRETdocument.activated=whsec_jkl...
WEBHOOK_SECRETdocument.viewed=whsec_mno...
WEBHOOK_SECRETfield.signed=whsec_pqr...
WEBHOOK_SECRETdocument.completed=whsec_stu...`}},
      { type:'text', data:{ content:'Then at runtime, resolve the right secret by reading <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">event.type</code> from the payload before calling the verification function:' }},
      { type:'code', data:{ language:'python', label:'Python — resolve secret by event type', content:`import os
from dotenv import load_dotenv

load_dotenv(override=True)

def get_webhook_secret(event_type: str) -> str:
    """Return the secret registered for this specific event type."""
    return os.getenv("WEBHOOK_SECRET" + event_type)   # e.g. "WEBHOOK_SECRETdocument.completed"`}},

      { type:'section_header', data:{ title:'HMAC Signature Verification', anchor:'security', level:2 }},
      { type:'text', data:{ content:'Every POST includes an <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">X-Webhook-Signature</code> header — an HMAC-SHA256 hex digest of the <strong>raw request body bytes</strong>. Always verify before processing.' }},
      { type:'steps', data:{ steps:[
        { n:1, title:'Read the signature header', desc:'Extract <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">X-Webhook-Signature</code> from the request.' },
        { n:2, title:'Parse event type',          desc:'Decode the JSON body and read <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">type</code> to look up the correct per-event secret.' },
        { n:3, title:'Compute HMAC-SHA256',        desc:'Hash the <strong>raw body bytes</strong> (not the parsed JSON) with the secret using HMAC-SHA256.' },
        { n:4, title:'Timing-safe compare',        desc:'Use a constant-time comparison to check the computed digest against the header value. Never use <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">==</code>.' },
      ]}},
      { type:'note', data:{ variant:'danger', content:'Always use the <strong>raw request body bytes</strong> for hashing — not a re-serialised version of the parsed JSON. Byte order and whitespace must be identical to what AiSign sent.' }},

      { type:'code', data:{ language:'python', label:'Python — full verification function', content:`import hmac
import hashlib
from flask import request

def verify_webhook(request) -> bool:
    signature = request.headers.get('X-Webhook-Signature')
    if not signature:
        return False

    # Resolve the secret for this specific event type
    data       = request.json
    event_type = data.get("type")
    secret     = get_webhook_secret(event_type)   # per-event secret (see above)
    if not secret:
        return False

    # Hash the RAW body bytes — never the parsed/re-serialised JSON
    raw_body = request.data
    computed = hmac.new(
        secret.encode('utf-8'),
        raw_body,
        hashlib.sha256
    ).hexdigest()

    # Timing-safe comparison prevents timing attacks
    return hmac.compare_digest(
        signature.encode('utf-8'),
        computed.encode('utf-8')
    )`}},

      { type:'code', data:{ language:'javascript', label:'Node.js — verification function', content:`const crypto = require('crypto');

function verifyWebhookSignature(rawBody, signature, secret) {
  const computed = crypto
    .createHmac('sha256', secret)
    .update(rawBody)          // raw Buffer, not parsed JSON
    .digest('hex');

  return crypto.timingSafeEqual(
    Buffer.from(signature),
    Buffer.from(computed)
  );
}`}},

      { type:'code', data:{ language:'php', label:'PHP — verification function', content:`function verifyWebhookSignature(string $payload, string $signature, string $secret): bool {
    $computed = hash_hmac('sha256', $payload, $secret);
    return hash_equals($computed, $signature);  // constant-time compare
}`}},

      { type:'section_header', data:{ title:'Full Server Example (Python / Flask)', anchor:'server', level:2 }},
      { type:'text', data:{ content:'The pattern below mirrors a production setup: verify first, respond <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">200 OK</code> immediately, then dispatch the event asynchronously so slow processing never times out the delivery.' }},
      { type:'code', data:{ language:'python', label:'Python — Flask webhook server', content:`from flask import Flask, request
import json, hmac, hashlib, os, asyncio
from enum import Enum
from dotenv import load_dotenv

app = Flask(__name__)

# ── Event type registry ──────────────────────────────
class WebhookEventType(Enum):
    DOCUMENT_UPLOADED  = "document.uploaded"
    RECIPIENT_ADDED    = "recipient.added"
    FIELD_ADDED        = "field.added"
    DOCUMENT_ACTIVATED = "document.activated"
    DOCUMENT_VIEWED    = "document.viewed"
    FIELD_SIGNED       = "field.signed"
    DOCUMENT_COMPLETED = "document.completed"

def match_event_type(event_type: str):
    for event in WebhookEventType:
        if event.value == event_type:
            return event
    return None

# ── Secret resolution ────────────────────────────────
def get_webhook_secret(event_type: str) -> str:
    load_dotenv(override=True)
    return os.getenv("WEBHOOK_SECRET" + event_type)

# ── Signature verification ───────────────────────────
def verify_webhook(req) -> bool:
    signature  = req.headers.get('X-Webhook-Signature')
    event_type = req.json.get("type")
    secret     = get_webhook_secret(event_type)
    if not signature or not secret:
        return False

    computed = hmac.new(
        secret.encode('utf-8'),
        req.data,          # raw bytes — critical
        hashlib.sha256
    ).hexdigest()

    return hmac.compare_digest(
        signature.encode('utf-8'),
        computed.encode('utf-8')
    )

# ── Async event handler ──────────────────────────────
async def handle_event(event_type: str, data: dict):
    print(f"[webhook] {event_type}")
    match event_type:

        case WebhookEventType.DOCUMENT_COMPLETED.value:
            # The completed payload includes a ready-made download_url
            download_url = data.get("data", {}).get("download_url")
            if download_url:
                download_document(download_url, "./signed_output.pdf")

        case _:
            print(f"[webhook] unhandled event: {event_type}")

# ── Route ─────────────────────────────────────────────
@app.route('/webhook', methods=['POST'])
def handle_webhook():
    if not verify_webhook(request):
        return "Unauthorized", 401

    data       = request.json
    event_type = data.get("type")

    # Respond 200 immediately — never block AiSign waiting for your processing
    try:
        loop = asyncio.get_running_loop()
        loop.create_task(handle_event(event_type, data))
    except RuntimeError:
        asyncio.run(handle_event(event_type, data))

    return "OK", 200

if __name__ == '__main__':
    app.run(port=5000)`}},

      { type:'section_header', data:{ title:'Handling document.completed', anchor:'completed', level:2 }},
      { type:'text', data:{ content:'The <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">document.completed</code> event is the most important. Its payload includes a <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">download_url</code> pointing directly to the signed PDF — use it with your API key to download without constructing the URL manually.' }},
      { type:'code', data:{ language:'json', label:'document.completed payload', content:`{
  "id":          "evt_C3dE4fG5hI6jK7lM8nO9",
  "type":        "document.completed",
  "created":     1770170000,
  "api_version": "v1",
  "data": {
    "document_id":   3520,
    "document_uuid": "1c4bd452-2768-4c43-9674-76c89a0ec301",
    "title":         "Employment Contract",
    "completed_at":  "2026-02-07T16:53:20Z",
    "download_url":  "https://api.aisign.ai/api/v1/documents/1c4bd452-.../download",
    "signers": [
      { "email": "john@example.com", "name": "John Doe",  "completed_at": "2026-02-07T16:40:00Z" },
      { "email": "jane@example.com", "name": "Jane Smith","completed_at": "2026-02-07T16:53:20Z" }
    ]
  }
}`}},
      { type:'code', data:{ language:'python', label:'Python — download signed PDF from event', content:`import requests

def download_document(download_url: str, output_path: str):
    """Download the completed signed PDF using the URL from the webhook payload."""
    headers = { "Authorization": f"Bearer {os.getenv('AISIGN_API_KEY')}" }
    response = requests.get(download_url, headers=headers)

    if response.status_code == 200:
        with open(output_path, 'wb') as f:
            f.write(response.content)
        print(f"Saved signed PDF → {output_path}")
    else:
        print(f"Download failed: {response.status_code} — {response.text}")`}},
      { type:'note', data:{ variant:'info', content:'The <code class="font-mono">download_url</code> in the webhook payload is the same as calling <code class="font-mono">GET /api/v1/documents/{uuid}/download</code> directly. Both require your API key in the Authorization header.' }},

      { type:'section_header', data:{ title:'Idempotency', anchor:'idempotency', level:2 }},
      { type:'text', data:{ content:'AiSign may deliver the same event more than once (due to retries). Use the <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">id</code> field to deduplicate:' }},
      { type:'code', data:{ language:'python', label:'Python — idempotency check', content:`processed_events = set()   # use a database in production

async def handle_event(event_type: str, data: dict):
    event_id = data.get("id")

    if event_id in processed_events:
        print(f"[webhook] duplicate — skipping {event_id}")
        return

    processed_events.add(event_id)
    # ... process the event`}},

      { type:'section_header', data:{ title:'Retry Schedule', anchor:'retry', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'1', label:'Immediate',  desc:'First delivery fires immediately after the event.' },
        { code:'2', label:'30 seconds', desc:'Retried 30 seconds after the first failure.' },
        { code:'3', label:'5 minutes',  desc:'Retried 5 minutes after the second failure.' },
        { code:'4', label:'1 hour',     desc:'Retried 1 hour after the third failure.' },
        { code:'5', label:'6 hours',    desc:'Final retry 6 hours after the fourth failure. No further attempts.' },
      ]}},
      { type:'note', data:{ variant:'warning', content:'Your endpoint must return <code class="font-mono">200 OK</code> within <strong>10 seconds</strong>. Always return 200 first and process asynchronously — never let slow business logic block the response.' }},

      { type:'section_header', data:{ title:'Rate Limits', anchor:'limits', level:2 }},
      { type:'param_table', data:{ location:'Webhook Limits', params:[
        { name:'Max endpoints per API key', type:'—', required:false, description:'30 webhook endpoints maximum.' },
        { name:'Delivery timeout',          type:'—', required:false, description:'10 seconds. Respond immediately, process async.' },
        { name:'Max retry attempts',        type:'—', required:false, description:'5 attempts with exponential backoff before marking failed.' },
        { name:'Max payload size',          type:'—', required:false, description:'5 MB per webhook payload.' },
      ]}},
    ]
  },

  'webhooks/register-webhook': {
    title: 'Register Webhook',
    meta: 'Create a new webhook endpoint to receive notifications for a specific event type.',
    blocks: [
      { type:'endpoint', data:{ method:'POST', url:'/webhooks', permission:'documents:write', consumesToken:false, description:'Registers a new webhook URL for a given event type. Returns a secret used to verify incoming webhook signatures.' }},
      { type:'note', data:{ variant:'danger', content:'The <code class="font-mono">secret</code> field is <strong>only returned once</strong> at creation time. Save it immediately and securely. You cannot retrieve it again.' }},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'param_table', data:{ location:'Body', params:[
        { name:'event_type', type:'enum',   required:true,  description:'The event type to subscribe to. Must be one of the available event types.', enum:['document.uploaded','recipient.added','field.added','document.activated','document.viewed','field.signed','document.completed'] },
        { name:'url',        type:'string', required:true,  description:'Your HTTPS endpoint URL that will receive POST requests. Max 500 characters. Must use HTTPS.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X POST https://dev1.aisign.ai/api/v1/webhooks \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{
    "event_type": "document.completed",
    "url": "https://your-domain.com/webhooks/aisign"
  }'`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:201, label:'Created', content:`{
  "success": true,
  "message": "Webhook created successfully",
  "data": {
    "id": 1,
    "event_type": "document.completed",
    "url": "https://your-domain.com/webhooks/aisign",
    "secret": "whsec_abc123def456ghi789...",
    "is_active": true,
    "created_at": "2026-02-07T12:00:00Z"
  }
}`}},
      { type:'section_header', data:{ title:'Error Responses', anchor:'errors', level:2 }},
      { type:'response', data:{ status:409, label:'Webhook Already Exists', content:`{
  "success": false,
  "message": "A webhook for this event type and URL already exists",
  "error_code": "WEBHOOK_ALREADY_EXISTS"
}`}},
      { type:'response', data:{ status:422, label:'Validation Failed', content:`{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "event_type": ["The event type field is required."],
    "url": ["The url must be a valid URL."]
  }
}`}},
      { type:'note', data:{ variant:'warning', content:'Webhook URLs <strong>must use HTTPS</strong>. HTTP URLs are rejected. Use a tool like <a href="https://ngrok.com" class="text-[#3277DF] underline" target="_blank">ngrok</a> or <a href="https://webhook.site" class="text-[#3277DF] underline" target="_blank">webhook.site</a> for local development.' }},
    ]
  },

  'webhooks/list-webhooks': {
    title: 'List Webhooks',
    meta: 'Retrieve all webhook endpoints configured for the authenticated API key.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/webhooks', permission:'documents:read', consumesToken:false, description:'Returns all webhooks registered to the current API key.' }},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/webhooks \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": [
    {
      "id": 1,
      "event_type": "document.uploaded",
      "url": "https://your-domain.com/webhooks/aisign",
      "is_active": true,
      "created_at": "2026-02-07T12:00:00Z"
    },
    {
      "id": 2,
      "event_type": "document.completed",
      "url": "https://your-domain.com/webhooks/aisign",
      "is_active": true,
      "created_at": "2026-02-07T13:00:00Z"
    }
  ]
}`}},
      { type:'note', data:{ variant:'info', content:'The <code class="font-mono">secret</code> is <strong>not</strong> returned in the list response for security. Use <code class="font-mono">GET /webhooks/{id}</code> to retrieve the secret for a specific webhook.' }},
    ]
  },

  'webhooks/get-webhook-details': {
    title: 'Get Webhook Details',
    meta: 'Retrieve complete details for a specific webhook, including its secret.',
    blocks: [
      { type:'endpoint', data:{ method:'GET', url:'/webhooks/{id}', permission:'documents:read', consumesToken:false, description:'Returns full details of a single webhook including its signing secret.' }},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'id', type:'integer', required:true, description:'The webhook ID returned at creation time.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X GET https://dev1.aisign.ai/api/v1/webhooks/1 \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "data": {
    "id": 1,
    "event_type": "document.uploaded",
    "url": "https://your-domain.com/webhooks/aisign",
    "secret": "whsec_abc123def456...",
    "is_active": true,
    "created_at": "2026-02-07T12:00:00Z",
    "updated_at": "2026-02-07T12:00:00Z"
  }
}`}},
      { type:'response', data:{ status:404, label:'Not Found', content:`{
  "success": false,
  "message": "Webhook not found"
}`}},
    ]
  },

  'webhooks/update-webhook': {
    title: 'Update Webhook',
    meta: 'Update the URL or active status of an existing webhook. The event type cannot be changed — create a new webhook instead.',
    blocks: [
      { type:'endpoint', data:{ method:'PUT', url:'/webhooks/{id}', permission:'documents:write', consumesToken:false, description:'Partially updates a webhook. Both fields are optional; include only what you want to change.' }},
      { type:'section_header', data:{ title:'Body Parameters', anchor:'body', level:2 }},
      { type:'param_table', data:{ location:'Body', params:[
        { name:'url',       type:'string',  required:false, description:'New HTTPS endpoint URL. Max 500 characters.' },
        { name:'is_active', type:'boolean', required:false, description:'Set to false to pause webhook delivery without deleting it.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL — Deactivate a Webhook', content:`curl -X PUT https://dev1.aisign.ai/api/v1/webhooks/1 \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{ "is_active": false }'`}},
      { type:'code', data:{ language:'bash', label:'cURL — Update URL', content:`curl -X PUT https://dev1.aisign.ai/api/v1/webhooks/1 \\
  -H "Authorization: Bearer sk_your_api_key" \\
  -H "Content-Type: application/json" \\
  -d '{ "url": "https://new-domain.com/webhooks/aisign" }'`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "message": "Webhook updated successfully",
  "data": {
    "id": 1,
    "event_type": "document.uploaded",
    "url": "https://new-domain.com/webhooks/aisign",
    "is_active": false,
    "updated_at": "2026-02-07T14:00:00Z"
  }
}`}},
      { type:'note', data:{ variant:'info', content:'To change the <code class="font-mono">event_type</code>, delete this webhook and create a new one. The event type cannot be updated in place.' }},
    ]
  },

  'webhooks/delete-webhook': {
    title: 'Delete Webhook',
    meta: 'Permanently remove a webhook endpoint.',
    blocks: [
      { type:'endpoint', data:{ method:'DELETE', url:'/webhooks/{id}', permission:'documents:write', consumesToken:false, description:'Permanently deletes a webhook. No further events will be delivered to it.' }},
      { type:'section_header', data:{ title:'Path Parameters', anchor:'path', level:2 }},
      { type:'param_table', data:{ location:'Path', params:[
        { name:'id', type:'integer', required:true, description:'The webhook ID to delete.' },
      ]}},
      { type:'code', data:{ language:'bash', label:'cURL', content:`curl -X DELETE https://dev1.aisign.ai/api/v1/webhooks/1 \\
  -H "Authorization: Bearer sk_your_api_key"`}},
      { type:'section_header', data:{ title:'Response', anchor:'response', level:2 }},
      { type:'response', data:{ status:200, label:'OK', content:`{
  "success": true,
  "message": "Webhook deleted successfully"
}`}},
      { type:'response', data:{ status:404, label:'Not Found', content:`{
  "success": false,
  "message": "Webhook not found"
}`}},
      { type:'note', data:{ variant:'warning', content:'Deletion is permanent. If you want to temporarily stop receiving events, consider setting <code class="font-mono">is_active: false</code> via the Update Webhook endpoint instead.' }},
    ]
  },

  // ═══════════════════════════════════════════
  // ERROR HANDLING
  // ═══════════════════════════════════════════
  'error-handling/errors': {
    title: 'Error Reference',
    meta: 'Complete reference for all error codes and HTTP status codes returned by the AiSign API.',
    blocks: [
      { type:'section_header', data:{ title:'HTTP Status Codes', anchor:'http', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'200', label:'OK',                    desc:'Request succeeded. Response body contains the result.' },
        { code:'201', label:'Created',               desc:'Resource successfully created (e.g. document activated, webhook registered).' },
        { code:'400', label:'Bad Request',            desc:'The request is malformed or the resource is in an incompatible state (e.g. downloading an incomplete document).' },
        { code:'401', label:'Unauthorized',           desc:'Missing, invalid, or expired API key.' },
        { code:'402', label:'Payment Required',       desc:'Your API token balance is zero. Purchase more tokens to continue.' },
        { code:'404', label:'Not Found',              desc:'The requested resource (document, template, webhook) does not exist or you do not have access.' },
        { code:'409', label:'Conflict',               desc:'A duplicate resource exists (e.g. webhook for the same event + URL combination).' },
        { code:'422', label:'Unprocessable Entity',   desc:'Input validation failed or a business rule was violated.' },
        { code:'500', label:'Internal Server Error',  desc:'Unexpected server-side error. Contact support if this persists.' },
      ]}},
      { type:'section_header', data:{ title:'Error Codes', anchor:'codes', level:2 }},
      { type:'text', data:{ content:'Many 422 responses include a machine-readable <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">error_code</code> field to help you handle errors programmatically:' }},
      { type:'status_table', data:{ rows:[
        { code:'AMBIGUOUS_POSITIONING',   label:'Field has x/y AND reference_text', desc:'Remove either absolute coordinates or the OCR reference text from the field object.' },
        { code:'REFERENCE_WORD_NOT_FOUND',label:'OCR text not found in document',   desc:'Check for typos in reference_text, or use absolute positioning instead.' },
        { code:'DOCUMENT_NOT_EDITABLE',   label:'Document cannot be edited',        desc:'The document is in PENDING or COMPLETED status. Only UPLOADED and PREPARED documents can be modified.' },
        { code:'NO_RECIPIENTS',           label:'Activation failed — no recipients',desc:'Add at least one recipient before activating the document.' },
        { code:'NO_FIELDS',               label:'Activation failed — no fields',     desc:'Add at least one field before activating.' },
        { code:'INCOMPLETE_FIELDS',       label:'A recipient has no fields',         desc:'Every recipient must have at least one field assigned.' },
        { code:'WEBHOOK_ALREADY_EXISTS',  label:'Duplicate webhook',                 desc:'A webhook for this event_type and URL already exists. Delete it first or use a different URL.' },
        { code:'PDF_NOT_FOUND',           label:'PDF missing for OCR',               desc:'The uploaded file could not be located. Try re-uploading the document.' },
        { code:'PDF_DIMENSIONS_ERROR',    label:'PDF dimensions could not be read',  desc:'The PDF may be corrupt or use an unsupported encoding.' },
      ]}},
      { type:'section_header', data:{ title:'Validation Error Shape', anchor:'validation', level:2 }},
      { type:'response', data:{ status:422, label:'Validation Failed', content:`{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "recipients": ["The recipients field is required."],
    "recipients.0.email": ["The email must be a valid email address."]
  }
}`}},
      { type:'section_header', data:{ title:'Common Error Patterns', anchor:'patterns', level:2 }},
      { type:'code', data:{ language:'javascript', label:'JavaScript — Error Handling', content:`async function callAiSign(url, options = {}) {
  const res = await fetch(url, {
    headers: { 'Authorization': 'Bearer sk_your_key', 'Content-Type': 'application/json' },
    ...options
  });
  const data = await res.json();

  if (!data.success) {
    switch (res.status) {
      case 401: throw new Error('Invalid API key');
      case 402: throw new Error('No tokens available — purchase more');
      case 404: throw new Error('Resource not found');
      case 422:
        if (data.error_code === 'REFERENCE_WORD_NOT_FOUND') {
          throw new Error('OCR text not found: ' + data.reference_text);
        }
        throw new Error('Validation: ' + JSON.stringify(data.errors));
      default:  throw new Error(data.message || 'Unknown error');
    }
  }
  return data;
}`}},
    ]
  },

  // ═══════════════════════════════════════════
  // LIMITS & QUOTAS
  // ═══════════════════════════════════════════
  'limits/limits': {
    title: 'Limits & Quotas',
    meta: 'Resource limits and quotas that apply to all requests made with the AiSign API.',
    blocks: [
      { type:'section_header', data:{ title:'Document Limits', anchor:'docs', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'50',   label:'Max recipients per document', desc:'A single document can have up to 50 recipients.' },
        { code:'512',  label:'Max title length (characters)', desc:'Document and template titles are capped at 512 characters.' },
        { code:'255',  label:'Max email length (characters)', desc:'Recipient email addresses are capped at 255 characters.' },
        { code:'10 MB',label:'Max upload file size', desc:'PDF, DOC, and DOCX files must be 10 MB or smaller.' },
        { code:'10',   label:'Default draft document limit', desc:'Each API key can have up to 10 simultaneous draft documents. Completed documents do not count.' },
      ]}},
      { type:'section_header', data:{ title:'Field Limits', anchor:'fields', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'0–100',    label:'Coordinate scale',         desc:'x, y, width, and height use a 0–100 percentage scale relative to the page.' },
        { code:'0–100',    label:'offset_pixels range',      desc:'OCR offset distance accepts values from 0 to 100 pixels.' },
        { code:'255',      label:'Max reference_text length', desc:'OCR search phrases are capped at 255 characters.' },
        { code:'1–500',    label:'TEXT field max_length',    desc:'Pre-filled text fields allow up to 500 characters (minimum enforced: 20).' },
        { code:'8–72',     label:'font_size range (px)',     desc:'Text field font sizes must be between 8 and 72 pixels.' },
      ]}},
      { type:'section_header', data:{ title:'Logs', anchor:'logs', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'30 days', label:'Log retention',     desc:'API call history is retained for 30 days and then automatically purged.' },
        { code:'100',     label:'Max logs per request', desc:'A single GET /logs call returns a maximum of 100 entries.' },
      ]}},
      { type:'section_header', data:{ title:'Webhooks', anchor:'webhooks', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'30',   label:'Max webhooks per API key',  desc:'You can register a maximum of 30 webhook endpoints per API key.' },
        { code:'10 s', label:'Delivery timeout',          desc:'Your endpoint must respond within 10 seconds or the delivery is retried.' },
        { code:'5',    label:'Max retry attempts',         desc:'Failed deliveries are retried up to 5 times with exponential backoff.' },
        { code:'5 MB', label:'Max webhook payload size',  desc:'Individual webhook payloads cannot exceed 5 MB.' },
      ]}},
    ]
  },

  // ═══════════════════════════════════════════
  // STATUS LIFECYCLE
  // ═══════════════════════════════════════════
  'status-lifecycle/lifecycle': {
    title: 'Document Status Lifecycle',
    meta: 'Understand how a document moves through different statuses from upload to completion.',
    blocks: [
      { type:'section_header', data:{ title:'Status Overview', anchor:'statuses', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'UPLOADED',  label:'Draft — No Fields',   desc:'Document has been uploaded. No form fields have been added yet. Editable.' },
        { code:'PREPARED',  label:'Draft — Has Fields',  desc:'At least one field has been added. Document is still editable (recipients and fields can be modified).' },
        { code:'PENDING',   label:'Active — In Progress', desc:'Document has been activated. Signing URLs generated. Document is locked from editing. Recipients are signing.' },
        { code:'COMPLETED', label:'Done — Fully Signed', desc:'All recipients have completed their assigned actions. The signed PDF is available for download.' },
        { code:'VOIDED',    label:'Cancelled',           desc:'Document was voided and can no longer be signed.' },
      ]}},
      { type:'section_header', data:{ title:'Workflow A — Template Path', anchor:'workflow-a', level:2 }},
      { type:'text', data:{ content:'When using <code class="font-mono bg-slate-100 border border-slate-200 text-[#3277DF] text-xs px-1 rounded">POST /templates/{id}/use</code>, the document immediately enters PENDING status — there is no intermediate UPLOADED or PREPARED stage.' }},
      { type:'code', data:{ language:'bash', label:'Template Path', content:`POST /templates/{id}/use
  └─► Document created directly as PENDING
       └─► Recipients complete signing
            └─► COMPLETED (download available)`}},
      { type:'section_header', data:{ title:'Workflow B — Manual Document Path', anchor:'workflow-b', level:2 }},
      { type:'code', data:{ language:'bash', label:'Manual Upload Path', content:`POST /documents/upload
  └─► UPLOADED  (no fields yet — editable)
       │
       POST /documents/{id}/recipients  (free, no token)
       POST /documents/{id}/fields      ─► PREPARED  (has fields — still editable)
       │
       POST /documents/{id}/use         ─► PENDING   (locked, 1 token consumed)
       │
       Recipients sign
       │
       └─► COMPLETED  (download available via GET /documents/{uuid}/download)`}},
      { type:'section_header', data:{ title:'Editability Rules', anchor:'edit-rules', level:2 }},
      { type:'status_table', data:{ rows:[
        { code:'UPLOADED',  label:'Editable',   desc:'Add recipients, add fields, delete draft.' },
        { code:'PREPARED',  label:'Editable',   desc:'Add more recipients, add more fields, delete draft.' },
        { code:'PENDING',   label:'Locked',     desc:'Cannot add recipients or fields. Cannot delete.' },
        { code:'COMPLETED', label:'Read Only',  desc:'Download only. No further edits.' },
        { code:'VOIDED',    label:'Cancelled',  desc:'No actions available.' },
      ]}},
      { type:'section_header', data:{ title:'Signing Status vs Document Status', anchor:'dual-status', level:2 }},
      { type:'text', data:{ content:'The API returns two different status fields in list and status endpoints. They serve different purposes:' }},
      { type:'param_table', data:{ location:'Status Fields', params:[
        { name:'status',         type:'string', required:false, description:'The document\'s lifecycle state: UPLOADED, PREPARED, PENDING, COMPLETED, VOIDED.' },
        { name:'signing_status', type:'string', required:false, description:'The collective signing progress: pending, partially_signed, completed.' },
        { name:'is_fully_signed',type:'boolean',required:false, description:'Shorthand true when all recipients have completed. Equivalent to signing_status = completed.' },
      ]}},
    ]
  },

};

// ─────────────────────────────────────────────────
// STATE
// ─────────────────────────────────────────────────
let currentPage = 'introduction/overview';

// ─────────────────────────────────────────────────
// SIDEBAR
// ─────────────────────────────────────────────────
function renderSidebar() {
  document.getElementById('sidebar-nav').innerHTML = NAV_TREE.map(sec => `
    <div>
      <button onclick="toggleSection(${sec.id})"
              class="w-full flex items-center justify-start gap-2 px-3.5 py-[7px] text-left
                     hover:bg-slate-50 transition-colors bg-transparent border-0 cursor-pointer">
        <svg id="chev-${sec.id}"
             class="w-3 h-3 text-slate-400 transition-transform duration-200 shrink-0 ${sec.open?'rotate-90':''}"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <span class="text-[12.5px] font-semibold text-[#3f3f46] tracking-wide uppercase">${sec.title}</span>
      </button>
      <div id="sec-${sec.id}" class="${sec.open ? 'slide-open' : 'slide-close'}">
        ${sec.pages.map(pg => `
          <button onclick="navigate('${pg.section}/${pg.slug}', this)"
                  data-key="${pg.section}/${pg.slug}"
                  class="nav-item relative w-full text-left px-3.5 pl-8 py-[6px] text-[13px] text-[#4b5563]
                         hover:bg-slate-100 hover:text-slate-900 transition-colors bg-transparent border-0 cursor-pointer block">
            ${pg.title}
          </button>`).join('')}
      </div>
    </div>`).join('');
}

function toggleSection(id) {
  const el   = document.getElementById(`sec-${id}`);
  const chev = document.getElementById(`chev-${id}`);
  const open = el.classList.contains('slide-open');
  el.classList.toggle('slide-open',  !open);
  el.classList.toggle('slide-close',  open);
  chev.classList.toggle('rotate-90', !open);
}

// ─────────────────────────────────────────────────
// NAVIGATION
// ─────────────────────────────────────────────────
function navTo(key) {
  const btn = document.querySelector(`[data-key="${key}"]`);
  navigate(key, btn);
  // auto-open the parent section if collapsed
  if (btn) {
    const section = btn.closest('[id^="sec-"]');
    if (section && section.classList.contains('slide-close')) {
      const id = section.id.replace('sec-','');
      toggleSection(parseInt(id));
    }
  }
}

function navigate(key, btn) {
  document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('nav-active','font-semibold','text-[#2D74DE]'));
  // Always resolve the button — either the one clicked or found by data-key (handles direct/auto navigation)
  const target = btn || document.querySelector(`[data-key="${key}"]`);
  if (target) {
    target.classList.add('nav-active','font-semibold','text-[#2D74DE]');
    // Auto-open the parent section if it is currently collapsed
    const section = target.closest('[id^="sec-"]');
    if (section && section.classList.contains('slide-close')) {
      const secId = parseInt(section.id.replace('sec-', ''));
      toggleSection(secId);
    }
  }
  currentPage = key;
  renderPage(key);
  const parts = key.split('/');
  const section = parts[0].replace(/-/g,' ').replace(/\b\w/g, c=>c.toUpperCase());
  const page    = parts[1]?.replace(/-/g,' ').replace(/\b\w/g, c=>c.toUpperCase()) || '';
  document.getElementById('breadcrumb-text').textContent = `${section}  /  ${page}`;
  // Reset the main content scroll container to top on every navigation
  const mainEl = document.getElementById('main-content');
  if (mainEl) mainEl.scrollTop = 0;
}

// ─────────────────────────────────────────────────
// PAGE RENDERER
// ─────────────────────────────────────────────────
function renderPage(key) {
  const pg = PAGES[key];
  const el = document.getElementById('doc-content');
  const isOverview = key === 'introduction/overview';
  const isWide = isOverview || key === 'introduction/quick-start';
  if (isWide) {
    // Full bleed — no max-width cap; generous but responsive padding
    el.className = 'w-full px-6 sm:px-10 lg:px-14 py-10';
  } else {
    // Slightly narrower for dense API ref pages, but still wide
    el.className = 'w-full px-6 sm:px-10 lg:px-14 py-10 max-w-5xl';
  }
  if (!pg) {
    const label = key.split('/').pop().replace(/-/g,' ').replace(/\b\w/g,c=>c.toUpperCase());
    el.innerHTML = `
      <h1 class="text-[28px] font-bold text-[#FE9090] tracking-tight mb-6">${label}</h1>
      <hr class="border-t border-gray-200 mb-6">
      <p class="text-sm text-slate-400">Content coming soon.</p>`;
    return;
  }
  const titleHtml = isWide
    ? '' // wide pages use their own hero block heading
    : `<h1 class="text-[28px] font-bold text-[#FE9090] tracking-tight mb-2">${pg.title}</h1>`;
  const metaHtml = pg.meta
    ? (isWide
        ? '' // wide pages hero blocks contain their own description
        : `<p class="text-sm text-gray-500 leading-relaxed mb-6">${pg.meta}</p>`)
    : '';
  const divider = isWide ? '' : `<hr class="border-t border-gray-200 mb-6">`;
  el.innerHTML = [
    titleHtml,
    metaHtml,
    divider,
    ...pg.blocks.map(renderBlock)
  ].join('');
  if (window.Prism) Prism.highlightAll();
}

// ─────────────────────────────────────────────────
// BLOCK RENDERERS
// ─────────────────────────────────────────────────
function renderBlock(b) {
  const d = b.data

  if (b.type === 'text') return `
    <p class="text-sm text-gray-600 leading-[1.75] mb-3">${d.content}</p>`;

  if (b.type === 'section_header') {
    if (d.level === 3) return `
      <h3 id="${d.anchor}" class="text-sm font-semibold text-gray-800 mt-6 mb-2">${d.title}</h3>`;
    return `
      <h2 id="${d.anchor}" class="text-[17px] font-bold text-[#2D74DE] mt-10 mb-2">${d.title}</h2>
      <hr class="border-t border-slate-100 mb-5">`;
  }

  if (b.type === 'steps') {
    return `<ol class="space-y-4 mb-6">${(d.steps||[]).map(s=>`
      <li class="flex gap-4 items-start">
        <span class="flex-none w-7 h-7 rounded-full bg-[#4080E0] text-white text-xs font-bold flex items-center justify-center mt-0.5 shadow-sm">${s.n}</span>
        <div class="pt-0.5"><span class="text-[14px] font-semibold text-slate-800">${s.title}</span><span class="text-[14px] text-slate-500 ml-1.5">— ${s.desc}</span></div>
      </li>`).join('')}</ol>`;
  }

  if (b.type === 'onboarding_flow') {
    const cards = (d.steps||[]).map(s => {
      const btns = (s.actions||[]).map(a => a.primary
        ? `<a href="${a.href}" target="_blank"
              class="flex items-center justify-between gap-2 w-full bg-[#2D74DE] hover:bg-[#2060c4]
                     text-white text-[12.5px] font-semibold px-3.5 py-2.5 rounded-lg transition-colors no-underline">
             <span>${a.label}</span>
             <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
               <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
             </svg>
           </a>`
        : `<a href="${a.href}" target="_blank"
              class="flex items-center justify-between gap-2 w-full bg-white hover:bg-slate-50
                     text-slate-600 text-[12.5px] font-medium px-3.5 py-2.5 rounded-lg
                     border border-slate-200 transition-colors no-underline">
             <span>${a.label}</span>
             <svg class="w-3.5 h-3.5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
             </svg>
           </a>`
      ).join('');

      return `
        <div class="flex-1 min-w-0 bg-white border border-slate-200 rounded-xl p-4">
          <div class="flex items-center gap-2 mb-2">
            <span class="w-5 h-5 rounded-full bg-[#2D74DE] text-white text-[10px] font-bold flex items-center justify-center shrink-0">${s.n}</span>
            <span class="text-[12px] font-semibold text-slate-700">${s.title}</span>
          </div>
          ${s.desc ? `<p class="text-[11.5px] text-slate-400 leading-relaxed mb-3 mt-0">${s.desc}</p>` : ''}
          <div class="flex flex-col gap-2">${btns}</div>
        </div>`;
    }).join(`
        <div class="hidden lg:flex items-center justify-center w-5 shrink-0">
          <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
          </svg>
        </div>`);

    return `<div class="flex flex-col lg:flex-row lg:items-stretch gap-3 my-5">${cards}</div>`;
  }

  if (b.type === 'overview_hero') {
    const pills = (d.features||[]).map(f=>`
      <span class="inline-flex items-center gap-1.5 text-[12.5px] text-slate-600 bg-white border border-slate-200 rounded-full px-3.5 py-1.5 shadow-sm">
        <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        ${f}
      </span>`).join('');
    const btns = (d.actions||[]).map(a => a.primary
      ? `<a href="${a.href}" target="_blank"
            class="inline-flex items-center gap-2 bg-[#2D74DE] hover:bg-[#2060c4] text-white
                   text-[15px] font-semibold px-7 py-3.5 rounded-xl transition-colors no-underline shadow-md">
           ${a.label}
           <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
         </a>`
      : `<a href="${a.href}" target="_blank"
            class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700
                   text-[15px] font-medium px-7 py-3.5 rounded-xl border border-slate-200 transition-colors no-underline shadow-sm">
           ${a.label}
         </a>`
    ).join('');
    return `
      <div class="hero-two-col flex flex-col lg:flex-row items-center gap-10 lg:gap-16 py-8 mb-10">
        <!-- Left: text content -->
        <div class="flex-1 min-w-0">
          <h2 class="text-[32px] sm:text-[36px] font-extrabold text-slate-900 mb-5 leading-tight tracking-tight">
            Start building eSignature integrations
          </h2>
          <p class="text-[15.5px] text-slate-500 leading-relaxed mb-7">
            The AiSign REST API empowers you to embed document signing into any application.
            Upload documents, assign recipients, place signature fields, and track completion in real-time — all via HTTP.
          </p>
          <div class="flex flex-wrap gap-2.5 mb-8">${pills}</div>
          <div class="flex flex-wrap gap-3">${btns}</div>
        </div>
        <!-- Right: hero image with hover-lift effect -->
        <div class="hero-img-col flex-shrink-0 w-full lg:w-[46%]">
          <div class="img-lift-wrap rounded-2xl">
            <div class="img-lift-inner rounded-2xl border border-slate-200 bg-slate-800 overflow-hidden shadow-xl" style="aspect-ratio:16/10;">
              <img src="/images/homepage-photo-tablet-secure-otmz.png"
                   alt="AiSign API preview"
                   class="w-full h-full object-cover opacity-90"
                   onerror="this.parentElement.style.background='#1e293b'">
            </div>
          </div>
        </div>
      </div>`;
  }

  if (b.type === 'feature_cards') {
    /*
     * ICON IMAGE MAP — each key maps to a unique image path from your /images/ directory.
     * To use a custom image per card, add an `img` field to the item in the page data:
     *   { icon:'key', label:'...', img:'/images/my-custom.png', ... }
     * If `img` is omitted, the map below is used as a fallback per icon type.
     */
    const ICON_IMGS = {
      key:      '/images/documentation-key-icon.png',
      template: '/images/documentation-template-icon.png',
      doc:      '/images/documentation-documents-icon.png',
      webhook:  '/images/documentation-bell-icon.png',
      token:    '/images/documentation-lock-icon.png',
      log:      '/images/documentation-logs-icon.png',
    };
    /* Gradient accent per category — matches your site's color palette */
    const ICON_GRAD = {
      key:      'linear-gradient(135deg,rgba(64,128,224,0.18) 0%,rgba(45,116,222,0.35) 100%)',
      template: 'linear-gradient(135deg,rgba(124,58,237,0.18) 0%,rgba(109,40,217,0.35) 100%)',
      doc:      'linear-gradient(135deg,rgba(14,165,233,0.18) 0%,rgba(2,132,199,0.35) 100%)',
      webhook:  'linear-gradient(135deg,rgba(217,119,6,0.18) 0%,rgba(180,83,9,0.35) 100%)',
      token:    'linear-gradient(135deg,rgba(5,150,105,0.18) 0%,rgba(4,120,87,0.35) 100%)',
      log:      'linear-gradient(135deg,rgba(220,38,38,0.18) 0%,rgba(185,28,28,0.35) 100%)',
    };
    /* Fallback SVG paths per icon type */
    const SVG_PATH = {
      key:      'M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z',
      template: 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z',
      doc:      'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
      webhook:  'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
      token:    'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125',
      log:      'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z',
    };
    const ICON_COLOR = { key:'#4080E0', template:'#7C3AED', doc:'#0EA5E9', webhook:'#D97706', token:'#059669', log:'#DC2626' };

    const cards = (d.items||[]).map(it => {
      const imgSrc  = it.img || ICON_IMGS[it.icon] || '';
      const grad    = ICON_GRAD[it.icon] || ICON_GRAD.key;
      const svgPath = SVG_PATH[it.icon] || SVG_PATH.doc;
      const color   = ICON_COLOR[it.icon] || '#4080E0';
      /* Icon element: image if path given (and real file exists), else SVG fallback */
      const iconEl = `
        <div class="w-14 h-14 rounded-2xl mb-5 flex items-center justify-center flex-shrink-0 border border-white/60 shadow-sm bg-[linear-gradient(239deg,rgba(255,144,144,0.08)_0%,rgba(134,125,201,0.08)_42%,rgba(45,116,222,0.08)_100%)]" >
          <img src="${imgSrc}" alt="${it.label} icon"
               class="w-12 h-12 object-contain"
               onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        </div>`;
      return `
      <div onclick="navTo('${it.navKey}')"
           class="card-lift group flex flex-col bg-white border border-slate-200 rounded-2xl p-6 cursor-pointer
                  hover:border-[#4080E0] transition-all duration-200">
        ${iconEl}
        <h3 class="text-[15px] font-bold text-slate-900 mb-2 group-hover:text-[#2D74DE] transition-colors">${it.label}</h3>
        <p class="text-[13px] text-slate-500 leading-relaxed flex-1 m-0">${it.desc}</p>
        <div class="mt-5 flex items-center gap-1.5 text-[12.5px] font-semibold text-[#4080E0] opacity-0 group-hover:opacity-100 transition-opacity duration-150">
          Explore docs
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </div>
      </div>`;
    }).join('');
    return `<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 my-6">${cards}</div>`;
  }

  if (b.type === 'explore_grid') {
    /*
     * EXPLORE ICON IMAGE MAP — unique image per icon type.
     * Add an `img` field to any item in the page data to override per-item.
     * If the image file is missing, the SVG fallback renders automatically.
     */
    const EX_IMG = {
      auth:       '/images/documentation-key-icon.png',
      quickstart: '/images/documentation-guide-icon.png',
      template:   '/images/documentation-documents-icon.png',
      upload:     '/images/documentation-upload-icon.png',
      webhook:    '/images/documentation-bell-icon.png',
      error:      '/images/documentation-error-icon.png',
      status:     '/images/documentation-lifecycle-icon.png',
      limits:     '/images/documentation-lock-icon.png',
      download:   '/images/documentation-download-icon.png',
    };
    const EX_GRAD = {
      auth:       'linear-gradient(135deg,rgba(64,128,224,0.2) 0%,rgba(45,116,222,0.38) 100%)',
      quickstart: 'linear-gradient(135deg,rgba(234,88,12,0.2) 0%,rgba(194,65,12,0.38) 100%)',
      template:   'linear-gradient(135deg,rgba(124,58,237,0.2) 0%,rgba(109,40,217,0.38) 100%)',
      upload:     'linear-gradient(135deg,rgba(22,163,74,0.2) 0%,rgba(21,128,61,0.38) 100%)',
      webhook:    'linear-gradient(135deg,rgba(217,119,6,0.2) 0%,rgba(180,83,9,0.38) 100%)',
      error:      'linear-gradient(135deg,rgba(220,38,38,0.2) 0%,rgba(185,28,28,0.38) 100%)',
      status:     'linear-gradient(135deg,rgba(2,132,199,0.2) 0%,rgba(3,105,161,0.38) 100%)',
      limits:     'linear-gradient(135deg,rgba(124,58,237,0.2) 0%,rgba(109,40,217,0.38) 100%)',
      download:   'linear-gradient(135deg,rgba(5,150,105,0.2) 0%,rgba(4,120,87,0.38) 100%)',
    };
    const EX_SVG = {
      auth:       'M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z',
      quickstart: 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
      template:   'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z',
      upload:     'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5',
      webhook:    'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
      error:      'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
      status:     'M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5',
      limits:     'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
      download:   'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3',
    };
    const EX_COLOR = { auth:'#4080E0', quickstart:'#EA580C', template:'#7C3AED', upload:'#16A34A', webhook:'#D97706', error:'#DC2626', status:'#0284C7', limits:'#7C3AED', download:'#059669' };

    const items = (d.items||[]).map(it => {
      const imgSrc  = it.img || EX_IMG[it.icon] || '';
      const grad    = EX_GRAD[it.icon] || EX_GRAD.auth;
      const svgPath = EX_SVG[it.icon]  || EX_SVG.auth;
      const color   = EX_COLOR[it.icon] || '#4080E0';
      return `
      <div onclick="navTo('${it.navKey}')"
           class="group flex items-start gap-4 cursor-pointer p-4 rounded-xl
                  hover:bg-slate-50 border border-transparent hover:border-slate-200
                  transition-all duration-150">
        <!-- Dynamic icon image with SVG fallback -->
        <div class="w-11 h-11 rounded-xl flex-shrink-0 flex items-center justify-center border border-white/60 shadow-sm bg-[linear-gradient(239deg,rgba(255,144,144,0.08)_0%,rgba(134,125,201,0.08)_42%,rgba(45,116,222,0.08)_100%)]">
          <img src="${imgSrc}" alt="${it.label} icon"
               class="w-10 h-10 object-contain"
               onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
          
        </div>
        <div class="min-w-0 flex-1">
          <span class="block text-[14px] font-bold text-slate-900 group-hover:text-[#2D74DE] transition-colors mb-0.5">${it.label}</span>
          <p class="text-[13px] text-slate-500 leading-relaxed m-0">${it.desc}</p>
        </div>
        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#4080E0] flex-shrink-0 mt-0.5 opacity-0 group-hover:opacity-100 transition-all duration-150 -translate-x-1 group-hover:translate-x-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </div>`;
    }).join('');
    return `<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-1 my-4">${items}</div>`;
  }

  if (b.type === 'feature_list') {
    const icons = {
      template: `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>`,
      doc:      `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>`,
      token:    `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/></svg>`,
      log:      `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>`,
      webhook:  `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>`,
    };
    return `<div class="grid gap-2 my-4">${(d.items||[]).map(it=>`
      <div class="flex items-start gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
        <span class="text-[#4080E0] mt-0.5 shrink-0">${icons[it.icon]||icons.doc}</span>
        <div>
          <span class="text-sm font-semibold text-slate-800">${it.label}</span>
          <span class="text-sm text-slate-500 ml-1.5">— ${it.desc}</span>
        </div>
      </div>`).join('')}</div>`;
  }

  if (b.type === 'status_table') {
    const ICON_CHECK = `<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 border border-emerald-300 shrink-0">
      <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
      </svg></span>`;
    const ICON_X = `<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-100 border border-red-300 shrink-0">
      <svg class="w-3 h-3 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg></span>`;
    const ICON_LOCK = `<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-100 border border-slate-300 shrink-0">
      <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
      </svg></span>`;
    const ICON_BAN = `<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-orange-100 border border-orange-300 shrink-0">
      <svg class="w-3 h-3 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
      </svg></span>`;

    function renderCode(val) {
      const v = String(val).trim();
      if (v === '✅') return ICON_CHECK;
      if (v === '❌') return ICON_X;
      if (v === '🔒') return ICON_LOCK;
      if (v === '🚫') return ICON_BAN;
      return `<code class="font-mono text-[11.5px] font-semibold text-slate-700 bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded">${v}</code>`;
    }

    const LABEL_ICON = {
      'Editable':  `<span class="inline-flex items-center gap-1.5">${ICON_CHECK} <span class="text-emerald-700 font-semibold">Editable</span></span>`,
      'Locked':    `<span class="inline-flex items-center gap-1.5">${ICON_LOCK} <span class="text-slate-600 font-semibold">Locked</span></span>`,
      'Read Only': `<span class="inline-flex items-center gap-1.5">${ICON_LOCK} <span class="text-slate-600 font-semibold">Read Only</span></span>`,
      'Cancelled': `<span class="inline-flex items-center gap-1.5">${ICON_BAN} <span class="text-orange-700 font-semibold">Cancelled</span></span>`,
    };

    const rows = (d.rows||[]).map(r=>`
      <tr class="hover:bg-slate-50 border-b border-slate-100 last:border-0">
        <td class="px-3.5 py-2.5 align-middle w-[16%]">${renderCode(r.code)}</td>
        <td class="px-3.5 py-2.5 align-middle w-[30%] text-[12.5px] text-slate-700">${LABEL_ICON[r.label] || `<span class="font-medium">${r.label}</span>`}</td>
        <td class="px-3.5 py-2.5 align-top text-[13px] text-slate-500 leading-relaxed">${r.desc}</td>
      </tr>`).join('');
    return `
      <div class="rounded-xl border border-slate-200 overflow-hidden my-4 shadow-sm">
        <table class="w-full border-collapse">
          <tbody class="bg-white">${rows}</tbody>
        </table>
      </div>`;
  }

  if (b.type === 'endpoint') {
    const m = (d.method||'GET').toLowerCase();
    const barBg    = { get:'bg-green-50 border-green-200', post:'bg-blue-50 border-blue-200', put:'bg-amber-50 border-amber-200', delete:'bg-red-50 border-red-200' }[m] || 'bg-slate-50 border-slate-200';
    const badgeCls = { get:'text-emerald-800 bg-emerald-100 border-emerald-300', post:'text-blue-800 bg-blue-100 border-blue-300', put:'text-amber-800 bg-amber-100 border-amber-300', delete:'text-red-800 bg-red-100 border-red-300' }[m] || 'text-gray-800 bg-gray-100 border-gray-300';
    const dotCls   = { get:'bg-emerald-400', post:'bg-blue-400', put:'bg-amber-400', delete:'bg-red-400' }[m] || 'bg-gray-400';
    return `
      <div class="rounded-xl border border-gray-200 overflow-hidden my-6 bg-white shadow-sm">
        <div class="flex items-center gap-2.5 px-4 py-2.5 border-b flex-wrap ${barBg}">
          <span class="inline-flex items-center gap-1.5 font-mono text-[11px] font-bold tracking-wide px-2 py-[3px] rounded-md border ${badgeCls}">
            <span class="w-1.5 h-1.5 rounded-full ${dotCls}"></span>${d.method}
          </span>
          <code class="flex-1 font-mono text-[13px] font-medium text-slate-800">${d.url}</code>
          <div class="flex items-center gap-1.5 ml-auto">
            ${d.permission ? `
              <span class="inline-flex items-center gap-1 text-[10.5px] font-medium text-slate-500 bg-slate-100 border border-slate-200 rounded px-1.5 py-0.5">
                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                ${d.permission}
              </span>` : ''}
            ${d.consumesToken ? `
              <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded px-1.5 py-0.5">
                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75"/></svg>
                Consumes 1 Token
              </span>` : ''}
          </div>
        </div>
        ${d.description ? `<p class="px-4 py-2.5 text-[13px] text-slate-500 border-b border-slate-100 m-0">${d.description}</p>` : ''}
      </div>`;
  }

  if (b.type === 'code') {
    const dotColor = { bash:'#34d399', json:'#fbbf24', php:'#a78bfa', javascript:'#fbbf24', python:'#60a5fa' }[d.language] || '#94a3b8';
    const esc = (d.content||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    const cid = _reg(d.content||'');
    return `
      <div class="rounded-xl border border-slate-200 overflow-hidden my-3 bg-white">
        <div class="flex items-center justify-between bg-slate-50 border-b border-slate-200 px-3.5 py-1.5">
          <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full" style="background:${dotColor}"></span>
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">${d.label||d.language.toUpperCase()}</span>
          </div>
          <button onclick="doCopy(this,'${cid}')"
                  class="flex items-center gap-1 text-[11px] text-slate-400 hover:text-slate-700 hover:bg-slate-100 bg-transparent border-0 cursor-pointer px-2 py-1 rounded transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
            Copy
          </button>
        </div>
        <div class="overflow-x-auto bg-slate-50"><pre><code class="language-${d.language}">${esc}</code></pre></div>
      </div>`;
  }

  if (b.type === 'response') {
    const s   = d.status || 200;
    const ok  = s >= 200 && s < 300;
    const esc  = (d.content||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    const cid  = _reg(d.content||'');
    const wBorder  = ok ? 'border-green-200'              : 'border-red-200';
    const hBg      = ok ? 'bg-green-50 border-green-200'  : 'bg-red-50 border-red-200';
    const badgeCls = ok ? 'bg-green-100 text-green-800'   : 'bg-red-100 text-red-800';
    const labelCls = ok ? 'text-green-800'                : 'text-red-800';
    return `
      <div class="rounded-xl border overflow-hidden my-3 ${wBorder}">
        <div class="flex items-center justify-between px-3.5 py-1.5 border-b ${hBg}">
          <div class="flex items-center gap-2">
            <span class="font-mono text-[11px] font-bold px-1.5 py-0.5 rounded ${badgeCls}">${s}</span>
            <span class="text-xs font-semibold ${labelCls}">${d.label||''}</span>
          </div>
          <button onclick="doCopy(this,'${cid}')"
                  class="flex items-center gap-1 text-[11px] text-slate-400 hover:text-slate-700 bg-transparent border-0 cursor-pointer px-2 py-1 rounded hover:bg-white/60 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
            Copy
          </button>
        </div>
        <div class="overflow-x-auto bg-slate-50"><pre><code class="language-json">${esc}</code></pre></div>
      </div>`;
  }

  if (b.type === 'note') {
    const v   = d.variant || 'info';
    const cfg = {
      info:    { wrap:'bg-blue-50 border-blue-200',   icon:'text-blue-500',   title:'text-blue-800',   body:'text-blue-800',   label:'Note'      },
      warning: { wrap:'bg-amber-50 border-amber-200', icon:'text-amber-500',  title:'text-amber-800',  body:'text-amber-700',  label:'Warning'   },
      danger:  { wrap:'bg-red-50 border-red-200',     icon:'text-red-500',    title:'text-red-800',    body:'text-red-700',    label:'Important' },
      success: { wrap:'bg-green-50 border-green-200', icon:'text-green-500',  title:'text-green-800',  body:'text-green-700',  label:'Tip'       },
    }[v] || { wrap:'bg-blue-50 border-blue-200', icon:'text-blue-500', title:'text-blue-800', body:'text-blue-800', label:'Note' };
    const icons = {
      info:    `<svg class="w-4 h-4 shrink-0 mt-0.5 ${cfg.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>`,
      warning: `<svg class="w-4 h-4 shrink-0 mt-0.5 ${cfg.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>`,
      danger:  `<svg class="w-4 h-4 shrink-0 mt-0.5 ${cfg.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>`,
      success: `<svg class="w-4 h-4 shrink-0 mt-0.5 ${cfg.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    };
    return `
      <div class="flex gap-2.5 border rounded-xl px-3.5 py-3 my-3 ${cfg.wrap}">
        ${icons[v]||icons.info}
        <div>
          <p class="text-[10.5px] font-bold uppercase tracking-widest mb-0.5 ${cfg.title}">${cfg.label}</p>
          <p class="text-[13px] leading-relaxed m-0 ${cfg.body}">${d.content||''}</p>
        </div>
      </div>`;
  }

  if (b.type === 'token_note') return `
    <div class="flex gap-2.5 items-start bg-amber-50 border border-amber-200 rounded-xl px-3.5 py-3 my-3">
      <svg class="w-[18px] h-[18px] text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75"/></svg>
      <div>
        <p class="text-[10.5px] font-bold uppercase tracking-widest text-amber-800 mb-0.5">Consumes 1 API Token</p>
        <p class="text-[13px] text-amber-700 m-0">${d.content||'This endpoint consumes one API token per activation.'}</p>
      </div>
    </div>`;

  if (b.type === 'param_table') {
    const rows = (d.params||[]).map(p => `
      <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100 last:border-0">
        <td class="px-3.5 py-2 align-top">
          <code class="font-mono text-[11px] text-[#3277DF] bg-[#4080E00F] border border-indigo-100 px-1.5 py-0.5 rounded">${p.name}</code>
        </td>
        <td class="px-3.5 py-2 align-top">
          <span class="font-mono text-[11px] text-gray-500">${p.type||'—'}</span>
        </td>
        <td class="px-3.5 py-2 align-top">
          ${p.required
            ? `<span class="text-[10px] font-semibold text-red-600 bg-red-50 border border-red-200 px-1.5 py-0.5 rounded">required</span>`
            : `<span class="text-[11px] text-slate-400">optional</span>`}
        </td>
        <td class="px-3.5 py-2 align-top text-[13px] text-gray-600 leading-relaxed">
          ${p.description||''}
          ${p.default ? `<br><span class="text-[11px] text-slate-400">Default: <code class="font-mono text-slate-500">${p.default}</code></span>` : ''}
          ${p.enum    ? `<br><span class="text-[11px] text-slate-400">Values: ${p.enum.map(v=>`<code class="font-mono text-slate-500">${v}</code>`).join(', ')}</span>` : ''}
        </td>
      </tr>`).join('');
    return `
      <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-slate-400 mt-5 mb-1.5">
        ${d.location||'Body'} Parameters
        <div class="flex-1 h-px bg-slate-100"></div>
      </div>
      <div class="rounded-xl border border-slate-200 overflow-hidden mb-5 shadow-sm">
        <table class="w-full border-collapse">
          <thead class="bg-slate-50">
            <tr>
              <th class="text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600 px-3.5 py-2 border-b border-slate-200 w-1/4">Field</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600 px-3.5 py-2 border-b border-slate-200 w-[13%]">Type</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600 px-3.5 py-2 border-b border-slate-200 w-[13%]">Required</th>
              <th class="text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600 px-3.5 py-2 border-b border-slate-200">Description</th>
            </tr>
          </thead>
          <tbody class="bg-white">${rows}</tbody>
        </table>
      </div>`;
  }

  if (b.type === 'cta_button') return `
    <div class="my-4">
      <button class="flex items-center justify-center w-full max-w-[480px] bg-[#4080E0] hover:bg-[#2763bd]
                     text-white font-semibold text-sm rounded-lg py-3 px-6 transition-colors cursor-pointer border-0">
        ${d.label||'Learn More'}
      </button>
    </div>`;

  /* ── Quick-Start: intro hero ───────────────────────────────────────── */
  if (b.type === 'qs_hero') {
    return `
      <div class="mb-10 pb-8 border-b border-slate-100">
        <h2 class="text-[30px] sm:text-[34px] font-extrabold text-slate-900 mb-4 tracking-tight leading-tight">${d.title||'Get started with the AiSign API'}</h2>
        <p class="text-[15.5px] text-slate-500 leading-relaxed max-w-[680px]">${d.desc||''}</p>
      </div>`;
  }

  /* ── Quick-Start: numbered setup step (with optional screenshot) ────── */
  if (b.type === 'qs_setup_step') {
    const imgBlock = d.image ? `
      <div class="img-lift-wrap rounded-xl mt-6">
        <div class="img-lift-inner rounded-xl border border-slate-200 overflow-hidden shadow-md bg-slate-50 w-full" style="aspect-ratio:16/7;">
          <img src="${d.image}"
               alt="${d.title||''} screenshot"
               class="w-full h-full object-cover"
               onerror="this.parentElement.parentElement.style.display='none'">
        </div>
      </div>` : '';
    const noteBlock = d.note ? `
      <div class="mt-4 flex gap-3 items-start bg-blue-50 border border-blue-200 rounded-xl px-4 py-3.5">
        <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
        </svg>
        <p class="text-[13.5px] text-blue-800 m-0 leading-relaxed">${d.note}</p>
      </div>` : '';
    return `
      <div class="mb-10">
        <h3 class="text-[20px] font-bold text-slate-900 mb-2.5">${d.title||''}</h3>
        <p class="text-[14.5px] text-slate-600 leading-relaxed mb-3">${d.content||''}</p>
        ${noteBlock}${imgBlock}
      </div>`;
  }

  /* ── Quick-Start: API calling step with code block (NO screenshots) ── */
  if (b.type === 'qs_api_step') {
    const bulletList = (d.bullets||[]).map(bl=>`
      <li class="flex items-start gap-2 text-[14px] text-slate-600 leading-relaxed">
        <span class="mt-[7px] w-1.5 h-1.5 rounded-full bg-[#4080E0] flex-shrink-0"></span>
        <span>${bl}</span>
      </li>`).join('');
    const codeId = d.code ? _reg(d.code) : '';
    const codeHtml = d.code ? `
      <div class="mt-5 rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="flex items-center justify-between bg-slate-800 px-4 py-2.5">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-400"></span>
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span class="ml-2 text-[11px] font-mono font-semibold text-slate-400 uppercase tracking-widest">${d.codeLabel||'cURL'}</span>
          </div>
          <button onclick="doCopy(this,'${codeId}')" class="flex items-center gap-1.5 text-[11px] text-slate-400 hover:text-white transition-colors bg-transparent border-0 cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
            Copy
          </button>
        </div>
        <pre class="!bg-slate-900 !m-0 !rounded-none overflow-x-auto px-5 py-4"><code class="language-bash text-[12.5px] leading-relaxed">${d.code.replace(/</g,'&lt;').replace(/>/g,'&gt;')}</code></pre>
      </div>` : '';
    return `
      <div class="mb-10">
        <h3 class="text-[20px] font-bold text-slate-900 mb-3">${d.title||''}</h3>
        ${d.content ? `<p class="text-[14.5px] text-slate-600 leading-relaxed mb-3">${d.content}</p>` : ''}
        ${bulletList ? `<ul class="space-y-2 mb-4 list-none m-0 p-0">${bulletList}</ul>` : ''}
        ${codeHtml}
      </div>`;
  }

  /* ── Quick-Start: explore advanced workflows ────────────────────────── */
  if (b.type === 'qs_explore') {
    const links = (d.links||[]).map(l=>`
      <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-[#4080E0] hover:bg-blue-50/30 transition-all duration-150 cursor-pointer"
           onclick="navTo('${l.navKey}')">
        <svg class="w-4 h-4 mt-0.5 text-[#4080E0] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
        <div>
          <span class="font-semibold text-[#2D74DE] text-[14px]">${l.label}</span>
          <span class="text-slate-600 text-[14px]"> — ${l.desc}</span>
        </div>
      </div>`).join('');
    return `
      <div class="mb-10">
        <h3 class="text-[20px] font-bold text-slate-900 mb-2">Explore advanced workflows</h3>
        <p class="text-[14.5px] text-slate-600 mb-5">Now that you've sent your first request, explore more complex scenarios:</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">${links}</div>
      </div>`;
  }

  /* ── Quick-Start: go live box ──────────────────────────────────────── */
  if (b.type === 'qs_go_live') {
    return `
      <div class="mb-8 p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-slate-50 border border-blue-100">
        <h3 class="text-[18px] font-bold text-slate-900 mb-2">Go Live</h3>
        <p class="text-[14.5px] text-slate-600 leading-relaxed m-0">${d.content||''}</p>
      </div>`;
  }

  return '';
}

// ─────────────────────────────────────────────────
// COPY REGISTRY  (avoids escaping bugs in onclick)
// ─────────────────────────────────────────────────
const copyRegistry = {};
let _copySeq = 0;

function _reg(text) {
  const id = 'cp_' + (_copySeq++);
  copyRegistry[id] = text;
  return id;
}

function doCopy(btn, id) {
  const text = copyRegistry[id] ?? id;
  if (!navigator.clipboard) {
    // Fallback for non-HTTPS / older browsers
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); } catch(e) {}
    document.body.removeChild(ta);
    _flashCopied(btn);
    return;
  }
  navigator.clipboard.writeText(text).then(() => _flashCopied(btn)).catch(err => {
    console.warn('Clipboard write failed:', err);
  });
}

function _flashCopied(btn) {
  const orig = btn.innerHTML;
  btn.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg><span class="text-emerald-500 font-medium">Copied!</span>`;
  setTimeout(() => { btn.innerHTML = orig; }, 2000);
}

// ─────────────────────────────────────────────────
// INIT
// ─────────────────────────────────────────────────
renderSidebar();
// Use navigate() for the initial load so the active button is highlighted from the start
navigate(currentPage);
window.addEventListener('load', () => { if (window.Prism) Prism.highlightAll(); });


</script>
</body>
</html>