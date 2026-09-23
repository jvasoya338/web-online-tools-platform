/**
 * WebToolsStation - Image Batch 5 Engine
 * 100% Client-Side Canvas Image Processing & SVG Placeholder Generator
 */

let loadedImageObj = null;

function handleBatch5ImageUpload(input) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
            loadedImageObj = { file, img, width: img.width, height: img.height };
            const info = document.getElementById('b5-image-info');
            if (info) {
                info.textContent = `File: ${file.name} (${(file.size / 1024).toFixed(1)} KB) — Original: ${img.width} × ${img.height} px`;
            }

            // Set inputs if available
            const wInput = document.getElementById('resize-width');
            const hInput = document.getElementById('resize-height');
            if (wInput) wInput.value = img.width;
            if (hInput) hInput.value = img.height;

            showToast(`Loaded ${file.name} successfully.`);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// 85. Image Resizer
function runImageResizer() {
    if (!loadedImageObj) {
        setOutput('Please choose or upload an image file first.', true);
        return;
    }

    const targetWidth = parseInt(document.getElementById('resize-width')?.value || loadedImageObj.width, 10);
    const targetHeight = parseInt(document.getElementById('resize-height')?.value || loadedImageObj.height, 10);
    const format = document.getElementById('resize-format')?.value || 'image/png';
    const ext = format === 'image/jpeg' ? 'jpg' : (format === 'image/webp' ? 'webp' : 'png');

    const canvas = document.createElement('canvas');
    canvas.width = targetWidth;
    canvas.height = targetHeight;
    const ctx = canvas.getContext('2d');
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.drawImage(loadedImageObj.img, 0, 0, targetWidth, targetHeight);

    const dataUrl = canvas.toDataURL(format, 0.92);
    const downloadLink = document.getElementById('b5-download-btn');
    if (downloadLink) {
        downloadLink.href = dataUrl;
        downloadLink.download = `resized-${targetWidth}x${targetHeight}.${ext}`;
        downloadLink.style.display = 'inline-flex';
    }

    setOutput(`=== IMAGE RESIZE COMPLETED ===\nOriginal Dimensions: ${loadedImageObj.width} × ${loadedImageObj.height} px\nTarget Dimensions:   ${targetWidth} × ${targetHeight} px\nTarget Format:       ${ext.toUpperCase()}\n\nClick "Download Resized Image" below to save.`);
}

// 86. Image Cropper
function runImageCropper() {
    if (!loadedImageObj) {
        setOutput('Please choose or upload an image file first.', true);
        return;
    }

    const mode = document.getElementById('crop-mode')?.value || '1:1';
    let cropWidth = loadedImageObj.width;
    let cropHeight = loadedImageObj.height;

    if (mode === '1:1') {
        const side = Math.min(loadedImageObj.width, loadedImageObj.height);
        cropWidth = side;
        cropHeight = side;
    } else if (mode === '16:9') {
        if (loadedImageObj.width / loadedImageObj.height > 16 / 9) {
            cropHeight = loadedImageObj.height;
            cropWidth = Math.round(loadedImageObj.height * (16 / 9));
        } else {
            cropWidth = loadedImageObj.width;
            cropHeight = Math.round(loadedImageObj.width * (9 / 16));
        }
    } else if (mode === '4:3') {
        if (loadedImageObj.width / loadedImageObj.height > 4 / 3) {
            cropHeight = loadedImageObj.height;
            cropWidth = Math.round(loadedImageObj.height * (4 / 3));
        } else {
            cropWidth = loadedImageObj.width;
            cropHeight = Math.round(loadedImageObj.width * (3 / 4));
        }
    }

    const startX = Math.round((loadedImageObj.width - cropWidth) / 2);
    const startY = Math.round((loadedImageObj.height - cropHeight) / 2);

    const canvas = document.createElement('canvas');
    canvas.width = cropWidth;
    canvas.height = cropHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(loadedImageObj.img, startX, startY, cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);

    const dataUrl = canvas.toDataURL('image/png');
    const downloadLink = document.getElementById('b5-crop-download-btn');
    if (downloadLink) {
        downloadLink.href = dataUrl;
        downloadLink.download = `cropped-${mode.replace(':', 'x')}.png`;
        downloadLink.style.display = 'inline-flex';
    }

    setOutput(`=== IMAGE CROP COMPLETED ===\nOriginal: ${loadedImageObj.width} × ${loadedImageObj.height} px\nCropped Area: ${cropWidth} × ${cropHeight} px (Centered, Ratio: ${mode})\nFormat: PNG\n\nClick "Download Cropped Image" below to save.`);
}

