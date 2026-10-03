<x-tool-layout :tool="$tool" :related="$related">
    <!-- Notice -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.65rem 0.85rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
        <svg width="15" height="15" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 16v-4m0-4h.01"/></svg>
        <span><strong>Notice:</strong> JWT decoding does not verify the token signature. It does not validate token authenticity.</span>
    </div>

    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="decodeJwt()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Decode Token
        </button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSampleJwt()">Sample</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearJwt()">Clear</button>
    </div>

    <!-- Token Input -->
    <div class="form-group">
        <label class="form-label" for="jwt-input">
            <span>Encoded Token</span>
            <span class="form-hint" id="jwt-stats">0 chars</span>
        </label>
        <textarea id="jwt-input" class="code-editor" style="min-height: 90px;" placeholder="Paste encoded JWT (header.payload.signature)..."></textarea>
    </div>

    <div id="jwt-status" style="display: none;"></div>

    <!-- Metadata Card -->
    <div id="token-meta-box" style="display: none; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.85rem 1rem; margin-bottom: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem; font-size: 0.8rem;">
            <div>
                <span style="color: var(--text-subtle);">Algorithm (alg):</span>
                <strong id="meta-alg" style="margin-left: 0.35rem; color: var(--text-main);">-</strong>
            </div>
            <div>
                <span style="color: var(--text-subtle);">Type (typ):</span>
                <strong id="meta-typ" style="margin-left: 0.35rem; color: var(--text-main);">-</strong>
            </div>
            <div>
                <span style="color: var(--text-subtle);">Expiry (exp):</span>
                <span id="meta-exp" style="margin-left: 0.35rem;">-</span>
            </div>
            <div>
                <span style="color: var(--text-subtle);">Issued (iat):</span>
                <span id="meta-iat" style="margin-left: 0.35rem; color: var(--text-main);">-</span>
            </div>
        </div>
    </div>

    <!-- Header & Payload -->
    <div class="dual-editor-grid">
        <div class="form-group" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                <label class="form-label" for="jwt-header" style="margin-bottom: 0;">Header</label>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyHeader()">Copy</button>
            </div>
            <textarea id="jwt-header" class="code-editor" style="min-height: 200px;" readonly placeholder="Header JSON..."></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                <label class="form-label" for="jwt-payload" style="margin-bottom: 0;">Payload</label>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyPayload()">Copy</button>
            </div>
            <textarea id="jwt-payload" class="code-editor" style="min-height: 200px;" readonly placeholder="Payload JSON..."></textarea>
        </div>
    </div>

    @push('scripts')
    <script>
        const jwtInput = document.getElementById('jwt-input');
        const jwtStats = document.getElementById('jwt-stats');
        const jwtHeader = document.getElementById('jwt-header');
        const jwtPayload = document.getElementById('jwt-payload');
        const jwtStatus = document.getElementById('jwt-status');
        const metaBox = document.getElementById('token-meta-box');
        const metaAlg = document.getElementById('meta-alg');
        const metaTyp = document.getElementById('meta-typ');
        const metaExp = document.getElementById('meta-exp');
        const metaIat = document.getElementById('meta-iat');

        jwtInput.addEventListener('input', () => {
            jwtStats.textContent = `${jwtInput.value.length} chars`;
            if (jwtInput.value.trim().length > 10) {
                decodeJwt();
            }
        });

        function base64UrlDecode(str) {
            let output = str.replace(/-/g, '+').replace(/_/g, '/');
            switch (output.length % 4) {
                case 0: break;
                case 2: output += '=='; break;
                case 3: output += '='; break;
                default: throw new Error('Illegal base64url string!');
            }
            const binary = atob(output);
            const bytes = new Uint8Array(binary.length);
            for (let i = 0; i < binary.length; i++) {
                bytes[i] = binary.charCodeAt(i);
            }
            return new TextDecoder().decode(bytes);
        }

        function decodeJwt() {
            const raw = jwtInput.value.trim();
            if (!raw) {
                jwtStatus.className = 'status-box error';
                jwtStatus.style.display = 'flex';
                jwtStatus.innerHTML = 'Enter a token to decode.';
                metaBox.style.display = 'none';
                return;
            }

            const parts = raw.split('.');
            if (parts.length < 2) {
                jwtStatus.className = 'status-box error';
                jwtStatus.style.display = 'flex';
                jwtStatus.innerHTML = 'Invalid JWT: expected header.payload[.signature] format.';
                metaBox.style.display = 'none';
                return;
            }

            try {
                const headerJson = JSON.parse(base64UrlDecode(parts[0]));
                const payloadJson = JSON.parse(base64UrlDecode(parts[1]));

                jwtHeader.value = JSON.stringify(headerJson, null, 2);
                jwtPayload.value = JSON.stringify(payloadJson, null, 2);

                metaAlg.textContent = headerJson.alg || 'none';
                metaTyp.textContent = headerJson.typ || 'JWT';

                if (payloadJson.exp) {
                    const expDate = new Date(payloadJson.exp * 1000);
                    const isExpired = Date.now() > expDate.getTime();
                    metaExp.innerHTML = `<span style="color: ${isExpired ? '#f43f5e' : '#10b981'}; font-weight: 600;">${expDate.toUTCString()} (${isExpired ? 'EXPIRED' : 'ACTIVE'})</span>`;
                } else {
                    metaExp.textContent = 'None';
                }

                if (payloadJson.iat) {
                    const iatDate = new Date(payloadJson.iat * 1000);
                    metaIat.textContent = iatDate.toUTCString();
                } else {
                    metaIat.textContent = 'None';
                }

                metaBox.style.display = 'block';
                jwtStatus.className = 'status-box success';
                jwtStatus.style.display = 'flex';
                jwtStatus.innerHTML = 'Token decoded locally in browser.';
            } catch (err) {
                jwtStatus.className = 'status-box error';
                jwtStatus.style.display = 'flex';
                jwtStatus.innerHTML = `Parse error: ${err.message}`;
                metaBox.style.display = 'none';
            }
        }

        function loadSampleJwt() {
            const now = Math.floor(Date.now() / 1000);
            const exp = now + 3600;
            const header = btoa(JSON.stringify({ alg: "HS256", typ: "JWT" })).replace(/=/g, '');
            const payload = btoa(JSON.stringify({
                sub: "user_12345",
                name: "Faruk Hossain",
                role: "developer",
                iat: now,
                exp: exp
            })).replace(/=/g, '');
            const signature = "c2FtcGxlLXNpZ25hdHVyZS1mYXJ1ay10b29scw";

            jwtInput.value = `${header}.${payload}.${signature}`;
            jwtStats.textContent = `${jwtInput.value.length} chars`;
            decodeJwt();
        }

        function copyHeader() {
            copyToClipboard(jwtHeader.value, 'Header copied');
        }

        function copyPayload() {
            copyToClipboard(jwtPayload.value, 'Payload copied');
        }

        function clearJwt() {
            jwtInput.value = '';
            jwtHeader.value = '';
            jwtPayload.value = '';
            jwtStatus.style.display = 'none';
            metaBox.style.display = 'none';
            jwtStats.textContent = '0 chars';
            showToast('Cleared');
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSampleJwt();
        });
    </script>
    @endpush
</x-tool-layout>
