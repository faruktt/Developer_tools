<x-tool-layout :tool="$tool" :related="$related">
    <!-- Password Display Box -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
            <div id="password-display" style="font-family: var(--font-mono); font-size: clamp(1.15rem, 2.5vw, 1.6rem); font-weight: 700; color: var(--text-main); word-break: break-all; letter-spacing: 0.05em; min-height: 2.2rem; display: flex; align-items: center;">
                Click generate to create password
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="button" class="btn btn-primary" onclick="generatePassword()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Regenerate
                </button>
                <button type="button" class="btn btn-secondary" onclick="copyPassword()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Copy
                </button>
            </div>
        </div>

        <!-- Strength Indicator Bar -->
        <div style="margin-top: 1rem;">
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.35rem;">
                <span style="color: var(--text-muted);">Password Strength</span>
                <span id="strength-label" style="font-weight: 600; color: #10b981;">Strong</span>
            </div>
            <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.08); border-radius: 9999px; overflow: hidden;">
                <div id="strength-bar" style="width: 80%; height: 100%; background: #10b981; transition: all 0.3s ease;"></div>
            </div>
        </div>
    </div>

    <!-- Configuration Options -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
        <!-- Length Control -->
        <div style="background: var(--bg-surface); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <label for="length-slider" style="font-weight: 600; font-size: 0.92rem;">Length:</label>
                <span id="length-val" style="font-family: var(--font-mono); font-weight: 700; color: var(--primary); font-size: 1.1rem;">16</span>
            </div>
            <input type="range" id="length-slider" min="6" max="64" value="16" style="width: 100%; accent-color: var(--primary);" oninput="updateLength(this.value)">
            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.25rem;">
                <span>6 characters</span>
                <span>64 characters</span>
            </div>
        </div>

        <!-- Characters Checkboxes -->
        <div style="background: var(--bg-surface); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 0.75rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" id="opt-upper" checked onchange="generatePassword()"> Uppercase Letters (A-Z)
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" id="opt-lower" checked onchange="generatePassword()"> Lowercase Letters (a-z)
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" id="opt-nums" checked onchange="generatePassword()"> Numbers (0-9)
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" id="opt-syms" checked onchange="generatePassword()"> Symbols (!@#$%^&*...)
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer;">
                <input type="checkbox" id="opt-exclude-similar" onchange="generatePassword()"> Exclude Similar (i, l, 1, L, o, 0, O)
            </label>
        </div>
    </div>

    @push('scripts')
    <script>
        const passDisplay = document.getElementById('password-display');
        const lengthSlider = document.getElementById('length-slider');
        const lengthVal = document.getElementById('length-val');
        const optUpper = document.getElementById('opt-upper');
        const optLower = document.getElementById('opt-lower');
        const optNums = document.getElementById('opt-nums');
        const optSyms = document.getElementById('opt-syms');
        const optExcludeSimilar = document.getElementById('opt-exclude-similar');
        const strengthBar = document.getElementById('strength-bar');
        const strengthLabel = document.getElementById('strength-label');

        let currentPassword = '';

        function updateLength(val) {
            lengthVal.textContent = val;
            generatePassword();
        }

        function generatePassword() {
            let charset = '';
            let upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let lower = 'abcdefghijklmnopqrstuvwxyz';
            let nums = '0123456789';
            let syms = '!@#$%^&*()_+-=[]{}|;:,.<>?';

            if (optExcludeSimilar.checked) {
                upper = upper.replace(/[IO]/g, '');
                lower = lower.replace(/[ilo]/g, '');
                nums = nums.replace(/[01]/g, '');
            }

            if (optUpper.checked) charset += upper;
            if (optLower.checked) charset += lower;
            if (optNums.checked) charset += nums;
            if (optSyms.checked) charset += syms;

            if (!charset) {
                passDisplay.textContent = 'Select at least one character type!';
                strengthBar.style.width = '0%';
                strengthLabel.textContent = 'None';
                currentPassword = '';
                return;
            }

            const len = parseInt(lengthSlider.value, 10);
            const array = new Uint32Array(len);
            window.crypto.getRandomValues(array);

            let res = '';
            for (let i = 0; i < len; i++) {
                res += charset[array[i] % charset.length];
            }

            currentPassword = res;
            passDisplay.textContent = res;
            calculateStrength(res);
        }

        function calculateStrength(pwd) {
            let score = 0;
            if (pwd.length >= 8) score += 1;
            if (pwd.length >= 12) score += 1;
            if (pwd.length >= 16) score += 1;
            if (/[A-Z]/.test(pwd)) score += 1;
            if (/[0-9]/.test(pwd)) score += 1;
            if (/[^A-Za-z0-9]/.test(pwd)) score += 1;

            if (score <= 2) {
                strengthBar.style.width = '25%';
                strengthBar.style.background = '#ef4444';
                strengthLabel.textContent = 'Weak';
                strengthLabel.style.color = '#ef4444';
            } else if (score <= 4) {
                strengthBar.style.width = '60%';
                strengthBar.style.background = '#f59e0b';
                strengthLabel.textContent = 'Medium';
                strengthLabel.style.color = '#f59e0b';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.style.background = '#10b981';
                strengthLabel.textContent = 'Very Strong';
                strengthLabel.style.color = '#10b981';
            }
        }

        function copyPassword() {
            if (!currentPassword) {
                showToast('No password generated', 'error');
                return;
            }
            copyToClipboard(currentPassword, 'Password copied to clipboard!');
        }

        document.addEventListener('DOMContentLoaded', () => {
            generatePassword();
        });
    </script>
    @endpush
</x-tool-layout>
