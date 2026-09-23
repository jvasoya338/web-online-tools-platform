/**
 * WebToolsStation - Color Batch 5 Engine
 * 100% Client-Side Gradient, Contrast, Shades/Tints & CSS Variable Generators
 */

// 81. CSS Gradient Generator
function runCssGradientGenerator() {
    const type = document.getElementById('grad-type')?.value || 'linear';
    const angle = document.getElementById('grad-angle')?.value || '90';
    const color1 = document.getElementById('grad-color1')?.value || '#3b82f6';
    const color2 = document.getElementById('grad-color2')?.value || '#9333ea';
    const color3 = document.getElementById('grad-color3')?.value || '';

    let cssGradient = '';
    const stops = [color1, color2];
    if (color3.trim()) stops.push(color3.trim());

    if (type === 'linear') {
        cssGradient = `linear-gradient(${angle}deg, ${stops.join(', ')})`;
    } else if (type === 'radial') {
        cssGradient = `radial-gradient(circle, ${stops.join(', ')})`;
    } else if (type === 'conic') {
        cssGradient = `conic-gradient(from ${angle}deg, ${stops.join(', ')})`;
    }

    const preview = document.getElementById('gradient-preview');
    if (preview) {
        preview.style.background = cssGradient;
    }

    const cssOutput = [
        '/* CSS Gradient Output */',
        `background: ${color1}; /* Fallback */`,
        `background: ${cssGradient};`,
        '',
        '/* Tailwind CSS / Modern CSS Snippet */',
        `style="background: ${cssGradient};"`
    ].join('\n');

    setOutput(cssOutput);
}

// 82. WCAG Contrast Checker
function getLuminance(r, g, b) {
    const a = [r, g, b].map(v => {
        v /= 255;
        return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
    });
    return a[0] * 0.2126 + a[1] * 0.7152 + a[2] * 0.0722;
}

function hexToRgbVals(hexStr) {
    const hex = hexStr.replace('#', '').trim();
    const fullHex = hex.length === 3 ? hex.split('').map(c => c + c).join('') : hex;
    const r = parseInt(fullHex.slice(0, 2), 16) || 0;
    const g = parseInt(fullHex.slice(2, 4), 16) || 0;
    const b = parseInt(fullHex.slice(4, 6), 16) || 0;
    return { r, g, b };
}

function runWcagContrastChecker() {
    const fgHex = document.getElementById('wcag-fg')?.value || '#1e293b';
    const bgHex = document.getElementById('wcag-bg')?.value || '#ffffff';

    const fg = hexToRgbVals(fgHex);
    const bg = hexToRgbVals(bgHex);

    const lumFg = getLuminance(fg.r, fg.g, fg.b);
    const lumBg = getLuminance(bg.r, bg.g, bg.b);

    const brightest = Math.max(lumFg, lumBg);
    const darkest = Math.min(lumFg, lumBg);
    const ratio = ((brightest + 0.05) / (darkest + 0.05));
    const ratioFormatted = ratio.toFixed(2);

    const preview = document.getElementById('wcag-preview');
    if (preview) {
        preview.style.color = fgHex;
        preview.style.backgroundColor = bgHex;
    }

    const passAaNormal = ratio >= 4.5;
    const passAaLarge = ratio >= 3.0;
    const passAaaNormal = ratio >= 7.0;
    const passAaaLarge = ratio >= 4.5;
    const passUiComponents = ratio >= 3.0;

    const report = [
        '=== WCAG 2.1 COLOR CONTRAST AUDIT ===',
        `Foreground (Text): ${fgHex.toUpperCase()} | RGB(${fg.r}, ${fg.g}, ${fg.b})`,
        `Background:        ${bgHex.toUpperCase()} | RGB(${bg.r}, ${bg.g}, ${bg.b})`,
        `Contrast Ratio:    ${ratioFormatted} : 1`,
        '',
        '--- ACCESSIBILITY COMPLIANCE RESULTS ---',
        `WCAG AA (Normal Text, < 18pt):  ${passAaNormal ? '✅ PASS (Req: 4.5:1)' : '❌ FAIL (Req: 4.5:1)'}`,
        `WCAG AA (Large Text, >= 18pt):   ${passAaLarge ? '✅ PASS (Req: 3.0:1)' : '❌ FAIL (Req: 3.0:1)'}`,
        `WCAG AAA (Normal Text, < 18pt): ${passAaaNormal ? '✅ PASS (Req: 7.0:1)' : '❌ FAIL (Req: 7.0:1)'}`,
        `WCAG AAA (Large Text, >= 18pt):  ${passAaaLarge ? '✅ PASS (Req: 4.5:1)' : '❌ FAIL (Req: 4.5:1)'}`,
        `UI Components & Icons:          ${passUiComponents ? '✅ PASS (Req: 3.0:1)' : '❌ FAIL (Req: 3.0:1)'}`,
        '',
        'Summary Assessment:',
        ratio >= 7.0 ? '🌟 Exceptional contrast. Fully compliant with all WCAG AAA strict accessibility criteria.' :
        ratio >= 4.5 ? '👍 Good contrast. Meets standard WCAG AA guidelines for all standard and large web text.' :
        ratio >= 3.0 ? '⚠️ Moderate contrast. Acceptable only for large headings (18pt+) or decorative UI components.' :
        '❌ Poor contrast. Does not meet minimum accessibility guidelines. Increase contrast for readability.'
    ].join('\n');

    setOutput(report);
}

