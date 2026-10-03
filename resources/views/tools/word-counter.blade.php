<x-tool-layout :tool="$tool" :related="$related">
    <!-- Live Metrics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.75rem;">
        <div style="background: var(--bg-surface); padding: 1.25rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Words</div>
            <div id="stat-words" style="font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: var(--primary);">0</div>
        </div>

        <div style="background: var(--bg-surface); padding: 1.25rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Characters</div>
            <div id="stat-chars" style="font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: var(--text-main);">0</div>
            <div id="stat-chars-nospace" style="font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.25rem;">0 without spaces</div>
        </div>

        <div style="background: var(--bg-surface); padding: 1.25rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Sentences</div>
            <div id="stat-sentences" style="font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: var(--accent-cyan);">0</div>
        </div>

        <div style="background: var(--bg-surface); padding: 1.25rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Paragraphs</div>
            <div id="stat-paragraphs" style="font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: var(--accent-purple);">0</div>
        </div>

        <div style="background: var(--bg-surface); padding: 1.25rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Reading Time</div>
            <div id="stat-reading" style="font-family: var(--font-mono); font-size: 1.3rem; font-weight: 700; color: var(--accent-emerald); margin-top: 0.35rem;">0 sec</div>
            <div id="stat-speaking" style="font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.35rem;">Speaking: 0 sec</div>
        </div>
    </div>

    <div class="toolbar">
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample Text</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyText()">Copy Text</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearText()">Clear</button>
    </div>

    <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" for="word-input">
            <span>Enter or Paste Your Text</span>
            <span class="form-hint">Metrics update in real-time</span>
        </label>
        <textarea id="word-input" class="code-editor" style="min-height: 280px;" placeholder="Start typing or paste articles, blog posts, essays, or code comments here..."></textarea>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('word-input');
        const statWords = document.getElementById('stat-words');
        const statChars = document.getElementById('stat-chars');
        const statCharsNoSpace = document.getElementById('stat-chars-nospace');
        const statSentences = document.getElementById('stat-sentences');
        const statParagraphs = document.getElementById('stat-paragraphs');
        const statReading = document.getElementById('stat-reading');
        const statSpeaking = document.getElementById('stat-speaking');

        inputEl.addEventListener('input', updateStats);

        function updateStats() {
            const text = inputEl.value;

            // Characters
            const charCount = text.length;
            const charNoSpaceCount = text.replace(/\s/g, '').length;
            statChars.textContent = charCount.toLocaleString();
            statCharsNoSpace.textContent = `${charNoSpaceCount.toLocaleString()} without spaces`;

            // Words
            const words = text.trim() ? text.trim().split(/\s+/).filter(Boolean) : [];
            const wordCount = words.length;
            statWords.textContent = wordCount.toLocaleString();

            // Sentences
            const sentences = text.trim() ? text.split(/[.!?]+/).filter(s => s.trim().length > 0) : [];
            statSentences.textContent = sentences.length.toLocaleString();

            // Paragraphs
            const paragraphs = text.trim() ? text.split(/\n+/).filter(p => p.trim().length > 0) : [];
            statParagraphs.textContent = paragraphs.length.toLocaleString();

            // Reading Time (Average 200 words per minute)
            const readMinutes = Math.floor(wordCount / 200);
            const readSeconds = Math.round((wordCount % 200) / (200 / 60));
            if (readMinutes === 0) {
                statReading.textContent = `${readSeconds} sec`;
            } else {
                statReading.textContent = `${readMinutes} min ${readSeconds}s`;
            }

            // Speaking Time (Average 130 words per minute)
            const speakMinutes = Math.floor(wordCount / 130);
            const speakSeconds = Math.round((wordCount % 130) / (130 / 60));
            if (speakMinutes === 0) {
                statSpeaking.textContent = `Speaking: ${speakSeconds} sec`;
            } else {
                statSpeaking.textContent = `Speaking: ${speakMinutes}m ${speakSeconds}s`;
            }
        }

        function loadSample() {
            inputEl.value = `Free Developer Tools for Everyone!\n\nFaruk Tools is a collection of fast, simple and privacy-friendly online utilities designed for developers, designers and web professionals.\n\nAll tools process data directly in your browser without transmitting sensitive information to external servers. Developed by Md. Faruk Hossain, PHP Laravel Developer from Bangladesh.`;
            updateStats();
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
            updateStats();
            showToast('Cleared');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSample();
        });
    </script>
    @endpush
</x-tool-layout>
