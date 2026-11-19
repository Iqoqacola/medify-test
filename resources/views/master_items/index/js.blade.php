<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [
                [0, 'desc']
            ],
        });
        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    });

    // cegah XSS: ubah < > & menjadi teks biasa
    function esc(text) {
        return $('<div>').text(text == null ? '' : text).html();
    }

    function getData() {
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{ url("master-items/search") }}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: {
                kode: $('#filter-kode').val(),
                nama: $('#filter-nama').val(),
                hargamin: $('#filter-harga-min').val(),
                hargamax: $('#filter-harga-max').val()
            },
            success: function(results) {
                var rows = [];
                $.each(results.data, function(index, item) {
                    var harga_beli = Number(item.harga_beli);
                    var laba = Number(item.laba);
                    var harga_jual = Math.round(harga_beli + harga_beli * laba / 100);
                    var kategori = (item.categories || []).map(function(c) {
                        return esc(c.nama);
                    }).join(', ');
                    var html = `<a href="{{ url('master-items/view') }}/` + encodeURIComponent(item.kode) + `" class="btn btn-primary">View</a>`;

                    rows.push([
                        esc(item.kode),
                        esc(item.nama),
                        esc(item.jenis),
                        kategori,
                        harga_beli,
                        harga_jual,
                        esc(item.supplier),
                        html
                    ]);
                });
                dataTableObj.rows.add(rows).draw();
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data');
                $('#loading-filter').hide();
            }
        });
    }
</script>