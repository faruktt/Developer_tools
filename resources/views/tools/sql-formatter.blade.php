<x-tool-layout :tool="$tool" :related="$related">
    <div class="toolbar">
        <button type="button" class="btn btn-primary" onclick="formatSql()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
            Format SQL
        </button>
        <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; user-select: none;">
            <input type="checkbox" id="sql-uppercase-kw" checked onchange="formatSql()"> UPPERCASE Keywords
        </label>
        <button type="button" class="btn btn-secondary btn-sm" onclick="loadSample()">Sample Query</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="copyResult()">Copy Result</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="clearAll()">Clear</button>
    </div>

    <div class="dual-editor-grid">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="sql-input">
                <span>Raw SQL Query</span>
                <span class="form-hint" id="in-stats">0 chars</span>
            </label>
            <textarea id="sql-input" class="code-editor" placeholder="Paste unformatted SQL query here..." spellcheck="false"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="sql-output">
                <span>Formatted SQL Query</span>
                <span class="form-hint" id="out-stats">0 chars</span>
            </label>
            <textarea id="sql-output" class="code-editor" placeholder="Structured SQL query will appear here..." readonly spellcheck="false"></textarea>
        </div>
    </div>

    @push('scripts')
    <script>
        const inputEl = document.getElementById('sql-input');
        const outputEl = document.getElementById('sql-output');
        const inStats = document.getElementById('in-stats');
        const outStats = document.getElementById('out-stats');
        const uppercaseKw = document.getElementById('sql-uppercase-kw');

        inputEl.addEventListener('input', () => {
            inStats.textContent = `${inputEl.value.length} chars`;
        });

        const majorKeywords = [
            'SELECT', 'FROM', 'WHERE', 'LEFT JOIN', 'RIGHT JOIN', 'INNER JOIN', 'OUTER JOIN',
            'CROSS JOIN', 'JOIN', 'GROUP BY', 'ORDER BY', 'HAVING', 'LIMIT', 'OFFSET',
            'INSERT INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE FROM', 'UNION ALL', 'UNION'
        ];

        const secondaryKeywords = [
            'AND', 'OR', 'ON', 'AS', 'IN', 'IS NULL', 'IS NOT NULL', 'BETWEEN', 'LIKE', 'ILIKE',
            'ASC', 'DESC', 'CASE', 'WHEN', 'THEN', 'ELSE', 'END', 'DISTINCT', 'COUNT', 'SUM', 'AVG', 'MIN', 'MAX'
        ];

        function formatSql() {
            let sql = inputEl.value.trim();
            if (!sql) {
                showToast('Please enter an SQL query to format', 'error');
                return;
            }

            // Collapse whitespace
            sql = sql.replace(/\s+/g, ' ');

            // Sort major keywords by length desc so multi-word like "LEFT JOIN" matches first
            const sortedMajor = [...majorKeywords].sort((a, b) => b.length - a.length);

            // Add newlines before major clauses
            sortedMajor.forEach(kw => {
                const regex = new RegExp(`\\b${kw}\\b`, 'gi');
                sql = sql.replace(regex, match => {
                    const word = uppercaseKw.checked ? match.toUpperCase() : match.toLowerCase();
                    return `\n${word}`;
                });
            });

            // Secondary keywords like AND, OR
            ['AND', 'OR'].forEach(kw => {
                const regex = new RegExp(`\\b${kw}\\b`, 'gi');
                sql = sql.replace(regex, match => {
                    const word = uppercaseKw.checked ? match.toUpperCase() : match.toLowerCase();
                    return `\n  ${word}`;
                });
            });

            // Keywords casing for other keywords
            secondaryKeywords.forEach(kw => {
                if (kw === 'AND' || kw === 'OR') return;
                const regex = new RegExp(`\\b${kw}\\b`, 'gi');
                sql = sql.replace(regex, match => {
                    return uppercaseKw.checked ? match.toUpperCase() : match.toLowerCase();
                });
            });

            // Clean up comma formatting in SELECT clauses
            let lines = sql.split('\n');
            let formattedLines = [];

            lines.forEach(line => {
                let trimmed = line.trim();
                if (!trimmed) return;
                
                // If it starts with a major keyword, keep unindented
                const isMajor = sortedMajor.some(k => trimmed.toUpperCase().startsWith(k));
                if (isMajor) {
                    formattedLines.push(trimmed);
                } else if (trimmed.toUpperCase().startsWith('AND') || trimmed.toUpperCase().startsWith('OR')) {
                    formattedLines.push('  ' + trimmed);
                } else {
                    formattedLines.push('  ' + trimmed);
                }
            });

            outputEl.value = formattedLines.join('\n').trim();
            outStats.textContent = `${outputEl.value.length} chars`;
            showToast('SQL formatted successfully!', 'success');
        }

        function loadSample() {
            inputEl.value = "select u.id, u.name, u.email, count(o.id) as total_orders from users u left join orders o on u.id = o.user_id where u.status = 'active' and u.created_at >= '2025-01-01' group by u.id, u.name, u.email having count(o.id) > 5 order by total_orders desc limit 20;";
            inStats.textContent = `${inputEl.value.length} chars`;
            formatSql();
        }

        function copyResult() {
            if (!outputEl.value) {
                showToast('Nothing to copy', 'error');
                return;
            }
            copyToClipboard(outputEl.value, 'SQL query copied!');
        }

        function clearAll() {
            inputEl.value = '';
            outputEl.value = '';
            inStats.textContent = '0 chars';
            outStats.textContent = '0 chars';
            showToast('Cleared');
        }
    </script>
    @endpush
</x-tool-layout>
