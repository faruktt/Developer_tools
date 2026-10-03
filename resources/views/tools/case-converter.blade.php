<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar" style="gap: 0.5rem; flex-wrap: wrap;">
        <button type="button" class="btn btn-secondary" onclick="convertCase('upper')">UPPERCASE</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('lower')">lowercase</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('title')">Title Case</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('sentence')">Sentence case</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('toggle')">tOGGLE cASE</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('alternating')">aLtErNaTiNg cAsE</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('camel')">camelCase</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('snake')">snake_case</button>
        <button type="button" class="btn btn-secondary" onclick="convertCase('kebab')">kebab-case</button>

        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="copyText()">Copy</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearText()">Clear</button>
    </div>

    <div class="form-group" style="margin-top: 1.25rem;">
        <label class="form-label" for="case-input">
            <span>Input / Output Text</span>
            <span class="form-hint" id="char-stats">0 characters</span>
        </label>
        <textarea id="case-input" class="code-editor" style="min-height: 280px;" placeholder="Type or paste text here, then choose a conversion format above..."></textarea>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('case-input');
        const statsEl = document.getElementById('char-stats');

        inputEl.addEventListener('input', () => {
            statsEl.textContent = `${inputEl.value.length} characters`;
        });

        function convertCase(type) {
            let str = inputEl.value;
            if (!str) {
                showToast('Please enter some text to convert', 'error');
                return;
            }

            let res = '';
            switch (type) {
                case 'upper':
                    res = str.toUpperCase();
                    break;
                case 'lower':
                    res = str.toLowerCase();
                    break;
                case 'title':
                    res = str.toLowerCase().replace(/(^|\s|-|_)\S/g, l => l.toUpperCase());
                    break;
                case 'sentence':
                    res = str.toLowerCase().replace(/(^\s*|[.!?]\s+)([a-z])/g, (m, p1, p2) => p1 + p2.toUpperCase());
                    break;
                case 'toggle':
                    res = str.split('').map(c => c === c.toUpperCase() ? c.toLowerCase() : c.toUpperCase()).join('');
                    break;
                case 'alternating':
                    let count = 0;
                    res = str.split('').map(c => {
                        if (/[a-zA-Z]/.test(c)) {
                            count++;
                            return count % 2 === 1 ? c.toLowerCase() : c.toUpperCase();
                        }
                        return c;
                    }).join('');
                    break;
                case 'camel':
                    res = str
                        .replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => index === 0 ? word.toLowerCase() : word.toUpperCase())
                        .replace(/[\s\-_]+/g, '');
                    break;
                case 'snake':
                    res = str
                        .trim()
                        .replace(/([a-z])([A-Z])/g, '$1_$2')
                        .replace(/[\s\-]+/g, '_')
                        .toLowerCase();
                    break;
                case 'kebab':
                    res = str
                        .trim()
                        .replace(/([a-z])([A-Z])/g, '$1-$2')
                        .replace(/[\s_]+/g, '-')
                        .toLowerCase();
                    break;
            }

            inputEl.value = res;
            statsEl.textContent = `${res.length} characters`;
            showToast(`Converted to ${type}!`, 'success');
        }

        function loadSample() {
            inputEl.value = 'Free Developer Tools for Everyone. Faruk Tools is built with Laravel 12!';
            statsEl.textContent = `${inputEl.value.length} characters`;
        }

        function copyText() {
            if (!inputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(inputEl.value, 'Text copied to clipboard!');
        }

        function clearText() {
            inputEl.value = '';
            statsEl.textContent = '0 characters';
            showToast('Cleared');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSample();
        });
    </script>
    @endpush
</x-tool-layout>
