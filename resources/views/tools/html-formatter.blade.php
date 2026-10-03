<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="formatHtml()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            Format HTML
        </button>
        <button type="button" class="btn btn-secondary" onclick="minifyHtml()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            Minify HTML
        </button>
        <div style="display: flex; align-items: center; gap: 0.4rem;">
            <label for="indent-val" style="font-size: 0.82rem; color: var(--text-muted);">Indent:</label>
            <select id="indent-val" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.85rem;">
                <option value="2" selected>2 Spaces</option>
                <option value="4">4 Spaces</option>
                <option value="tab">Tab</option>
            </select>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyResult()">Copy Result</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearAll()">Clear</button>
    </div>

    <div class="dual-editor-grid">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="html-input">
                <span>Input HTML</span>
                <span class="form-hint" id="in-stats">0 chars</span>
            </label>
            <textarea id="html-input" class="code-editor" placeholder="Paste your HTML markup here..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="html-output">
                <span>Output HTML</span>
                <span class="form-hint" id="out-stats">0 chars</span>
            </label>
            <textarea id="html-output" class="code-editor" placeholder="Formatted or minified HTML will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('html-input');
        const outputEl = document.getElementById('html-output');
        const inStats = document.getElementById('in-stats');
        const outStats = document.getElementById('out-stats');
        const indentSelect = document.getElementById('indent-val');

        inputEl.addEventListener('input', () => {
            inStats.textContent = `${inputEl.value.length} chars`;
        });

        function getIndentStr() {
            if (indentSelect.value === 'tab') return '\t';
            const count = parseInt(indentSelect.value, 10) || 2;
            return ' '.repeat(count);
        }

        function formatHtml() {
            const raw = inputEl.value.trim();
            if (!raw) {
                showToast('Please enter some HTML code', 'error');
                return;
            }

            const indentUnit = getIndentStr();
            let formatted = '';
            let indentLevel = 0;

            // Normalize newlines and basic tag tokens
            const tokens = raw
                .replace(/>\s*</g, '><')
                .replace(/</g, '~::~<')
                .replace(/>/g, '>~::~')
                .split('~::~')
                .filter(t => t.trim().length > 0);

            const selfClosingTags = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr', '!doctype'];

            tokens.forEach(token => {
                const trimmed = token.trim();
                if (!trimmed) return;

                const isClosing = /^<\//.test(trimmed);
                const isOpening = /^<[^\/!][^>]*>$/.test(trimmed) || /^<!/.test(trimmed);
                const isSelfClosing = /\/>$/.test(trimmed) || selfClosingTags.some(tag => new RegExp(`^<${tag}\\b`, 'i').test(trimmed));

                if (isClosing) {
                    indentLevel = Math.max(0, indentLevel - 1);
                }

                if (trimmed.startsWith('<')) {
                    formatted += (formatted ? '\n' : '') + indentUnit.repeat(indentLevel) + trimmed;
                } else {
                    formatted += trimmed;
                }

                if (isOpening && !isSelfClosing && !isClosing) {
                    indentLevel++;
                }
            });

            outputEl.value = formatted;
            outStats.textContent = `${formatted.length} chars`;
            showToast('HTML formatted successfully!', 'success');
        }

        function minifyHtml() {
            const raw = inputEl.value.trim();
            if (!raw) {
                showToast('Please enter some HTML code', 'error');
                return;
            }

            const minified = raw
                .replace(/<!--[\s\S]*?-->/g, '') // remove comments
                .replace(/>\s+</g, '><')         // remove whitespace between tags
                .replace(/\s{2,}/g, ' ')         // collapse multiple whitespaces
                .trim();

            outputEl.value = minified;
            outStats.textContent = `${minified.length} chars`;
            showToast('HTML minified!', 'success');
        }

        function loadSample() {
            inputEl.value = '<div class="card"><div class="card-header"><h1>Faruk Tools</h1></div><div class="card-body"><p>Developer utilities for everyone.</p><a href="https://faruk.stsoft.top" class="btn">Portfolio</a></div></div>';
            inStats.textContent = `${inputEl.value.length} chars`;
            formatHtml();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'HTML output copied!');
        }

        function clearAll() {
            inputEl.value = '';
            outputEl.value = '';
            inStats.textContent = '0 chars';
            outStats.textContent = '0 chars';
            showToast('Cleared');
        }
    </script>
    @endpush
</x-tool-layout>
