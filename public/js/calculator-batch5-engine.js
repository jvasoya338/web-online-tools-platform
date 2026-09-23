/**
 * WebToolsStation - Calculator Batch 5 Engine
 * 100% Client-Side Mathematical, Screen Ratio & Storage Calculations
 */

// 90. Percentage Calculator
function runPercentageCalculator() {
    const mode = document.getElementById('pct-mode')?.value || 'what_is';
    const x = parseFloat(document.getElementById('pct-x')?.value || '15');
    const y = parseFloat(document.getElementById('pct-y')?.value || '200');

    if (isNaN(x) || isNaN(y)) {
        setOutput('Please enter valid numeric values for X and Y.', true);
        return;
    }

    let resultText = '';
    if (mode === 'what_is') {
        // What is X% of Y?
        const ans = (x / 100) * y;
        resultText = [
            `Question: What is ${x}% of ${y}?`,
            `Answer:   ${ans}`,
            `Formula:  (${x} ÷ 100) × ${y} = ${ans}`
        ].join('\n');
    } else if (mode === 'is_what_pct') {
        // X is what % of Y?
        if (y === 0) return setOutput('Error: Division by zero (Y cannot be 0).', true);
        const ans = (x / y) * 100;
        resultText = [
            `Question: ${x} is what percent of ${y}?`,
            `Answer:   ${ans.toFixed(4)}%`,
            `Formula:  (${x} ÷ ${y}) × 100 = ${ans.toFixed(4)}%`
        ].join('\n');
    } else if (mode === 'pct_change') {
        // Percentage increase/decrease from X to Y
        if (x === 0) return setOutput('Error: Initial value X cannot be 0 for percent change calculation.', true);
        const diff = y - x;
        const change = (diff / x) * 100;
        const type = change >= 0 ? 'Increase (+)' : 'Decrease (-)';
        resultText = [
            `Question: Percent change from ${x} to ${y}?`,
            `Result:   ${type} ${Math.abs(change).toFixed(4)}%`,
            `Absolute Difference: ${diff}`,
            `Formula:  ((${y} - ${x}) ÷ ${x}) × 100 = ${change.toFixed(4)}%`
        ].join('\n');
    }

    setOutput(`=== PERCENTAGE CALCULATION ===\n\n${resultText}`);
}

// 91. Aspect Ratio Calculator
function gcd(a, b) {
    return b === 0 ? a : gcd(b, a % b);
}

function runAspectRatioCalculator() {
    const w = parseInt(document.getElementById('ar-w')?.value || '1920', 10);
    const h = parseInt(document.getElementById('ar-h')?.value || '1080', 10);

    if (isNaN(w) || isNaN(h) || w <= 0 || h <= 0) {
        setOutput('Please enter positive integer pixel dimensions.', true);
        return;
    }

    const divisor = gcd(w, h);
    const ratioW = w / divisor;
    const ratioH = h / divisor;
    const decimalRatio = (w / h).toFixed(4);

    const commonRatios = {
        '16:9': 'Widescreen (HD, 4K, YouTube, TV)',
        '4:3': 'Standard Display / Photography',
        '1:1': 'Square (Social Media / Instagram)',
        '21:9': 'Ultrawide Cinema Display',
        '9:16': 'Vertical Video (Reels, TikTok, Shorts)',
        '3:2': 'Classic 35mm Photography'
    };

    const ratioStr = `${ratioW}:${ratioH}`;
    const name = commonRatios[ratioStr] ? `(${commonRatios[ratioStr]})` : '';

    const scaledResolutions = [
        { label: 'HD 720p', w: Math.round(720 * (w / h)), h: 720 },
        { label: 'FHD 1080p', w: Math.round(1080 * (w / h)), h: 1080 },
        { label: 'QHD 1440p', w: Math.round(1440 * (w / h)), h: 1440 },
        { label: '4K UHD 2160p', w: Math.round(2160 * (w / h)), h: 2160 }
    ];

    const report = [
        '=== ASPECT RATIO ANALYSIS ===',
        `Original Input:     ${w} × ${h} px`,
        `Simplest Ratio:     ${ratioStr} ${name}`,
        `Decimal Aspect:     ${decimalRatio} : 1`,
        `Total Pixels:       ${(w * h).toLocaleString()} px (${((w * h) / 1000000).toFixed(2)} Megapixels)`,
        '',
        '--- PROPORTIONAL SCALE PRESETS ---',
        scaledResolutions.map(s => `  • ${s.label}: ${s.w} × ${s.h} px`).join('\n')
    ].join('\n');

    setOutput(report);
}

