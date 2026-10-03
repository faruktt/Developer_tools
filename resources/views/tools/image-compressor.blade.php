<x-tool-layout :tool="$tool" :related="$related">
    <!-- Image Drop Area -->
    <div 
        id="drop-zone" 
        style="border: 2px dashed var(--border-subtle); border-radius: var(--radius-xl); padding: 3rem 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s ease; background: var(--bg-surface); margin-bottom: 2rem;"
        onclick="document.getElementById('file-input').click()"
    >
        <input type="file" id="file-input" accept="image/jpeg,image/png,image/webp" style="display: none;" onchange="handleFileSelect(event)">
        <div style="width: 54px; height: 54px; border-radius: 50%; background: rgba(59, 130, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.35rem;">Choose an image or drag & drop here</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted);">Supports PNG, JPEG, and WebP &bull; 100% Client-Side Processing</p>
    </div>

    <!-- Controls & Comparison (Hidden until image selected) -->
    <div id="compressor-workspace" style="display: none;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem;">
            <!-- Quality Slider -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <label for="quality-slider" style="font-weight: 600; font-size: 0.9rem;">Compression Quality:</label>
                    <span id="quality-val" style="font-family: var(--font-mono); font-weight: 700; color: var(--primary); font-size: 1rem;">80%</span>
                </div>
                <input type="range" id="quality-slider" min="5" max="100" value="80" style="width: 100%; accent-color: var(--primary);" oninput="updateQuality(this.value)">
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.25rem;">
                    <span>Smallest File (5%)</span>
                    <span>Best Quality (100%)</span>
                </div>
            </div>

            <!-- Output Format Selection -->
            <div>
                <label for="format-select" style="font-weight: 600; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">Output Format:</label>
                <select id="format-select" class="form-control" onchange="compressImage()">
                    <option value="image/jpeg" selected>JPEG (.jpg)</option>
                    <option value="image/webp">WebP (.webp - High Efficiency)</option>
                    <option value="image/png">PNG (.png)</option>
                </select>
            </div>
        </div>

        <!-- Metrics Comparison Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: var(--bg-surface); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
                <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Original Size</div>
                <div id="orig-size" style="font-family: var(--font-mono); font-size: 1.35rem; font-weight: 700; color: var(--text-main);">-</div>
            </div>

            <div style="background: var(--bg-surface); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
                <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Compressed Size</div>
                <div id="comp-size" style="font-family: var(--font-mono); font-size: 1.35rem; font-weight: 700; color: var(--accent-emerald);">-</div>
            </div>

            <div style="background: var(--bg-surface); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
                <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--text-subtle); font-weight: 600; margin-bottom: 0.25rem;">Size Saved</div>
                <div id="saved-pct" style="font-family: var(--font-mono); font-size: 1.35rem; font-weight: 700; color: #38bdf8;">-</div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2.5rem;">
            <button type="button" class="btn btn-primary" onclick="downloadImage()">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download Compressed Image
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetAll()">
                Select Another Image
            </button>
        </div>

        <!-- Preview Image -->
        <div style="text-align: center;">
            <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--text-muted);">Compressed Preview</h4>
            <div style="display: inline-block; background: var(--bg-card); padding: 8px; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); max-width: 100%;">
                <img id="preview-img" alt="Compressed Preview" style="max-width: 100%; max-height: 480px; border-radius: var(--radius-sm); display: block; margin: 0 auto;">
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const workspace = document.getElementById('compressor-workspace');
        const qualitySlider = document.getElementById('quality-slider');
        const qualityVal = document.getElementById('quality-val');
        const formatSelect = document.getElementById('format-select');
        const origSizeEl = document.getElementById('orig-size');
        const compSizeEl = document.getElementById('comp-size');
        const savedPctEl = document.getElementById('saved-pct');
        const previewImg = document.getElementById('preview-img');

        let originalFile = null;
        let originalImgObj = null;
        let compressedBlob = null;

        // Drag and drop listeners
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.style.borderColor = 'var(--primary)';
                dropZone.style.background = 'var(--bg-card-hover)';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.style.borderColor = 'var(--border-subtle)';
                dropZone.style.background = 'var(--bg-surface)';
            });
        });

        dropZone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                processFile(e.dataTransfer.files[0]);
            }
        });

        function handleFileSelect(e) {
            if (e.target.files && e.target.files[0]) {
                processFile(e.target.files[0]);
            }
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function processFile(file) {
            if (!file.type.startsWith('image/')) {
                showToast('Please select a valid image file', 'error');
                return;
            }

            originalFile = file;
            origSizeEl.textContent = formatBytes(file.size);

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    originalImgObj = img;
                    dropZone.style.display = 'none';
                    workspace.style.display = 'block';
                    compressImage();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function updateQuality(val) {
            qualityVal.textContent = `${val}%`;
            compressImage();
        }

        function compressImage() {
            if (!originalImgObj) return;

            const canvas = document.createElement('canvas');
            canvas.width = originalImgObj.naturalWidth;
            canvas.height = originalImgObj.naturalHeight;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(originalImgObj, 0, 0);

            const quality = parseInt(qualitySlider.value, 10) / 100;
            const mimeType = formatSelect.value;

            canvas.toBlob((blob) => {
                if (!blob) return;
                compressedBlob = blob;
                compSizeEl.textContent = formatBytes(blob.size);

                const savedBytes = originalFile.size - blob.size;
                const savedPct = Math.round((savedBytes / originalFile.size) * 100);

                if (savedPct > 0) {
                    savedPctEl.textContent = `-${savedPct}%`;
                    savedPctEl.style.color = '#10b981';
                } else {
                    savedPctEl.textContent = `+${Math.abs(savedPct)}%`;
                    savedPctEl.style.color = '#f59e0b';
                }

                previewImg.src = URL.createObjectURL(blob);
            }, mimeType, quality);
        }

        function downloadImage() {
            if (!compressedBlob) {
                showToast('No compressed image ready', 'error');
                return;
            }

            const ext = formatSelect.value === 'image/webp' ? 'webp' : (formatSelect.value === 'image/png' ? 'png' : 'jpg');
            const link = document.createElement('a');
            link.download = `compressed-${originalFile.name.replace(/\.[^/.]+$/, "")}.${ext}`;
            link.href = URL.createObjectURL(compressedBlob);
            link.click();
            showToast('Image downloaded!', 'success');
        }

        function resetAll() {
            originalFile = null;
            originalImgObj = null;
            compressedBlob = null;
            fileInput.value = '';
            dropZone.style.display = 'block';
            workspace.style.display = 'none';
        }
    </script>
    @endpush
</x-tool-layout>
