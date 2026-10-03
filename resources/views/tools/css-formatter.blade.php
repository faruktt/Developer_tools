<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="formatCss()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 5 5 0 015-5c1.105 0 2-.895 2-2 0-.53.2-1.03.586-1.414A5 5 0 1119 14.5a2.5 2.5 0 01-2.5 2.5H15a2 2 0 00-2 2v2z"/></svg>
            Format CSS
        </button>
        <button type="button" class="btn btn-secondary" onclick="minifyCss()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            Minify CSS
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
            <label class="form-label" for="css-input">
                <span>Input CSS</span>
                <span class="form-hint" id="in-stats">0 chars</span>
            </label>
            <textarea id="css-input" class="code-editor" placeholder="Paste your raw or unformatted CSS here..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="css-output">
                <span>Output CSS</span>
                <span class="form-hint" id="out-stats">0 chars</span>
            </label>
            <textarea id="css-output" class="code-editor" placeholder="Formatted or minified CSS will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('css-input');
        const outputEl = document.getElementById('css-output');
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

        function formatCss() {
            const raw = inputEl.value.trim();
            if (!raw) {
                showToast('Please enter CSS to format', 'error');
                return;
            }

            const indent = getIndentStr();
            let res = raw
                .replace(/\s+/g, ' ')
                .replace(/{\s*/g, ' {\n')
                .replace(/;\s*/g, ';\n')
                .replace(/,\s*/g, ', ')
                .replace(/:\s*/g, ': ')
                .replace(/\s*}\s*/g, '\n}\n\n')
                .replace(/[\n\r]+/g, '\n');

            const lines = res.split('\n');
            let indentLevel = 0;
            let formatted = '';

            lines.forEach(line => {
                let trimmed = line.trim();
                if (!trimmed) return;

                if (trimmed.includes('}')) {
                    indentLevel = Math.max(0, indentLevel - 1);
                }

                formatted += indent.repeat(indentLevel) + trimmed + '\n';

                if (trimmed.includes('{')) {
                    indentLevel++;
                }
                if (trimmed === '}') {
                    formatted += '\n'; // Add breathing space between CSS rules
                }
            });

            outputEl.value = formatted.trim();
            outStats.textContent = `${outputEl.value.length} chars`;
            showToast('CSS formatted successfully!', 'success');
        }

        function minifyCss() {
            const raw = inputEl.value.trim();
            if (!raw) {
                showToast('Please enter CSS to minify', 'error');
                return;
            }

            const minified = raw
                .replace(/\/\*[\s\S]*?\*\//g, '') // remove comments
                .replace(/\s+/g, ' ')             // collapse spaces
                .replace(/\s*{\s*/g, '{')
                .replace(/\s*}\s*/g, '}')
                .replace(/\s*:\s*/g, ':')
                .replace(/\s*;\s*/g, ';')
                .replace(/;}/g, '}')              // remove trailing semicolons
                .trim();

            outputEl.value = minified;
            outStats.textContent = `${minified.length} chars`;
            showToast('CSS minified!', 'success');
        }

        function loadSample() {
            inputEl.value = '.btn{background-color:#3b82f6;color:#ffffff;padding:8px 16px;border-radius:6px;font-weight:600;display:inline-flex;align-items:center;transition:background-color .2s ease}.btn:hover{background-color:#2563eb}';
            inStats.textContent = `${inputEl.value.length} chars`;
            formatCss();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'CSS output copied!');
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
