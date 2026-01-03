<div class="container py-5">
    <h2 class="mb-4">
        <i class="fas fa-heart text-danger"></i> Wisata Favorit Saya
    </h2>

    <div class="row">
        <?php if (!empty($favorites)): ?>
            <?php foreach ($favorites as $wisata): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm position-relative">

                        <button class="btn-favorite favorited"
                                data-wisata-id="<?= $wisata['id'] ?>">
                            <i class="fas fa-heart"></i>
                        </button>

                        <img src="<?= get_wisata_image($wisata['foto']) ?>"
                             class="card-img-top"
                             style="height:200px;object-fit:cover">

                        <div class="card-body">
                            <h5><?= $wisata['nama'] ?></h5>
                            <p class="text-muted small">
                                <i class="fas fa-map-marker-alt"></i>
                                <?= $wisata['alamat'] ?>
                            </p>

                            <p class="small text-muted">
                                <?= truncate_text($wisata['deskripsi'], 100) ?>
                            </p>

                            <div class="d-flex justify-content-between">
                                <strong class="text-primary">
                                    <?= format_rupiah($wisata['harga_tiket']) ?>
                                </strong>
                                <span class="badge bg-secondary">
                                    <?= ucfirst($wisata['kategori']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <a href="<?= base_url('wisata/detail/'.$wisata['id']) ?>"
                               class="btn btn-primary w-100">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada favorit.
                    <a href="<?= base_url('wisata') ?>" class="alert-link">
                        Jelajahi wisata
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<!-- JS FAVORIT -->
<script>
document.querySelectorAll('.btn-favorite').forEach(btn => {
    btn.addEventListener('click', function () {
        const wisataId = this.dataset.wisataId;
        const button  = this;

        fetch("<?= base_url('favorit/toggle') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "wisata_id=" + wisataId
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }
            button.classList.toggle('favorited', data.favorited);
        });
    });
});
</script>

<style>
.btn-favorite {
    position:absolute;
    top:10px;
    right:10px;
    background:#fff;
    border:none;
    border-radius:50%;
    padding:8px 10px;
}
.btn-favorite i { color:#ccc; }
.btn-favorite.favorited i { color:red; }
</style>
