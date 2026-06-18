    </div><!-- end main-content -->
</div><!-- end row -->
</div><!-- end container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- CKEditor 4 - hanya aktif jika ada textarea#isi_berita -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
if (document.getElementById('isi_berita')) {
    CKEDITOR.replace('isi_berita', {
        height: 350,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
            { name: 'paragraph',   items: ['NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
            { name: 'links',       items: ['Link', 'Unlink'] },
            { name: 'insert',      items: ['Image', 'Table', 'HorizontalRule'] },
            { name: 'styles',      items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors',      items: ['TextColor', 'BGColor'] },
            { name: 'document',    items: ['Source'] }
        ]
    });
}
</script>

</body>
</html>
