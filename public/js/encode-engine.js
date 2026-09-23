/**
 * WebToolsStation - Encode & Decode Engine
 * Base32, Base58, Base85, Hex, ASCII, Octal, ROT13, Morse, Punycode, Data URI
 */

// 42. Base32 (RFC 4648)
function runBase32(mode = 'encode') {
    const input = document.getElementById("b32-input")?.value || '';
    const outputEl = document.getElementById("b32-output");
    if (!outputEl) return;

    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    if (mode === 'encode') {
        const bytes = new TextEncoder().encode(input);
        let bits = 0, value = 0, output = '';
        for (let i = 0; i < bytes.length; i++) {
            value = (value << 8) | bytes[i];
            bits += 8;
            while (bits >= 5) {
                output += alphabet[(value >>> (bits - 5)) & 31];
                bits -= 5;
            }
        }
        if (bits > 0) output += alphabet[(value << (5 - bits)) & 31];
        while (output.length % 8 !== 0) output += '=';
        outputEl.value = output;
    } else {
        try {
            const clean = input.replace(/=+$/, '').toUpperCase();
            let bits = 0, value = 0;
            const bytes = [];
            for (let i = 0; i < clean.length; i++) {
                const idx = alphabet.indexOf(clean[i]);
                if (idx === -1) throw new Error('Invalid Base32 character: ' + clean[i]);
                value = (value << 5) | idx;
                bits += 5;
                if (bits >= 8) {
                    bytes.push((value >>> (bits - 8)) & 255);
                    bits -= 8;
                }
            }
            outputEl.value = new TextDecoder().decode(new Uint8Array(bytes));
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
        }
    }
}

// 43. Base58 (Bitcoin / IPFS)
const B58_ALPHABET = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
function runBase58(mode = 'encode') {
    const input = document.getElementById("b58-input")?.value || '';
    const outputEl = document.getElementById("b58-output");
    if (!outputEl) return;

    if (!input) {
        outputEl.value = '';
        return;
    }

    if (mode === 'encode') {
        const bytes = new TextEncoder().encode(input);
        let num = 0n;
        for (const b of bytes) num = (num << 8n) + BigInt(b);
        let str = '';
        while (num > 0n) {
            str = B58_ALPHABET[Number(num % 58n)] + str;
            num = num / 58n;
        }
        for (const b of bytes) {
            if (b === 0) str = '1' + str;
            else break;
        }
        outputEl.value = str;
    } else {
        try {
            let num = 0n;
            for (const c of input.trim()) {
                const idx = B58_ALPHABET.indexOf(c);
                if (idx === -1) throw new Error(`Invalid Base58 char: ${c}`);
                num = num * 58n + BigInt(idx);
            }
            const bytes = [];
            while (num > 0n) {
                bytes.unshift(Number(num & 255n));
                num = num >> 8n;
            }
            for (const c of input.trim()) {
                if (c === '1') bytes.unshift(0);
                else break;
            }
            outputEl.value = new TextDecoder().decode(new Uint8Array(bytes));
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
        }
    }
}

// 44. Base85 (Ascii85)
function runBase85(mode = 'encode') {
    const input = document.getElementById("b85-input")?.value || '';
    const outputEl = document.getElementById("b85-output");
    if (!outputEl) return;

    if (mode === 'encode') {
        const bytes = new TextEncoder().encode(input);
        let res = '<~';
        let i = 0;
        while (i < bytes.length) {
            const chunk = [bytes[i] || 0, bytes[i+1] || 0, bytes[i+2] || 0, bytes[i+3] || 0];
            const num = ((chunk[0] << 24) >>> 0) + (chunk[1] << 16) + (chunk[2] << 8) + chunk[3];
            const count = Math.min(4, bytes.length - i);
            if (num === 0 && count === 4) {
                res += 'z';
            } else {
                let d = [];
                let temp = num;
                for (let k = 0; k < 5; k++) {
                    d.unshift(String.fromCharCode(33 + (temp % 85)));
                    temp = Math.floor(temp / 85);
                }
                res += d.slice(0, count + 1).join('');
            }
            i += 4;
        }
        res += '~>';
        outputEl.value = res;
    } else {
        try {
            let clean = input.replace(/^<~|~>$/g, '').replace(/\s+/g, '');
            let bytes = [];
            let i = 0;
            while (i < clean.length) {
                if (clean[i] === 'z') {
                    bytes.push(0, 0, 0, 0);
                    i++;
                    continue;
                }
                let count = Math.min(5, clean.length - i);
                let num = 0;
                for (let k = 0; k < 5; k++) {
                    const c = i + k < clean.length ? clean.charCodeAt(i + k) - 33 : 84;
                    num = num * 85 + c;
                }
                for (let k = 0; k < count - 1; k++) {
                    bytes.push((num >>> (24 - k * 8)) & 255);
                }
                i += count;
            }
            outputEl.value = new TextDecoder().decode(new Uint8Array(bytes));
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
        }
    }
}

// 45. Hex String Encoder & Decoder
function runHexString(mode = 'encode') {
    const input = document.getElementById("hex-str-input")?.value || '';
    const outputEl = document.getElementById("hex-str-output");
    if (!outputEl) return;

    if (mode === 'encode') {
        const bytes = new TextEncoder().encode(input);
        const hex = Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join(' ');
        outputEl.value = hex;
    } else {
        try {
            const clean = input.replace(/0x|\s|,|:/g, '');
            if (clean.length % 2 !== 0) throw new Error('Hex string must have an even number of digits.');
            const bytes = [];
            for (let i = 0; i < clean.length; i += 2) {
                const b = parseInt(clean.substr(i, 2), 16);
                if (isNaN(b)) throw new Error('Invalid hex character');
                bytes.push(b);
            }
            outputEl.value = new TextDecoder().decode(new Uint8Array(bytes));
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
        }
    }
}

