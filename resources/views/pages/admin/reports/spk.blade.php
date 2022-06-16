<table>
    <thead>
        <tr>
            <td colspan="{{8 + $n}}" class="text-center">Hasil Perhitungan SPK PT Madu Baru</td>
        </tr>
        <tr>
            <td colspan="{{8 + $n}}" class="text-center">Penentuan Kontrak Karyawan</td>
        </tr>
        <tr>
            <td rowspan="2">No</td>
            <td rowspan="2">ID</td>
            <td rowspan="2">Nama</td>
            <td rowspan="2">NIK</td>
            <td rowspan="2">Pekerjaan</td>
            <td colspan="{{ $n }}">Nilai Kriteria</td>
            <td rowspan="2">Total Nilai</td>
            <td rowspan="2">Kontrak Mulai</td>
            <td rowspan="2">Kontrak Selesai</td>
        </tr>
        <tr>
            @for ($i = 0; $i < $n; $i++)
                <td>{{ App\Helpers\Helper::getCriteriaName($i, $jobid) }}</td>
            @endfor
        </tr>
    </thead>
    <tbody>
        @php
            $num = 1;
        @endphp
        @foreach ($empdata as $emp)
            <tr>
                <td>{{ $num++ }}</td>
                <td>{{ $emp->id }}</td>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->nik }}</td>
                <td>{{ $emp->job_type->job_name }}</td>
                @foreach ($emp->data_emp as $e)
                    <td>{{ $e->value }}</td>
                @endforeach
                @foreach ($emp->spk_res as $res)
                    <td>{{ $res->value }}</td>
                @endforeach
                @foreach ($emp->contract as $cont)
                    <td>{{ $cont->start_contract }}</td>
                    <td>{{ $cont->end_contract }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
