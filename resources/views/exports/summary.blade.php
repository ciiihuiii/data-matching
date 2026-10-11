<table>
    <tr>
        <th colspan="2">
            HASIL DATA MATCHING
        </th>
    </tr>

    <tr>
        <td colspan="2">
            DISTRIK NAVIGASI TIPE A KELAS I AMBON
        </td>
    </tr>

    <tr>
        <td colspan="2"></td>
    </tr>

    <tr>
        <th colspan="2">
            SUMBER DATA
        </th>
    </tr>

    <tr>
        <td>Sumber 1</td>
        <td>
            {{ $result['source_1']['name'] ?? '-' }}
        </td>
    </tr>

    <tr>
        <td>Sumber 2</td>
        <td>
            {{ $result['source_2']['name'] ?? '-' }}
        </td>
    </tr>

    <tr>
        <td colspan="2"></td>
    </tr>

    <tr>
        <th colspan="2">
            RINGKASAN HASIL
        </th>
    </tr>

    <tr>
        <td>Total Data Sumber 1</td>
        <td>{{ $result['total_source_1'] ?? 0 }}</td>
    </tr>

    <tr>
        <td>Total Data Sumber 2</td>
        <td>{{ $result['total_source_2'] ?? 0 }}</td>
    </tr>

    <tr>
        <td>Data Sama</td>
        <td>{{ $result['total_same'] ?? 0 }}</td>
    </tr>

    <tr>
        <td>Data Berbeda</td>
        <td>{{ $result['total_different'] ?? 0 }}</td>
    </tr>

    <tr>
        <td>Tidak Ditemukan</td>
        <td>{{ $result['total_not_found'] ?? 0 }}</td>
    </tr>
</table>