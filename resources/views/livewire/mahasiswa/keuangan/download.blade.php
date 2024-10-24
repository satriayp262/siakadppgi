<div>
    <table border="1">
        <thead>
            <tr>
                <th></th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Semester</th>
                <th>Total Tagihan</th>
                <th>Jumlah Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $id_tagihan }}</td>
                <td>{{ $nama }}</td>
                <td>{{ $NIM }}</td>
                <td>{{ $id_semester }}</td>
                <td>{{ $total_tagihan }}</td>
                <td>{{ $total_bayar }}</td>
                <td>{{ $status_tagihan }}</td>
            </tr>
        </tbody>
    </table>
</div>