// 83. Color Shades & Tints Generator
function runColorShadesTints() {
    const baseHex = document.getElementById('shades-base')?.value || '#3b82f6';
    const { r, g, b } = hexToRgbVals(baseHex);

    const tints = []; // Lighter (mixed with white: 255,255,255)
    for (let i = 10; i >= 1; i--) {
        const factor = i / 11;
        const tr = Math.round(r + (255 - r) * factor);
        const tg = Math.round(g + (255 - g) * factor);
        const tb = Math.round(b + (255 - b) * factor);
        tints.push(`#${tr.toString(16).padStart(2,'0')}${tg.toString(16).padStart(2,'0')}${tb.toString(16).padStart(2,'0')}`.toUpperCase());
    }

    const shades = []; // Darker (mixed with black: 0,0,0)
    for (let i = 1; i <= 10; i++) {
        const factor = 1 - (i / 11);
        const sr = Math.round(r * factor);
        const sg = Math.round(g * factor);
        const sb = Math.round(b * factor);
        shades.push(`#${sr.toString(16).padStart(2,'0')}${sg.toString(16).padStart(2,'0')}${sb.toString(16).padStart(2,'0')}`.toUpperCase());
    }

    const report = [
        '=== COLOR SHADES & TINTS PALETTE ===',
        `Base Color: ${baseHex.toUpperCase()} | RGB(${r}, ${g}, ${b})`,
        '',
        '--- 10 TINTS (LIGHTER) ---',
        tints.map((hex, idx) => `  Tint ${idx + 1} (Light +${(10 - idx) * 9}%): ${hex}`).join('\n'),
        '',
        `  Base Color (100%): ${baseHex.toUpperCase()}`,
        '',
        '--- 10 SHADES (DARKER) ---',
        shades.map((hex, idx) => `  Shade ${idx + 1} (Dark -${(idx + 1) * 9}%): ${hex}`).join('\n')
    ].join('\n');

    setOutput(report);
}

// 84. CSS Variable Color Generator
function runCssVariableGenerator() {
    const primary = document.getElementById('theme-primary')?.value || '#3b82f6';
    const secondary = document.getElementById('theme-secondary')?.value || '#64748b';
    const accent = document.getElementById('theme-accent')?.value || '#f59e0b';
    const bgLight = document.getElementById('theme-bg-light')?.value || '#ffffff';
    const surfaceLight = document.getElementById('theme-surface-light')?.value || '#f8fafc';
    const textLight = document.getElementById('theme-text-light')?.value || '#0f172a';

    const bgDark = document.getElementById('theme-bg-dark')?.value || '#090d16';
    const surfaceDark = document.getElementById('theme-surface-dark')?.value || '#131c2e';
    const textDark = document.getElementById('theme-text-dark')?.value || '#f8fafc';

    const css = [
        '/* WebToolsStation - Standard Design Tokens */',
        ':root {',
        `  --color-primary: ${primary};`,
        `  --color-secondary: ${secondary};`,
        `  --color-accent: ${accent};`,
        '',
        '  /* Light Mode Tokens */',
        `  --color-bg: ${bgLight};`,
        `  --color-surface: ${surfaceLight};`,
        `  --color-text: ${textLight};`,
        `  --color-border: rgba(0, 0, 0, 0.1);`,
        '}',
        '',
        '@media (prefers-color-scheme: dark) {',
        '  :root {',
        `    --color-bg: ${bgDark};`,
        `    --color-surface: ${surfaceDark};`,
        `    --color-text: ${textDark};`,
        `    --color-border: rgba(255, 255, 255, 0.1);`,
        '  }',
        '}',
        '',
        '[data-theme="dark"] {',
        `  --color-bg: ${bgDark};`,
        `  --color-surface: ${surfaceDark};`,
        `  --color-text: ${textDark};`,
        `  --color-border: rgba(255, 255, 255, 0.1);`,
        '}'
    ].join('\n');

    setOutput(css);
}
