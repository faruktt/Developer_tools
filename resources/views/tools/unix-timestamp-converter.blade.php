<x-tool-layout :tool="$tool" :related="$related">
    <!-- Live Epoch Counter Banner -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="font-size: 0.82rem; color: var(--text-subtle); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Current Unix Epoch Time</div>
            <div id="live-timestamp" style="font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; color: var(--primary);">0</div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="button" class="btn btn-primary btn-sm" onclick="useCurrentTimestamp()">
                Use Current Timestamp
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="copyCurrent()">
                Copy
            </button>
        </div>
    </div>

    <!-- Converter Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
        <!-- Section 1: Timestamp to Date -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 1.25rem;">Unix Timestamp &rarr; Human Date</h3>

            <div class="form-group">
                <label class="form-label" for="ts-input">Timestamp</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="number" id="ts-input" class="form-control" placeholder="e.g. 1735689600">
                    <button type="button" class="btn btn-primary" onclick="convertTimestampToDate()">Convert</button>
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer;">
                    <input type="radio" name="ts-unit" value="s" checked onchange="convertTimestampToDate()"> Seconds (10 digits)
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; margin-top: 0.35rem;">
                    <input type="radio" name="ts-unit" value="ms" onchange="convertTimestampToDate()"> Milliseconds (13 digits)
                </label>
            </div>

            <!-- Output Details -->
            <div id="date-output-box" style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.88rem;">
                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="color: var(--text-subtle); font-size: 0.75rem;">UTC / GMT Date</div>
                    <div id="out-utc" style="font-family: var(--font-mono); font-weight: 600;">-</div>
                </div>
                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="color: var(--text-subtle); font-size: 0.75rem;">Your Local Timezone</div>
                    <div id="out-local" style="font-family: var(--font-mono); font-weight: 600;">-</div>
                </div>
                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="color: var(--text-subtle); font-size: 0.75rem;">ISO 8601 String</div>
                    <div id="out-iso" style="font-family: var(--font-mono); font-weight: 600;">-</div>
                </div>
                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="color: var(--text-subtle); font-size: 0.75rem;">Relative Time</div>
                    <div id="out-relative" style="font-family: var(--font-mono); font-weight: 600; color: var(--accent-cyan);">-</div>
                </div>
            </div>
        </div>

        <!-- Section 2: Date to Timestamp -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 1.25rem;">Human Date &rarr; Unix Timestamp</h3>

            <div class="form-group">
                <label class="form-label" for="date-picker-input">Select Date & Time</label>
                <input type="datetime-local" id="date-picker-input" class="form-control" onchange="convertDateToTimestamp()">
            </div>

            <div class="toolbar">
                <button type="button" class="btn btn-primary" onclick="convertDateToTimestamp()">Generate Timestamp</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="setNowDate()">Now</button>
            </div>

            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--text-subtle); font-size: 0.75rem;">Seconds (Unix Epoch)</span>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('res-seconds').innerText)">Copy</button>
                    </div>
                    <div id="res-seconds" style="font-family: var(--font-mono); font-size: 1.2rem; font-weight: 700; color: var(--primary);">-</div>
                </div>

                <div style="background: var(--bg-input); padding: 0.75rem 1rem; border-radius: var(--radius-sm);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--text-subtle); font-size: 0.75rem;">Milliseconds</span>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="copyToClipboard(document.getElementById('res-ms').innerText)">Copy</button>
                    </div>
                    <div id="res-ms" style="font-family: var(--font-mono); font-size: 1.2rem; font-weight: 700; color: var(--primary);">-</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const liveEl = document.getElementById('live-timestamp');
        const tsInput = document.getElementById('ts-input');
        const outUtc = document.getElementById('out-utc');
        const outLocal = document.getElementById('out-local');
        const outIso = document.getElementById('out-iso');
        const outRelative = document.getElementById('out-relative');

        const datePicker = document.getElementById('date-picker-input');
        const resSeconds = document.getElementById('res-seconds');
        const resMs = document.getElementById('res-ms');

        // Live clock
        function tick() {
            const nowSeconds = Math.floor(Date.now() / 1000);
            liveEl.textContent = nowSeconds;
        }
        setInterval(tick, 1000);
        tick();

        function useCurrentTimestamp() {
            tsInput.value = Math.floor(Date.now() / 1000);
            document.querySelector('input[name="ts-unit"][value="s"]').checked = true;
            convertTimestampToDate();
        }

        function copyCurrent() {
            copyToClipboard(Math.floor(Date.now() / 1000).toString(), 'Current timestamp copied!');
        }

        function formatRelative(msDiff) {
            const sec = Math.round(msDiff / 1000);
            const rtf = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });
            if (Math.abs(sec) < 60) return rtf.format(sec, 'second');
            const min = Math.round(sec / 60);
            if (Math.abs(min) < 60) return rtf.format(min, 'minute');
            const hr = Math.round(min / 60);
            if (Math.abs(hr) < 24) return rtf.format(hr, 'hour');
            const day = Math.round(hr / 24);
            return rtf.format(day, 'day');
        }

        function convertTimestampToDate() {
            const raw = tsInput.value.trim();
            if (!raw) return;

            const unit = document.querySelector('input[name="ts-unit"]:checked').value;
            let num = parseInt(raw, 10);
            if (isNaN(num)) {
                showToast('Invalid number entered', 'error');
                return;
            }

            if (unit === 's') {
                num = num * 1000;
            }

            const d = new Date(num);
            if (isNaN(d.getTime())) {
                showToast('Date out of valid range', 'error');
                return;
            }

            outUtc.textContent = d.toUTCString();
            outLocal.textContent = d.toString();
            outIso.textContent = d.toISOString();
            outRelative.textContent = formatRelative(d.getTime() - Date.now());
        }

        function convertDateToTimestamp() {
            const val = datePicker.value;
            if (!val) return;
            const d = new Date(val);
            if (isNaN(d.getTime())) return;

            resSeconds.textContent = Math.floor(d.getTime() / 1000);
            resMs.textContent = d.getTime();
        }

        function setNowDate() {
            const now = new Date();
            // Format to YYYY-MM-DDTHH:mm
            const offset = now.getTimezoneOffset() * 60000;
            const localISOTime = (new Date(now - offset)).toISOString().slice(0, 16);
            datePicker.value = localISOTime;
            convertDateToTimestamp();
        }

        document.addEventListener('DOMContentLoaded', () => {
            useCurrentTimestamp();
            setNowDate();
        });
    </script>
    @endpush
</x-tool-layout>