// 87. Image to Base64 Converter
function runImageToBase64() {
    const fileInput = document.getElementById('img-to-b64-file');
    const file = fileInput?.files[0];
    if (!file) {
        setOutput('Select an image file (PNG, JPG, SVG, WebP) to convert.', true);
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        const dataUrl = e.target.result;
        const base64Raw = dataUrl.split(',')[1] || '';

        const output = [
            `=== BASE64 DATA URI OUTPUT ===`,
            `Source File: ${file.name}`,
            `MIME Type:   ${file.type}`,
            `Original:    ${(file.size / 1024).toFixed(1)} KB`,
            `Base64 Size: ${(base64Raw.length / 1024).toFixed(1)} KB (+33% transport encoding overhead)`,
            '',
            '--- HTML <img> TAG ---',
            `<img src="${dataUrl}" alt="${file.name}">`,
            '',
            '--- CSS BACKGROUND ---',
            `background-image: url("${dataUrl}");`,
            '',
            '--- RAW BASE64 DATA URI ---',
            dataUrl
        ].join('\n');

        setOutput(output);
    };
    reader.readAsDataURL(file);
}

// 88. Base64 to Image Converter
function runBase64ToImage() {
    let raw = (document.getElementById('b64-to-img-input')?.value || '').trim();
    if (!raw) {
        setOutput('Paste a Base64 string or data:image/*;base64,... URI to decode.', true);
        return;
    }

    if (!raw.startsWith('data:image/')) {
        raw = 'data:image/png;base64,' + raw;
    }

    const img = new Image();
    img.onload = () => {
        const preview = document.getElementById('b64-img-preview');
        if (preview) {
            preview.src = raw;
            preview.style.display = 'block';
        }

        const downloadLink = document.getElementById('b64-img-download-btn');
        if (downloadLink) {
            downloadLink.href = raw;
            downloadLink.download = 'decoded-image.png';
            downloadLink.style.display = 'inline-flex';
        }

        setOutput(`=== BASE64 IMAGE DECODED SUCCESSFULLY ===\nDimensions: ${img.width} × ${img.height} px\nData URI: ${raw.slice(0, 80)}...\n\nClick "Download Image" to save locally.`);
    };
    img.onerror = () => {
        setOutput('Error: Invalid Base64 image payload or corrupted image binary data.', true);
    };
    img.src = raw;
}

// 89. SVG Placeholder Generator
function runSvgPlaceholderGenerator() {
    const width = parseInt(document.getElementById('svg-w')?.value || '600', 10);
    const height = parseInt(document.getElementById('svg-h')?.value || '400', 10);
    const text = document.getElementById('svg-text')?.value || `${width} × ${height}`;
    const bgColor = document.getElementById('svg-bg')?.value || '#e2e8f0';
    const textColor = document.getElementById('svg-fg')?.value || '#475569';
    const fontSize = Math.max(12, Math.min(72, Math.round(Math.min(width, height) / 10)));

    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${width}" height="${height}" viewBox="0 0 ${width} ${height}">
  <rect width="${width}" height="${height}" fill="${bgColor}"/>
  <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="${fontSize}px" font-weight="600" fill="${textColor}">${escapeHtml(text)}</text>
</svg>`;

    const dataUri = `data:image/svg+xml;charset=utf-8,${encodeURIComponent(svg)}`;
    const preview = document.getElementById('svg-preview-img');
    if (preview) {
        preview.src = dataUri;
    }

    const downloadLink = document.getElementById('svg-download-btn');
    if (downloadLink) {
        const blob = new Blob([svg], { type: 'image/svg+xml;charset=utf-8' });
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = `placeholder-${width}x${height}.svg`;
        downloadLink.style.display = 'inline-flex';
    }

    const report = [
        '=== SVG PLACEHOLDER MARKUP ===',
        svg,
        '',
        '--- DATA URI (HTML & CSS) ---',
        dataUri
    ].join('\n');

    setOutput(report);
}
