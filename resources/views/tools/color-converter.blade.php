<x-tool-layout :tool="$tool" :related="$related">
    <div style="display: grid; grid-template-columns: 240px 1fr; gap: 2rem; align-items: start;">
        <!-- Left: Color Picker & Live Preview Box -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center;">
            <div id="color-preview" style="width: 100%; height: 160px; border-radius: var(--radius-md); background-color: #3b82f6; box-shadow: var(--shadow-sm); border: 1px solid var(--border-subtle); margin-bottom: 1.25rem; transition: background-color 0.15s ease;"></div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="color-picker" class="form-label" style="justify-content: center; margin-bottom: 0.5rem;">Pick Color</label>
                <input type="color" id="color-picker" value="#3b82f6" style="width: 100%; height: 42px; border: none; cursor: pointer; border-radius: var(--radius-sm); background: transparent;" oninput="updateFromPicker(this.value)">
            </div>
        </div>

        <!-- Right: Conversions Grid -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <!-- HEX -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                <div style="flex-grow: 1;">
                    <label for="input-hex" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--text-subtle); display: block; margin-bottom: 0.2rem;">HEX</label>
                    <input type="text" id="input-hex" class="form-control" value="#3b82f6" style="font-family: var(--font-mono); font-weight: 600;" oninput="updateFromHex(this.value)">
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('input-hex').value, 'HEX copied!')">Copy</button>
            </div>

            <!-- RGB -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                <div style="flex-grow: 1;">
                    <label for="input-rgb" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--text-subtle); display: block; margin-bottom: 0.2rem;">RGB</label>
                    <input type="text" id="input-rgb" class="form-control" value="rgb(59, 130, 246)" style="font-family: var(--font-mono); font-weight: 600;" oninput="updateFromRgb(this.value)">
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('input-rgb').value, 'RGB copied!')">Copy</button>
            </div>

            <!-- HSL -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                <div style="flex-grow: 1;">
                    <label for="input-hsl" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--text-subtle); display: block; margin-bottom: 0.2rem;">HSL</label>
                    <input type="text" id="input-hsl" class="form-control" value="hsl(217, 91%, 60%)" style="font-family: var(--font-mono); font-weight: 600;" oninput="updateFromHsl(this.value)">
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('input-hsl').value, 'HSL copied!')">Copy</button>
            </div>

            <!-- CSS Color Values (RGBA & HSLA) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--text-subtle);">RGBA</span>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('out-rgba').innerText)">Copy</button>
                    </div>
                    <div id="out-rgba" style="font-family: var(--font-mono); font-size: 0.9rem; font-weight: 600;">rgba(59, 130, 246, 1)</div>
                </div>

                <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--text-subtle);">HSLA</span>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('out-hsla').innerText)">Copy</button>
                    </div>
                    <div id="out-hsla" style="font-family: var(--font-mono); font-size: 0.9rem; font-weight: 600;">hsla(217, 91%, 60%, 1)</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const previewEl = document.getElementById('color-preview');
        const pickerEl = document.getElementById('color-picker');
        const hexEl = document.getElementById('input-hex');
        const rgbEl = document.getElementById('input-rgb');
        const hslEl = document.getElementById('input-hsl');
        const rgbaEl = document.getElementById('out-rgba');
        const hslaEl = document.getElementById('out-hsla');

        function hexToRgb(hex) {
            let clean = hex.replace(/^#/, '');
            if (clean.length === 3) {
                clean = clean.split('').map(c => c + c).join('');
            }
            if (clean.length !== 6) return null;
            const num = parseInt(clean, 16);
            if (isNaN(num)) return null;
            return {
                r: (num >> 16) & 255,
                g: (num >> 8) & 255,
                b: num & 255
            };
        }

        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(x => {
                const hex = Math.max(0, Math.min(255, Math.round(x))).toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
        }

        function rgbToHsl(r, g, b) {
            r /= 255; g /= 255; b /= 255;
            const max = Math.max(r, g, b), min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0;
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }

            return {
                h: Math.round(h * 360),
                s: Math.round(s * 100),
                l: Math.round(l * 100)
            };
        }

        function hslToRgb(h, s, l) {
            h /= 360; s /= 100; l /= 100;
            let r, g, b;

            if (s === 0) {
                r = g = b = l;
            } else {
                const hue2rgb = (p, q, t) => {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1/6) return p + (q - p) * 6 * t;
                    if (t < 1/2) return q;
                    if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                    return p;
                };

                const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                const p = 2 * l - q;
                r = hue2rgb(p, q, h + 1/3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1/3);
            }

            return {
                r: Math.round(r * 255),
                g: Math.round(g * 255),
                b: Math.round(b * 255)
            };
        }

        function applyColor(r, g, b, source = '') {
            const hex = rgbToHex(r, g, b);
            const hsl = rgbToHsl(r, g, b);

            previewEl.style.backgroundColor = hex;
            if (source !== 'picker') pickerEl.value = hex;
            if (source !== 'hex') hexEl.value = hex;
            if (source !== 'rgb') rgbEl.value = `rgb(${r}, ${g}, ${b})`;
            if (source !== 'hsl') hslEl.value = `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;

            rgbaEl.textContent = `rgba(${r}, ${g}, ${b}, 1)`;
            hslaEl.textContent = `hsla(${hsl.h}, ${hsl.s}%, ${hsl.l}%, 1)`;
        }

        function updateFromPicker(val) {
            const rgb = hexToRgb(val);
            if (rgb) applyColor(rgb.r, rgb.g, rgb.b, 'picker');
        }

        function updateFromHex(val) {
            const rgb = hexToRgb(val);
            if (rgb) applyColor(rgb.r, rgb.g, rgb.b, 'hex');
        }

        function updateFromRgb(val) {
            const match = val.match(/rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/i) || val.match(/(\d+)\s*,\s*(\d+)\s*,\s*(\d+)/);
            if (match) {
                applyColor(parseInt(match[1]), parseInt(match[2]), parseInt(match[3]), 'rgb');
            }
        }

        function updateFromHsl(val) {
            const match = val.match(/hsl\s*\(\s*(\d+)\s*,\s*(\d+)%?\s*,\s*(\d+)%?\s*\)/i) || val.match(/(\d+)\s*,\s*(\d+)%?\s*,\s*(\d+)%?/);
            if (match) {
                const rgb = hslToRgb(parseInt(match[1]), parseInt(match[2]), parseInt(match[3]));
                applyColor(rgb.r, rgb.g, rgb.b, 'hsl');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyColor(59, 130, 246);
        });
    </script>
    @endpush
</x-tool-layout>
