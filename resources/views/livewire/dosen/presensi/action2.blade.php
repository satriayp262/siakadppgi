<div wire:key="action-{{ Rand() . $row['nim'] }}-{{ $row['id_presensi'] }}">
    <livewire:dosen.presensi.edit :id_mahasiswa="$row['id_mahasiswa']" :id_presensi="$row['id_presensi']" :token="$row['token']"
        wire:key="edit-{{ Rand() . $row['id_mahasiswa'] }}-{{ $row['id_presensi'] }}" />
</div>
