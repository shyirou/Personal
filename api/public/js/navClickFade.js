// Fungsi untuk menangani navigasi dengan efek fade
function navigateWithFade(targetUrl) {
    // Tambahkan efek fade-out ke body sebelum navigasi
    document.body.classList.add('fade-out');

    // Tunggu sampai animasi selesai, baru arahkan ke halaman baru
    setTimeout(() => {
        window.location.href = targetUrl;
    }, 200); // Sesuaikan durasi transisi di CSS
}

// Event listener untuk menangani tombol "back" di browser
window.onpopstate = function(event) {
    // Menghilangkan efek fade-out jika ada saat kembali ke halaman sebelumnya
    document.body.classList.remove('fade-out');
};
