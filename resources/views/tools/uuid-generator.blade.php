<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar" style="gap: 1rem; align-items: center;">
        <button type="button" class="btn btn-primary" onclick="generateUuids()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Generate UUIDs
        </button>

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <label for="uuid-count" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Quantity:</label>
            <select id="uuid-count" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.85rem;">
                <option value="1" selected>1 UUID</option>
                <option value="5">5 UUIDs</option>
                <option value="10">10 UUIDs</option>
                <option value="25">25 UUIDs</option>
                <option value="50">50 UUIDs</option>
            </select>
        </div>

        <label style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="uuid-uppercase"> Uppercase
        </label>

        <label style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="uuid-hyphens" checked> Include Hyphens
        </label>

        <button type="button" class="btn btn-secondary btn-sm" onclick="copyAll()">Copy All</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearUuids()">Clear</button>
    </div>

    <!-- Output Box -->
    <div class="form-group" style="margin-top: 1rem;">
        <label class="form-label" for="uuid-output">
            <span>Generated Version-4 UUIDs</span>
            <span class="form-hint" id="uuid-stats">1 UUID generated</span>
        </label>
        <textarea id="uuid-output" class="code-editor" style="min-height: 220px;" readonly spellcheck="false"></textarea>
    </div>

    @push('scripts')
    <script>
        const outputEl = document.getElementById('uuid-output');
        const countSelect = document.getElementById('uuid-count');
        const uppercaseCheck = document.getElementById('uuid-uppercase');
        const hyphensCheck = document.getElementById('uuid-hyphens');
        const statsEl = document.getElementById('uuid-stats');

        function generateSingleUuid() {
            let uuid = '';
            if (window.crypto && window.crypto.randomUUID) {
                uuid = window.crypto.randomUUID();
            } else {
                // Cryptographic fallback
                const buf = new Uint8Array(16);
                window.crypto.getRandomValues(buf);
                buf[6] = (buf[6] & 0x0f) | 0x40; // Version 4
                buf[8] = (buf[8] & 0x3f) | 0x80; // Variant 10
                const hex = Array.from(buf, b => b.toString(16).padStart(2, '0')).join('');
                uuid = `${hex.slice(0,8)}-${hex.slice(8,12)}-${hex.slice(12,16)}-${hex.slice(16,20)}-${hex.slice(20)}`;
            }

            if (!hyphensCheck.checked) {
                uuid = uuid.replace(/-/g, '');
            }
            if (uppercaseCheck.checked) {
                uuid = uuid.toUpperCase();
            } else {
                uuid = uuid.toLowerCase();
            }
            return uuid;
        }

        function generateUuids() {
            const count = parseInt(countSelect.value, 10) || 1;
            const list = [];
            for (let i = 0; i < count; i++) {
                list.push(generateSingleUuid());
            }
            outputEl.value = list.join('\n');
            statsEl.textContent = `${count} UUID${count > 1 ? 's' : ''} generated`;
        }

        function copyAll() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'UUIDs copied to clipboard!');
        }

        function clearUuids() {
            outputEl.value = '';
            statsEl.textContent = '0 UUIDs';
            showToast('Cleared');
        }

        // Auto-generate on initial load
        document.addEventListener('DOMContentLoaded', () => {
            generateUuids();
        });
    </script>
    @endpush
</x-tool-layout>
