// ===== Palet Warna (sesuai screenshot) =====
const PALETTE = [
    // Baris 1 - merah ke abu
    '#cc0000', '#e06000', '#d4b000', '#6aaa00', '#008800', '#009999', '#0055cc', '#7700cc',
    // Baris 2
    '#ff3333', '#ff8800', '#ffcc00', '#88cc00', '#00aa44', '#00cccc', '#3399ff', '#aa44ff',
    // Baris 3
    '#ff6666', '#ffaa44', '#ffe066', '#aad966', '#44cc88', '#66dddd', '#66aaff', '#cc88ff',
    // Baris 4 - gelap
    '#660000', '#663300', '#665500', '#336600', '#003322', '#004455', '#002266', '#330066',
    // Baris 5 - abu-abu
    '#111111', '#333333', '#555555', '#777777', '#999999', '#bbbbbb', '#dddddd', '#ffffff',
];

let targetField = null;   // 'bg' atau 'text'
let selectedColor = null;   // warna yang sedang dipilih di modal

// ===== Render grid warna =====
function renderGrid() {
    const grid = document.getElementById('color-grid');
    grid.innerHTML = '';
    PALETTE.forEach(hex => {
        const div = document.createElement('div');
        div.className = 'swatch';
        div.style.backgroundColor = hex;
        div.dataset.color = hex;
        div.title = hex;
        div.addEventListener('click', () => pilihSwatch(hex, div));
        grid.appendChild(div);
    });
}

// ===== Buka Modal =====
function bukaModal(field) {
    targetField = field;

    // Baca warna saat ini
    const currentVal = field === 'bg'
        ? document.getElementById('input-bg').value
        : document.getElementById('input-text').value;

    selectedColor = currentVal;

    renderGrid();

    // Tandai warna yang sudah aktif
    tandaiTerpilih(currentVal);

    document.getElementById('modal-overlay').classList.remove('hidden');
}

// ===== Tutup Modal =====
function tutupModal(event) {
    if (event && event.type === 'click' && event.target !== document.getElementById('modal-overlay')) return;
    document.getElementById('modal-overlay').classList.add('hidden');
    selectedColor = null;
    targetField = null;
}

// ===== Pilih swatch dari grid =====
function pilihSwatch(hex, el) {
    selectedColor = hex;

    // Hapus semua .selected
    document.querySelectorAll('.swatch, .custom-swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
}

// ===== Tandai warna terpilih saat modal dibuka =====
function tandaiTerpilih(hex) {
    document.querySelectorAll('.swatch').forEach(s => {
        s.classList.remove('selected');
        if (s.dataset.color.toLowerCase() === hex.toLowerCase()) {
            s.classList.add('selected');
        }
    });
}

// ===== Konfirmasi pilihan & update hidden input + preview kotak =====
function pilihWarna() {
    if (!selectedColor || !targetField) {
        tutupModal();
        return;
    }

    if (targetField === 'bg') {
        document.getElementById('input-bg').value = selectedColor;
        document.getElementById('box-bg').style.backgroundColor = selectedColor;
    } else {
        document.getElementById('input-text').value = selectedColor;
        document.getElementById('box-text').style.backgroundColor = selectedColor;
    }

    document.getElementById('modal-overlay').classList.add('hidden');
    selectedColor = null;
    targetField = null;
}

// ===== Tambah warna custom =====
function tambahCustom(hex) {
    const container = document.getElementById('custom-swatches');

    const div = document.createElement('div');
    div.className = 'custom-swatch';
    div.style.backgroundColor = hex;
    div.title = hex;
    div.dataset.color = hex;
    div.addEventListener('click', () => {
        selectedColor = hex;
        document.querySelectorAll('.swatch, .custom-swatch').forEach(s => s.classList.remove('selected'));
        div.classList.add('selected');
    });
    container.appendChild(div);

    // Langsung pilih warna custom ini
    selectedColor = hex;
    document.querySelectorAll('.swatch, .custom-swatch').forEach(s => s.classList.remove('selected'));
    div.classList.add('selected');
}

// ===== Init =====
renderGrid();