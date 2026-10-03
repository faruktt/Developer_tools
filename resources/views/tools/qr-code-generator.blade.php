<x-tool-layout :tool="$tool" :related="$related">
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        <!-- Left: Input & Settings -->
        <div>
            <div class="form-group">
                <label class="form-label" for="qr-input">
                    <span>Text or URL</span>
                    <span class="form-hint">Enter website URL, contact info, or plain text</span>
                </label>
                <textarea id="qr-input" class="code-editor" style="min-height: 140px;" placeholder="https://tools.faruk.stsoft.top"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="qr-size" class="form-label">Size (px)</label>
                    <select id="qr-size" class="form-control" onchange="generateQr()">
                        <option value="200">200 x 200</option>
                        <option value="280" selected>280 x 280</option>
                        <option value="400">400 x 400</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="qr-level" class="form-label">Error Correction</label>
                    <select id="qr-level" class="form-control" onchange="generateQr()">
                        <option value="L">Low (7%)</option>
                        <option value="M" selected>Medium (15%)</option>
                        <option value="Q">Quartile (25%)</option>
                        <option value="H">High (30%)</option>
                    </select>
                </div>
            </div>

            <div class="toolbar">
                <button type="button" class="btn btn-primary" onclick="generateQr()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Generate QR
                </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="clearQr()">Clear</button>
            </div>
        </div>

        <!-- Right: Preview & Download -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="background: #ffffff; padding: 12px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); display: inline-block;">
                <canvas id="qr-canvas" width="280" height="280" style="display: block; max-width: 100%; height: auto;"></canvas>
            </div>

            <div style="margin-top: 1.5rem; width: 100%;">
                <button type="button" class="btn btn-primary" style="width: 100%;" onclick="downloadQr()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download PNG
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        const qrInput = document.getElementById('qr-input');
        const qrSize = document.getElementById('qr-size');
        const qrLevel = document.getElementById('qr-level');
        const canvas = document.getElementById('qr-canvas');

        function generateQr() {
            const text = (qrInput.value || '').trim() || 'https://tools.faruk.stsoft.top';
            const size = parseInt(qrSize.value, 10) || 280;
            const level = qrLevel.value || 'M';

            if (window.renderQRCodeToCanvas) {
                window.renderQRCodeToCanvas(canvas, text, {
                    size: size,
                    level: level,
                    margin: 8,
                    background: '#ffffff',
                    foreground: '#000000'
                });
            }
        }

        function downloadQr() {
            const link = document.createElement('a');
            link.download = 'faruk-tools-qrcode.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            showToast('QR Code image downloaded!', 'success');
        }

        function loadSample() {
            qrInput.value = 'https://tools.faruk.stsoft.top';
            generateQr();
        }

        function clearQr() {
            qrInput.value = '';
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            showToast('Cleared');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSample();
        });
    </script>
    @endpush
</x-tool-layout>