// 92. Date Difference Calculator
function runDateDifferenceCalculator() {
    const startVal = document.getElementById('date-start')?.value;
    const endVal = document.getElementById('date-end')?.value;

    if (!startVal || !endVal) {
        setOutput('Please select both a Start Date and an End Date.', true);
        return;
    }

    const d1 = new Date(startVal);
    const d2 = new Date(endVal);

    const diffMs = Math.abs(d2.getTime() - d1.getTime());
    const totalDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    const totalWeeks = (totalDays / 7).toFixed(1);
    const totalHours = Math.floor(diffMs / (1000 * 60 * 60));
    const totalMinutes = Math.floor(diffMs / (1000 * 60));

    // Approximate Years and Months
    const earlier = d1 < d2 ? d1 : d2;
    const later = d1 < d2 ? d2 : d1;

    let years = later.getFullYear() - earlier.getFullYear();
    let months = later.getMonth() - earlier.getMonth();
    let days = later.getDate() - earlier.getDate();

    if (days < 0) {
        months -= 1;
        const prevMonth = new Date(later.getFullYear(), later.getMonth(), 0);
        days += prevMonth.getDate();
    }
    if (months < 0) {
        years -= 1;
        months += 12;
    }

    const report = [
        '=== DATE DURATION & DIFFERENCE ===',
        `Start Date: ${d1.toDateString()}`,
        `End Date:   ${d2.toDateString()}`,
        '',
        `Calendar Duration: ${years} Year(s), ${months} Month(s), ${days} Day(s)`,
        '',
        '--- TOTAL TIME INTERVALS ---',
        `  • Total Days:    ${totalDays.toLocaleString()} days`,
        `  • Total Weeks:   ${totalWeeks} weeks`,
        `  • Total Hours:   ${totalHours.toLocaleString()} hours`,
        `  • Total Minutes: ${totalMinutes.toLocaleString()} minutes`
    ].join('\n');

    setOutput(report);
}

// 93. Data Storage Converter
function runDataStorageConverter() {
    const value = parseFloat(document.getElementById('storage-val')?.value || '100');
    const unit = document.getElementById('storage-unit')?.value || 'GB';

    if (isNaN(value) || value < 0) {
        setOutput('Please enter a valid positive storage amount.', true);
        return;
    }

    const toBytesMultiplier = {
        'B': 1,
        'KB': 1e3, 'MB': 1e6, 'GB': 1e9, 'TB': 1e12, 'PB': 1e15,
        'KiB': 1024, 'MiB': 1024 ** 2, 'GiB': 1024 ** 3, 'TiB': 1024 ** 4, 'PiB': 1024 ** 5
    };

    const totalBytes = value * (toBytesMultiplier[unit] || 1);

    const report = [
        '=== DIGITAL STORAGE CONVERSION MATRIX ===',
        `Input: ${value} ${unit} (${totalBytes.toLocaleString()} Bytes)`,
        '',
        '--- DECIMAL SI UNITS (BASE 1000) ---',
        `  • Bytes (B):          ${totalBytes.toLocaleString()}`,
        `  • Kilobytes (KB):     ${(totalBytes / 1e3).toLocaleString()} KB`,
        `  • Megabytes (MB):     ${(totalBytes / 1e6).toLocaleString()} MB`,
        `  • Gigabytes (GB):     ${(totalBytes / 1e9).toFixed(6)} GB`,
        `  • Terabytes (TB):     ${(totalBytes / 1e12).toFixed(9)} TB`,
        '',
        '--- BINARY IEC UNITS (BASE 1024) ---',
        `  • Kibibytes (KiB):    ${(totalBytes / 1024).toFixed(3)} KiB`,
        `  • Mebibytes (MiB):    ${(totalBytes / (1024 ** 2)).toFixed(4)} MiB`,
        `  • Gibibytes (GiB):    ${(totalBytes / (1024 ** 3)).toFixed(6)} GiB`,
        `  • Tebibytes (TiB):    ${(totalBytes / (1024 ** 4)).toFixed(9)} TiB`
    ].join('\n');

    setOutput(report);
}

