<div class="workspace-split">
    <!-- Left: Color Swatch & Picker -->
    <div class="pane-card" style="padding:24px; align-items:center; justify-content:center; text-align:center;">
        <div id="color-preview" style="width:160px; height:160px; border-radius:18px; border:3px solid #ffffff; box-shadow:0 8px 24px rgba(0,0,0,0.12); margin-bottom:18px; background:#0284c7; transition:background-color 0.2s;"></div>

        <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
            <input type="color" id="native-color-picker" value="#0284c7" style="width:44px; height:44px; border:none; border-radius:8px; cursor:pointer; padding:0;" title="Click to choose a color">
            <span style="font-size:0.88rem; font-weight:600; color:var(--text);">Pick Color Visually</span>
        </div>

        <div style="font-size:0.82rem; color:var(--text-muted); max-width:280px;">
            Select a color using the palette or type standard HEX, RGB, or HSL values in the input on the right.
        </div>
    </div>

    <!-- Right: Color Inputs & Format Output -->
    <div class="pane-card" style="padding:20px; gap:16px;">
        <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
            Color Value Formats
        </div>

        @if ($tool['slug'] === 'color-converter')
            <div>
                <label for="color-input" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Color Input (HEX, RGB, or HSL):</label>
                <div style="display:flex; gap:8px;">
                    <input id="color-input" type="text" placeholder="#0284c7 or rgb(2,132,199)" value="#0284C7" style="flex:1; font-family:var(--font-mono);" oninput="convertColor()">
                    <button class="btn btn-primary" onclick="convertColor()">Convert</button>
                </div>
            </div>

        @elseif ($tool['slug'] === 'hex-to-rgb-converter')
            <div>
                <label for="hex-input" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">HEX Code:</label>
                <div style="display:flex; gap:8px;">
                    <input id="hex-input" type="text" placeholder="#0284C7" value="#0284C7" style="flex:1; font-family:var(--font-mono);" oninput="convertHexToRgb()">
                    <button class="btn btn-primary" onclick="convertHexToRgb()">Convert to RGB</button>
                </div>
            </div>

        @elseif ($tool['slug'] === 'rgb-to-hex-converter')
            <div>
                <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">RGB Components (0 - 255):</label>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:8px;">
                    <div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">Red:</span>
                        <input id="rgb-red" type="number" min="0" max="255" value="2" style="width:100%; font-family:var(--font-mono);" oninput="convertRgbToHex()">
                    </div>
                    <div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">Green:</span>
                        <input id="rgb-green" type="number" min="0" max="255" value="132" style="width:100%; font-family:var(--font-mono);" oninput="convertRgbToHex()">
                    </div>
                    <div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">Blue:</span>
                        <input id="rgb-blue" type="number" min="0" max="255" value="199" style="width:100%; font-family:var(--font-mono);" oninput="convertRgbToHex()">
                    </div>
                </div>
                <button class="btn btn-primary" style="margin-top:10px;" onclick="convertRgbToHex()">Convert to HEX</button>
            </div>
        @endif

        <div style="border-top:1px solid var(--border); padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:0.82rem; font-weight:600; color:var(--text-muted);">Computed Values:</span>
            <button class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">Copy Result</button>
        </div>
        <pre id="tool-output" class="output-pre" style="height:160px;" aria-label="Color conversion result"></pre>
    </div>
</div>