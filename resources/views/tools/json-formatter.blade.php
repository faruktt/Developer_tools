<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="formatJson()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Format JSON
        </button>
        <button type="button" class="btn btn-secondary" onclick="minifyJson()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            Minify JSON
        </button>
        <button type="button" class="btn btn-secondary" onclick="validateOnly()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Validate
        </button>
        <div style="display: flex; align-items: center; gap: 0.4rem; margin-left: auto;">
            <label for="indent-select" style="font-size: 0.82rem; color: var(--text-muted);">Indent:</label>
            <select id="indent-select" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.85rem;">
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
            <label class="form-label" for="json-input">
                <span>Input JSON</span>
                <span class="form-hint" id="input-stats">0 chars</span>
            </label>
            <textarea id="json-input" class="code-editor" placeholder="Paste your raw or unformatted JSON here..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="json-output">
                <span>Formatted Output</span>
                <span class="form-hint" id="output-stats">0 chars</span>
            </label>
            <textarea id="json-output" class="code-editor" placeholder="Formatted result will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    <div id="status-message" style="display: none;"></div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('json-input');
        const outputEl = document.getElementById('json-output');
        const statusEl = document.getElementById('status-message');
        const indentSelect = document.getElementById('indent-select');
        const inputStats = document.getElementById('input-stats');
        const outputStats = document.getElementById('output-stats');

        inputEl.addEventListener('input', () => {
            inputStats.textContent = `${inputEl.value.length} chars`;
        });

        function showStatus(msg, type = 'info') {
            statusEl.className = `status-box ${type}`;
            statusEl.style.display = 'flex';
            statusEl.innerHTML = msg;
        }

        function hideStatus() {
            statusEl.style.display = 'none';
        }

        function getIndent() {
            const val = indentSelect.value;
            if (val === 'tab') return '\t';
            return parseInt(val, 10) || 2;
        }

        function formatJson() {
            hideStatus();
            const raw = inputEl.value.trim();
            if (!raw) {
                showStatus('Please enter some JSON to format.', 'error');
                return;
            }

            try {
                const parsed = JSON.parse(raw);
                const formatted = JSON.stringify(parsed, null, getIndent());
                outputEl.value = formatted;
                outputStats.textContent = `${formatted.length} chars`;
                showStatus('JSON is valid and formatted successfully.', 'success');
            } catch (err) {
                outputEl.value = '';
                outputStats.textContent = '0 chars';
                showStatus(`<strong>Invalid JSON:</strong> ${err.message}`, 'error');
            }
        }

        function minifyJson() {
            hideStatus();
            const raw = inputEl.value.trim();
            if (!raw) {
                showStatus('Please enter some JSON to minify.', 'error');
                return;
            }

            try {
                const parsed = JSON.parse(raw);
                const minified = JSON.stringify(parsed);
                outputEl.value = minified;
                outputStats.textContent = `${minified.length} chars`;
                showStatus('JSON successfully minified.', 'success');
            } catch (err) {
                outputEl.value = '';
                showStatus(`<strong>Invalid JSON:</strong> ${err.message}`, 'error');
            }
        }

        function validateOnly() {
            hideStatus();
            const raw = inputEl.value.trim();
            if (!raw) {
                showStatus('Please enter JSON data to validate.', 'error');
                return;
            }

            try {
                JSON.parse(raw);
                showStatus('<strong>Valid JSON!</strong> The syntax conforms to standard JSON specifications.', 'success');
            } catch (err) {
                showStatus(`<strong>Invalid JSON:</strong> ${err.message}`, 'error');
            }
        }

        function loadSample() {
            inputEl.value = JSON.stringify({
                app: "Faruk Tools",
                developer: "Md. Faruk Hossain",
                role: "PHP Laravel Developer",
                country: "Bangladesh",
                features: ["Zero-server tracking", "High Performance", "Browser-first"],
                stats: { toolsCount: 17, privacyScore: 100 }
            });
            inputStats.textContent = `${inputEl.value.length} chars`;
            formatJson();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy yet. Format your JSON first.', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'Formatted JSON copied!');
        }

        function clearAll() {
            inputEl.value = '';
            outputEl.value = '';
            inputStats.textContent = '0 chars';
            outputStats.textContent = '0 chars';
            hideStatus();
            showToast('Cleared');
        }
    </script>
    @endpush
</x-tool-layout>
