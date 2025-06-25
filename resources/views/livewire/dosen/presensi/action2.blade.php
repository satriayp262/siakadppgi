<div wire:key="action-{{ Rand() . $row['nim'] }}-{{ $row['id_presensi'] }}">
    <livewire:dosen.presensi.edit :nim="$row['nim']" :token="$row['token']"
        wire:key="edit-{{ Rand() . $row['nim'] }}-{{ $row['id_presensi'] }}" />
</div>
