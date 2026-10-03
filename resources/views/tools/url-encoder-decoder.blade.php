<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="encodeUrl()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            Encode URL
        </button>
        <button type="button" class="btn btn-secondary" onclick="decodeUrl()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
            Decode URL
        </button>
        <div style="display: flex; align-items: center; gap: 0.4rem;">
            <label for="mode-select" style="font-size: 0.82rem; color: var(--text-muted);">Mode:</label>
            <select id="mode-select" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.85rem;">
                <option value="component" selected>encodeURIComponent (All query characters)</option>
                <option value="uri">encodeURI (Preserve protocol/domain/path)</option>
            </select>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyResult()">Copy Result</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearAll()">Clear</button>
    </div>

    <div class="dual-editor-grid">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="url-input">
                <span>Input URL / Text</span>
                <span class="form-hint" id="in-stats">0 chars</span>
            </label>
            <textarea id="url-input" class="code-editor" placeholder="Enter URL or text query parameter to encode or decode..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="url-output">
                <span>Output Result</span>
                <span class="form-hint" id="out-stats">0 chars</span>
            </label>
            <textarea id="url-output" class="code-editor" placeholder="Processed URL result will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    <div id="status-message" style="display: none;"></div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('url-input');
        const outputEl = document.getElementById('url-output');
        const statusEl = document.getElementById('status-message');
        const modeSelect = document.getElementById('mode-select');
        const inStats = document.getElementById('in-stats');
        const outStats = document.getElementById('out-stats');

        inputEl.addEventListener('input', () => {
            inStats.textContent = `${inputEl.value.length} chars`;
        });

        function showStatus(msg, type = 'info') {
            statusEl.className = `status-box ${type}`;
            statusEl.style.display = 'flex';
            statusEl.innerHTML = msg;
        }

        function hideStatus() {
            statusEl.style.display = 'none';
        }

        function encodeUrl() {
            hideStatus();
            const val = inputEl.value;
            if (!val) {
                showStatus('Please provide a URL or query string to encode.', 'error');
                return;
            }

            try {
                const encoded = modeSelect.value === 'component' ? encodeURIComponent(val) : encodeURI(val);
                outputEl.value = encoded;
                outStats.textContent = `${encoded.length} chars`;
                showStatus(`Encoded successfully using <strong>${modeSelect.value === 'component' ? 'encodeURIComponent' : 'encodeURI'}</strong>.`, 'success');
            } catch (err) {
                showStatus(`Encoding failed: ${err.message}`, 'error');
            }
        }

        function decodeUrl() {
            hideStatus();
            const val = inputEl.value;
            if (!val) {
                showStatus('Please provide an encoded URL to decode.', 'error');
                return;
            }

            try {
                const decoded = modeSelect.value === 'component' ? decodeURIComponent(val) : decodeURI(val);
                outputEl.value = decoded;
                outStats.textContent = `${decoded.length} chars`;
                showStatus('Decoded successfully.', 'success');
            } catch (err) {
                showStatus(`Malformed URI sequence: ${err.message}`, 'error');
            }
        }

        function loadSample() {
            inputEl.value = 'https://tools.faruk.stsoft.top/search?q=laravel 12 & privacy=100% & tag=ডেভেলপার টুলস';
            inStats.textContent = `${inputEl.value.length} chars`;
            encodeUrl();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'Result copied to clipboard!');
        }

        function clearAll() {
            inputEl.value = '';
            outputEl.value = '';
            inStats.textContent = '0 chars';
            outStats.textContent = '0 chars';
            hideStatus();
            showToast('Cleared');
        }
    </script>
    @endpush
</x-tool-layout>
