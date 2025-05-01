

<main class="flex-1 p-4 overflow-auto">
    

    <?php if (isset($content)): ?>
        <?= $content ?>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
            <p>Selamat datang di sistem absensi SMP Muhammadiyah 16 Lubuk Pakam.</p>
        </div>
    <?php endif; ?>