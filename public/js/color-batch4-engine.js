/**
 * WebToolsStation - Color Batch 4 Engine
 * 100% Client-Side Color Conversions and Harmonies
 */

// 79. HEX to HSL Converter
function runHexToHsl() {
    const raw = (document.getElementById('hex-hsl-input')?.value || '#3b82f6').trim().replace('#', '');
    if (![3, 6].includes(raw.length) || /[^0-9a-f]/i.test(raw)) {
        setOutput('Please enter a valid 3-digit or 6-digit HEX color code (e.g. #3b82f6 or #f00).', true);
        return;
    }

    const hex = raw.length === 3 ? raw.split('').map(c => c + c).join('') : raw;
    const r = parseInt(hex.slice(0, 2), 16);
    const g = parseInt(hex.slice(2, 4), 16);
    const b = parseInt(hex.slice(4, 6), 16);

    const rNorm = r / 255, gNorm = g / 255, bNorm = b / 255;
    const max = Math.max(rNorm, gNorm, bNorm);
    const min = Math.min(rNorm, gNorm, bNorm);
    let h, s, l = (max + min) / 2;

    if (max === min) {
        h = s = 0;
    } else {
        const d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
            case rNorm: h = (gNorm - bNorm) / d + (gNorm < bNorm ? 6 : 0); break;
            case gNorm: h = (bNorm - rNorm) / d + 2; break;
            default: h = (rNorm - gNorm) / d + 4; break;
        }
        h /= 6;
    }

    const hDeg = Math.round(h * 360);
    const sPct = Math.round(s * 100);
    const lPct = Math.round(l * 100);

    const preview = document.getElementById('hex-hsl-preview');
    if (preview) preview.style.backgroundColor = `#${hex}`;

    const report = [
        '=== HEX TO HSL CONVERSION RESULT ===',
        `HEX Code: #${hex.toUpperCase()}`,
        `HSL: hsl(${hDeg}, ${sPct}%, ${lPct}%)`,
        `HSLA: hsla(${hDeg}, ${sPct}%, ${lPct}%, 1.0)`,
        `RGB: rgb(${r}, ${g}, ${b})`,
        '',
        'CSS Snippets:',
        `color: hsl(${hDeg}, ${sPct}%, ${lPct}%);`,
        `background-color: hsl(${hDeg}, ${sPct}%, ${lPct}%);`
    ].join('\n');

    setOutput(report);
}

// 80. Color Palette Generator
function hslToHex(h, s, l) {
    h = (h % 360 + 360) % 360;
    s /= 100;
    l /= 100;
    const a = s * Math.min(l, 1 - l);
    const f = n => {
        const k = (n + h / 30) % 12;
        const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
        return Math.round(255 * color).toString(16).padStart(2, '0');
    };
    return `#${f(0)}${f(8)}${f(4)}`.toUpperCase();
}

function hexToHslHelper(hexStr) {
    const raw = hexStr.replace('#', '');
    const hex = raw.length === 3 ? raw.split('').map(c => c + c).join('') : raw;
    const r = parseInt(hex.slice(0, 2), 16) / 255;
    const g = parseInt(hex.slice(2, 4), 16) / 255;
    const b = parseInt(hex.slice(4, 6), 16) / 255;
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
            default: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }
    return { h: Math.round(h * 360), s: Math.round(s * 100), l: Math.round(l * 100) };
}

function runColorPaletteGenerator() {
    const baseInput = (document.getElementById('palette-base-color')?.value || '#3b82f6').trim();
    if (!/^#?[0-9a-f]{3,6}$/i.test(baseInput)) {
        setOutput('Please enter a valid base HEX color (e.g. #3b82f6).', true);
        return;
    }

    const { h, s, l } = hexToHslHelper(baseInput);

    // Complementary: base + 180°
    const comp = [hslToHex(h, s, l), hslToHex(h + 180, s, l)];

    // Analogous: base - 30°, base, base + 30°
    const analogous = [hslToHex(h - 30, s, l), hslToHex(h, s, l), hslToHex(h + 30, s, l)];

    // Triadic: base, base + 120°, base + 240°
    const triadic = [hslToHex(h, s, l), hslToHex(h + 120, s, l), hslToHex(h + 240, s, l)];

    // Split Complementary: base, base + 150°, base + 210°
    const splitComp = [hslToHex(h, s, l), hslToHex(h + 150, s, l), hslToHex(h + 210, s, l)];

    // Monochromatic: base with varying lightness (20%, 40%, 60%, 80%)
    const mono = [
        hslToHex(h, s, Math.max(15, l - 30)),
        hslToHex(h, s, Math.max(25, l - 15)),
        hslToHex(h, s, l),
        hslToHex(h, s, Math.min(85, l + 15)),
        hslToHex(h, s, Math.min(95, l + 30))
    ];

    const report = [
        '=== HARMONIC COLOR PALETTES ===',
        `Base Color: ${hslToHex(h, s, l)} (HSL: ${h}°, ${s}%, ${l}%)`,
        '',
        '1. COMPLEMENTARY PALETTE:',
        `   • Primary:       ${comp[0]}`,
        `   • Complementary: ${comp[1]}`,
        '',
        '2. ANALOGOUS PALETTE:',
        `   • Harmonious 1:  ${analogous[0]}`,
        `   • Base Color:    ${analogous[1]}`,
        `   • Harmonious 2:  ${analogous[2]}`,
        '',
        '3. TRIADIC PALETTE:',
        `   • Color 1:       ${triadic[0]}`,
        `   • Color 2:       ${triadic[1]}`,
        `   • Color 3:       ${triadic[2]}`,
        '',
        '4. SPLIT-COMPLEMENTARY PALETTE:',
        `   • Base Color:    ${splitComp[0]}`,
        `   • Split 1:       ${splitComp[1]}`,
        `   • Split 2:       ${splitComp[2]}`,
        '',
        '5. MONOCHROMATIC SCALE:',
        mono.map((c, i) => `   • Shade/Tint ${i + 1}: ${c}`).join('\n')
    ].join('\n');

    setOutput(report);
}
