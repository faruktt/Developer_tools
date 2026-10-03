<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="encodeBase64()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Encode to Base64
        </button>
        <button type="button" class="btn btn-secondary" onclick="decodeBase64()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"/></svg>
            Decode from Base64
        </button>
        <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="url-safe-check"> URL-Safe Base64 (-, _)
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyResult()">Copy Result</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearAll()">Clear</button>
    </div>

    <div class="dual-editor-grid">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="base64-input">
                <span>Input String</span>
                <span class="form-hint" id="input-stats">0 chars</span>
            </label>
            <textarea id="base64-input" class="code-editor" placeholder="Enter text to encode or Base64 string to decode..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="base64-output">
                <span>Output Result</span>
                <span class="form-hint" id="output-stats">0 chars</span>
            </label>
            <textarea id="base64-output" class="code-editor" placeholder="Result will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    <div id="status-message" style="display: none;"></div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('base64-input');
        const outputEl = document.getElementById('base64-output');
        const statusEl = document.getElementById('status-message');
        const urlSafeCheck = document.getElementById('url-safe-check');
        const inStats = document.getElementById('input-stats');
        const outStats = document.getElementById('output-stats');

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

        // Full UTF-8 Base64 Encoding
        function utf8ToBase64(str) {
            const encoder = new TextEncoder();
            const bytes = encoder.encode(str);
            let binary = '';
            for (let i = 0; i < bytes.byteLength; i++) {
                binary += String.fromCharCode(bytes[i]);
            }
            let b64 = btoa(binary);
            if (urlSafeCheck.checked) {
                b64 = b64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
            }
            return b64;
        }

        // Full UTF-8 Base64 Decoding
        function base64ToUtf8(str) {
            let clean = str.trim();
            if (urlSafeCheck.checked || clean.includes('-') || clean.includes('_')) {
                clean = clean.replace(/-/g, '+').replace(/_/g, '/');
                while (clean.length % 4) {
                    clean += '=';
                }
            }
            const binary = atob(clean);
            const bytes = new Uint8Array(binary.length);
            for (let i = 0; i < binary.length; i++) {
                bytes[i] = binary.charCodeAt(i);
            }
            const decoder = new TextDecoder();
            return decoder.decode(bytes);
        }

        function encodeBase64() {
            hideStatus();
            const text = inputEl.value;
            if (!text) {
                showStatus('Please enter text to encode.', 'error');
                return;
            }

            try {
                const encoded = utf8ToBase64(text);
                outputEl.value = encoded;
                outStats.textContent = `${encoded.length} chars`;
                showStatus('Text successfully encoded to Base64 with UTF-8 preservation.', 'success');
            } catch (err) {
                outputEl.value = '';
                showStatus(`Encoding failed: ${err.message}`, 'error');
            }
        }

        function decodeBase64() {
            hideStatus();
            const text = inputEl.value.trim();
            if (!text) {
                showStatus('Please enter Base64 to decode.', 'error');
                return;
            }

            try {
                const decoded = base64ToUtf8(text);
                outputEl.value = decoded;
                outStats.textContent = `${decoded.length} chars`;
                showStatus('Base64 string successfully decoded to UTF-8 text.', 'success');
            } catch (err) {
                outputEl.value = '';
                showStatus(`Invalid Base64 string: ${err.message}`, 'error');
            }
        }

        function loadSample() {
            inputEl.value = 'Hello World! স্বাগতম Faruk Tools 🚀 (UTF-8 Developer Utility)';
            inStats.textContent = `${inputEl.value.length} chars`;
            encodeBase64();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'Output copied!');
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
