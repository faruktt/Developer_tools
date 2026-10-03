<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <label for="separator-select" style="font-size: 0.85rem; color: var(--text-muted);">Separator:</label>
            <select id="separator-select" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.85rem;" onchange="generateSlug()">
                <option value="-" selected>Hyphen ( - )</option>
                <option value="_">Underscore ( _ )</option>
            </select>
        </div>

        <label style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="slug-lowercase" checked onchange="generateSlug()"> Force Lowercase
        </label>

        <label style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="slug-bangla" checked onchange="generateSlug()"> Support Bangla Unicode
        </label>

        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample English & Bangla</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copySlug()">Copy Slug</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearAll()">Clear</button>
    </div>

    <div class="form-group">
        <label class="form-label" for="slug-input">
            <span>Input Headline / Title</span>
            <span class="form-hint" id="in-stats">0 characters</span>
        </label>
        <textarea id="slug-input" class="code-editor" style="min-height: 120px;" placeholder="Type or paste any English or বাংলা title here..."></textarea>
    </div>

    <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" for="slug-output">
            <span>Generated URL Slug</span>
            <span class="form-hint" id="out-stats">0 characters</span>
        </label>
        <div style="display: flex; gap: 0.5rem;">
            <input type="text" id="slug-output" class="form-control" style="font-family: var(--font-mono); font-size: 1.05rem; font-weight: 600; color: var(--primary);" readonly>
            <button type="button" class="btn btn-primary" onclick="copySlug()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Copy
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('slug-input');
        const outputEl = document.getElementById('slug-output');
        const sepSelect = document.getElementById('separator-select');
        const lowerCheck = document.getElementById('slug-lowercase');
        const banglaCheck = document.getElementById('slug-bangla');
        const inStats = document.getElementById('in-stats');
        const outStats = document.getElementById('out-stats');

        inputEl.addEventListener('input', generateSlug);

        function generateSlug() {
            let str = inputEl.value;
            inStats.textContent = `${str.length} characters`;

            if (!str.trim()) {
                outputEl.value = '';
                outStats.textContent = '0 characters';
                return;
            }

            const sep = sepSelect.value;

            if (lowerCheck.checked) {
                str = str.toLowerCase();
            }

            let slug = '';
            if (banglaCheck.checked) {
                // Keep Latin letters, digits, and Bangla Unicode range (\u0980-\u09FF)
                slug = str
                    .replace(/[^\u0980-\u09FFa-zA-Z0-9\s_-]/g, '') // remove special symbols
                    .trim()
                    .replace(/[\s_-]+/g, sep); // replace spaces/underscores with separator
            } else {
                // Strict ASCII slug
                slug = str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z0-9\s_-]/g, '')
                    .trim()
                    .replace(/[\s_-]+/g, sep);
            }

            // Trim leading/trailing separators
            const regex = new RegExp(`^${sep}+|${sep}+$`, 'g');
            slug = slug.replace(regex, '');

            outputEl.value = slug;
            outStats.textContent = `${slug.length} characters`;
        }

        function loadSample() {
            inputEl.value = 'Laravel 12 ডেভেলপার টুলস - Fast & Privacy Friendly!';
            generateSlug();
        }

        function copySlug() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'Slug copied to clipboard!');
        }

        function clearAll() {
            inputEl.value = '';
            outputEl.value = '';
            inStats.textContent = '0 characters';
            outStats.textContent = '0 characters';
            showToast('Cleared');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSample();
        });
    </script>
    @endpush
</x-tool-layout>
