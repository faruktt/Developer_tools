<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="validateJson()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Validate JSON
        </button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadValidSample()">Sample Valid</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadInvalidSample()">Sample Invalid</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyInput()">Copy</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearValidator()">Clear</button>
    </div>

    <div class="form-group">
        <label class="form-label" for="validator-input">
            <span>JSON Payload</span>
            <span class="form-hint" id="val-stats">0 characters &bull; 0 lines</span>
        </label>
        <textarea id="validator-input" class="code-editor" style="min-height: 280px;" placeholder="Paste JSON text here to inspect and validate syntax..." spellcheck="false"></textarea>
    </div>

    <div id="validation-result" style="display: none;"></div>

    <div id="error-details" style="display: none; margin-top: 1rem; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem;">
        <h4 style="font-size: 0.95rem; font-weight: 700; color: #f43f5e; margin-bottom: 0.5rem;">Syntax Error Analysis</h4>
        <p id="error-description" style="font-family: var(--font-mono); font-size: 0.88rem; color: var(--text-main); margin-bottom: 0.5rem;"></p>
        <div id="error-snippet" style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm); font-family: var(--font-mono); font-size: 0.85rem; color: #fb7185; white-space: pre-wrap; word-break: break-all;"></div>
    </div>

    @push('scripts')
    <script>
        const valInput = document.getElementById('validator-input');
        const valResult = document.getElementById('validation-result');
        const valStats = document.getElementById('val-stats');
        const errDetails = document.getElementById('error-details');
        const errDesc = document.getElementById('error-description');
        const errSnippet = document.getElementById('error-snippet');

        valInput.addEventListener('input', () => {
            const lines = valInput.value ? valInput.value.split('\n').length : 0;
            valStats.textContent = `${valInput.value.length} characters • ${lines} lines`;
        });

        function validateJson() {
            const raw = valInput.value.trim();
            errDetails.style.display = 'none';

            if (!raw) {
                valResult.className = 'status-box error';
                valResult.style.display = 'flex';
                valResult.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> <span>Please provide JSON content to validate.</span>';
                return;
            }

            try {
                const parsed = JSON.parse(raw);
                const isArray = Array.isArray(parsed);
                const keysCount = typeof parsed === 'object' && parsed !== null ? Object.keys(parsed).length : 1;

                valResult.className = 'status-box success';
                valResult.style.display = 'flex';
                valResult.innerHTML = `
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong>Valid JSON Document!</strong>
                        <div style="font-size: 0.85rem; margin-top: 0.2rem; opacity: 0.9;">
                            Structure: ${isArray ? 'Array' : typeof parsed} &bull; Root Elements: ${keysCount}
                        </div>
                    </div>
                `;
            } catch (err) {
                valResult.className = 'status-box error';
                valResult.style.display = 'flex';
                valResult.innerHTML = `
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong>Invalid JSON</strong>
                        <div style="font-size: 0.85rem; margin-top: 0.2rem;">${err.message}</div>
                    </div>
                `;

                // Try to extract line or position from error message
                errDesc.textContent = err.message;
                const match = err.message.match(/position (\d+)/i) || err.message.match(/line (\d+) column (\d+)/i);
                if (match && match[1]) {
                    const pos = parseInt(match[1], 10);
                    const start = Math.max(0, pos - 40);
                    const end = Math.min(raw.length, pos + 40);
                    const snippet = raw.substring(start, end);
                    errSnippet.textContent = `...${snippet}...\n` + ' '.repeat(Math.max(0, pos - start + 3)) + '^ Error near here';
                    errDetails.style.display = 'block';
                }
            }
        }

        function loadValidSample() {
            valInput.value = JSON.stringify({
                status: "success",
                project: "Faruk Tools",
                author: "Md. Faruk Hossain",
                location: "Bangladesh",
                tags: ["web-developer", "laravel", "tools"]
            }, null, 2);
            valInput.dispatchEvent(new Event('input'));
            validateJson();
        }

        function loadInvalidSample() {
            valInput.value = '{\n  "name": "Faruk Tools",\n  "status": "active",\n  "trailing_comma": true,\n}';
            valInput.dispatchEvent(new Event('input'));
            validateJson();
        }

        function copyInput() {
            copyToClipboard(valInput.value, 'JSON text copied!');
        }

        function clearValidator() {
            valInput.value = '';
            valResult.style.display = 'none';
            errDetails.style.display = 'none';
            valStats.textContent = '0 characters • 0 lines';
            showToast('Cleared');
        }
    </script>
    @endpush
</x-tool-layout>