// 94. Download Time Calculator
function runDownloadTimeCalculator() {
    const fileSize = parseFloat(document.getElementById('dl-size')?.value || '5');
    const sizeUnit = document.getElementById('dl-size-unit')?.value || 'GB';
    const speed = parseFloat(document.getElementById('dl-speed')?.value || '100');
    const speedUnit = document.getElementById('dl-speed-unit')?.value || 'Mbps';

    if (isNaN(fileSize) || isNaN(speed) || fileSize <= 0 || speed <= 0) {
        setOutput('Please enter positive numbers for File Size and Connection Speed.', true);
        return;
    }

    // Convert size to Megabits (Mbit)
    let sizeInMb = fileSize;
    if (sizeUnit === 'KB') sizeInMb = fileSize / 1024;
    else if (sizeUnit === 'MB') sizeInMb = fileSize;
    else if (sizeUnit === 'GB') sizeInMb = fileSize * 1024;
    else if (sizeUnit === 'TB') sizeInMb = fileSize * 1024 * 1024;

    const sizeInMbits = sizeInMb * 8; // 1 Byte = 8 bits

    // Convert speed to Mbps
    let speedInMbps = speed;
    if (speedUnit === 'Kbps') speedInMbps = speed / 1000;
    else if (speedUnit === 'Gbps') speedInMbps = speed * 1000;

    const totalSeconds = sizeInMbits / speedInMbps;
    const overheadSeconds = totalSeconds * 1.08; // 8% TCP/IP framing overhead

    function formatSecs(s) {
        const hrs = Math.floor(s / 3600);
        const mins = Math.floor((s % 3600) / 60);
        const secs = Math.round(s % 60);
        const parts = [];
        if (hrs > 0) parts.push(`${hrs} hour(s)`);
        if (mins > 0 || hrs > 0) parts.push(`${mins} minute(s)`);
        parts.push(`${secs} second(s)`);
        return parts.join(', ');
    }

    const report = [
        '=== ESTIMATED DOWNLOAD & TRANSFER TIME ===',
        `File Size:        ${fileSize} ${sizeUnit} (${sizeInMbits.toLocaleString()} Mbits)`,
        `Bandwidth Speed:  ${speed} ${speedUnit}`,
        '',
        `Theoretical Time: ${formatSecs(totalSeconds)} (${totalSeconds.toFixed(1)}s)`,
        `Real-World (+8%): ${formatSecs(overheadSeconds)} (${overheadSeconds.toFixed(1)}s)`,
        '',
        '--- COMMON SPEEDS COMPARISON ---',
        `  • 5G / Fiber (1 Gbps):  ${formatSecs(sizeInMbits / 1000)}`,
        `  • Fast Broadband (100 Mbps): ${formatSecs(sizeInMbits / 100)}`,
        `  • Standard 4G (25 Mbps): ${formatSecs(sizeInMbits / 25)}`,
        `  • Mobile 3G (5 Mbps):   ${formatSecs(sizeInMbits / 5)}`
    ].join('\n');

    setOutput(report);
}
