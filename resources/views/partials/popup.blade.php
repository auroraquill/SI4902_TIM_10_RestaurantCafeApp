{{-- Popup tengah layar: konfirmasi hapus + notifikasi sukses --}}
<style>
    .popup-overlay { position: fixed; inset: 0; background: rgba(17,24,39,.5); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 20px; }
    .popup-overlay.show { display: flex; }
    .popup-box { background: #fff; border-radius: 12px; padding: 28px 28px 22px; width: 100%; max-width: 380px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,.25); animation: popup-in .18s ease-out; }
    @keyframes popup-in { from { transform: scale(.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .popup-icon { width: 56px; height: 56px; border-radius: 50%; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; }
    .popup-icon.success { background: #d1fae5; color: #059669; }
    .popup-icon.warning { background: #fee2e2; color: #ef4444; }
    .popup-title { margin: 0 0 6px; font-size: 18px; color: #1f2937; }
    .popup-text { margin: 0 0 20px; font-size: 14px; color: #6b7280; }
    .popup-actions { display: flex; gap: 10px; justify-content: center; }
    .popup-btn { border: none; border-radius: 6px; padding: 9px 20px; font-size: 14px; font-weight: 600; cursor: pointer; }
    .popup-btn.cancel { background: #e5e7eb; color: #374151; }
    .popup-btn.danger { background: #ef4444; color: #fff; }
    .popup-btn.ok { background: #059669; color: #fff; }
</style>

{{-- Popup konfirmasi hapus --}}
<div class="popup-overlay" id="confirmPopup">
    <div class="popup-box">
        <div class="popup-icon warning">!</div>
        <h3 class="popup-title">Konfirmasi Hapus</h3>
        <p class="popup-text" id="confirmText">Yakin ingin menghapus data ini?</p>
        <div class="popup-actions">
            <button type="button" class="popup-btn cancel" id="confirmCancel">Batal</button>
            <button type="button" class="popup-btn danger" id="confirmOk">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- Popup sukses --}}
@if(session('success'))
<div class="popup-overlay show" id="successPopup">
    <div class="popup-box">
        <div class="popup-icon success">&#10003;</div>
        <h3 class="popup-title">Berhasil</h3>
        <p class="popup-text">{{ session('success') }}</p>
        <div class="popup-actions">
            <button type="button" class="popup-btn ok" id="successOk">OK</button>
        </div>
    </div>
</div>
@endif

<script>
    (function () {
        var confirmPopup = document.getElementById('confirmPopup');
        var pendingForm = null;

        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                pendingForm = form;
                document.getElementById('confirmText').textContent = form.getAttribute('data-confirm');
                confirmPopup.classList.add('show');
            });
        });

        document.getElementById('confirmCancel').addEventListener('click', function () {
            confirmPopup.classList.remove('show');
            pendingForm = null;
        });
        document.getElementById('confirmOk').addEventListener('click', function () {
            if (pendingForm) pendingForm.submit();
        });

        var successPopup = document.getElementById('successPopup');
        if (successPopup) {
            var close = function () { successPopup.classList.remove('show'); };
            document.getElementById('successOk').addEventListener('click', close);
            setTimeout(close, 3000);
        }
    })();
</script>