// 46. ASCII to Decimal Converter
function runAsciiDecimal() {
    const input = document.getElementById("ascii-dec-input")?.value || '';
    const tableBody = document.getElementById("ascii-dec-table");
    if (!tableBody) return;

    if (!input) {
        tableBody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:16px; color:var(--text-muted);">Enter text to inspect ASCII codes.</td></tr>';
        return;
    }

    const rows = [];
    for (let i = 0; i < input.length; i++) {
        const char = input[i];
        const code = char.charCodeAt(0);
        rows.push(`
            <tr style="border-bottom:1px solid var(--border);">
                <td style="padding:6px 12px; font-weight:700;">${char === ' ' ? '<span style="color:var(--text-muted);">(space)</span>' : escapeHtmlString(char)}</td>
                <td style="padding:6px 12px; font-weight:700; color:var(--brand);">${code}</td>
                <td style="padding:6px 12px; font-family:var(--font-mono);">0x${code.toString(16).toUpperCase().padStart(2, '0')}</td>
                <td style="padding:6px 12px; font-family:var(--font-mono); font-size:0.8rem;">${code.toString(2).padStart(8, '0')}</td>
            </tr>
        `);
    }
    tableBody.innerHTML = rows.join('');
}

// 47. Octal to Text & Text to Octal
function runOctalText(mode = 'encode') {
    const input = document.getElementById("octal-input")?.value || '';
    const outputEl = document.getElementById("octal-output");
    if (!outputEl) return;

    if (mode === 'encode') {
        const bytes = new TextEncoder().encode(input);
        const octals = Array.from(bytes).map(b => b.toString(8).padStart(3, '0')).join(' ');
        outputEl.value = octals;
    } else {
        try {
            const tokens = input.trim().split(/\s+/).filter(Boolean);
            const bytes = tokens.map(t => {
                const n = parseInt(t, 8);
                if (isNaN(n) || n > 255) throw new Error(`Invalid octal byte: ${t}`);
                return n;
            });
            outputEl.value = new TextDecoder().decode(new Uint8Array(bytes));
        } catch (e) {
            outputEl.value = `Error: ${e.message}`;
        }
    }
}

// 48. ROT13 / Caesar Cipher
function runRot13() {
    const input = document.getElementById("rot13-input")?.value || '';
    const shift = parseInt(document.getElementById("rot13-shift")?.value || '13', 10);
    const outputEl = document.getElementById("rot13-output");
    if (!outputEl) return;

    let res = '';
    for (let i = 0; i < input.length; i++) {
        const c = input[i];
        if (/[a-z]/.test(c)) {
            res += String.fromCharCode(((c.charCodeAt(0) - 97 + shift) % 26) + 97);
        } else if (/[A-Z]/.test(c)) {
            res += String.fromCharCode(((c.charCodeAt(0) - 65 + shift) % 26) + 65);
        } else {
            res += c;
        }
    }
    outputEl.value = res;
}

// 49. Morse Code Translator
const MORSE_MAP = {
    'A': '.-', 'B': '-...', 'C': '-.-.', 'D': '-..', 'E': '.', 'F': '..-.', 'G': '--.', 'H': '....',
    'I': '..', 'J': '.---', 'K': '-.-', 'L': '.-..', 'M': '--', 'N': '-.', 'O': '---', 'P': '.--.',
    'Q': '--.-', 'R': '.-.', 'S': '...', 'T': '-', 'U': '..-', 'V': '...-', 'W': '.--', 'X': '-..-',
    'Y': '-.--', 'Z': '--..', '1': '.----', '2': '..---', '3': '...--', '4': '....-', '5': '.....',
    '6': '-....', '7': '--...', '8': '---..', '9': '----.', '0': '-----', ' ': '/'
};
const REVERSE_MORSE = Object.fromEntries(Object.entries(MORSE_MAP).map(([k, v]) => [v, k]));

function runMorseCode(mode = 'encode') {
    const input = document.getElementById("morse-input")?.value || '';
    const outputEl = document.getElementById("morse-output");
    if (!outputEl) return;

    if (mode === 'encode') {
        const clean = input.toUpperCase();
        const morse = Array.from(clean).map(c => MORSE_MAP[c] || c).join(' ');
        outputEl.value = morse;
    } else {
        const tokens = input.trim().split(/\s+/);
        const text = tokens.map(t => REVERSE_MORSE[t] || (t === '/' ? ' ' : '?')).join('');
        outputEl.value = text;
    }
}

// 50. Punycode / IDN Converter
function runPunycode(mode = 'encode') {
    const input = document.getElementById("punycode-input")?.value.trim() || '';
    const outputEl = document.getElementById("punycode-output");
    if (!outputEl) return;

    try {
        if (mode === 'encode') {
            // Native URL parser auto-converts hostname to punycode
            const dummy = new URL('http://' + input);
            outputEl.value = dummy.hostname;
        } else {
            outputEl.value = input.startsWith('xn--') ? decodeURI(input) : input;
        }
    } catch (e) {
        outputEl.value = input;
    }
}

// 51. Data URI Generator
function runDataUri() {
    const input = document.getElementById("datauri-input")?.value || '';
    const mime = document.getElementById("datauri-mime")?.value || 'text/plain';
    const outputEl = document.getElementById("datauri-output");
    if (!outputEl) return;

    const base64 = btoa(unescape(encodeURIComponent(input)));
    outputEl.value = `data:${mime};charset=utf-8;base64,${base64}`;
}
