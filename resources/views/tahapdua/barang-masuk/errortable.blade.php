@php
    $arrayFields = ['nama_item', 'harga', 'jumlah', 'satuan', 'tgl_expired'];
    $allErrors = [];

    foreach ($arrayFields as $field) {
        $fieldErrors = $errors->getMessages();

        foreach ($fieldErrors as $key => $messages) {
            if (!str_starts_with($key, $field . '.')) {
                continue;
            }

            $parts = explode('.', $key);
            if (count($parts) !== 2) {
                continue;
            }

            [$fieldName, $index] = $parts;
            if (!is_numeric($index)) {
                continue;
            }

            if (!isset($allErrors[$index])) {
                $allErrors[$index] = [];
            }
            if (!isset($allErrors[$index][$fieldName])) {
                $allErrors[$index][$fieldName] = [];
            }

            $allErrors[$index][$fieldName] = array_merge($allErrors[$index][$fieldName], $messages);
        }
    }

    ksort($allErrors);
@endphp

@php
function formatFieldName($field, $index) {
    $names = [
        'nama_item' => 'Nama Barang',
        'harga' => 'Harga',
        'jumlah' => 'Jumlah',
        'satuan' => 'Satuan',
        'tgl_expired' => 'Tgl. Expired',
    ];

    $row = $index + 1;
    $base = $names[$field] ?? $field;

    return "$base baris ke-$row";
}

function formatErrorMessage($message, $field, $index) {
    // Ganti field.key di message error dengan nama field + baris
    $search = "$field.$index";
    $replace = formatFieldName($field, $index);
    return str_replace($search, $replace, $message);
}
@endphp


@if (!empty($allErrors))
    <div class="alert alert-danger">
        <h5>Kesalahan dalam input data</h5>
        <hr class=" border-secondary">
        <table class="table table-bordered table-sm mb-0">
            <thead class="table-danger">
                <tr>
                    <th>Baris ke</th>
                    @foreach ($arrayFields as $field)
                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                    @endforeach
                    {{-- <th>Pesan Error</th> --}}
                </tr>
            </thead>
            <tbody class="table-danger">
                @foreach ($allErrors as $index => $fieldsError)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @foreach ($arrayFields as $field)
                            <td>
                                @if (isset($fieldsError[$field]))
                                    @foreach ($fieldsError[$field] as $msg)
                                        <div class="text-danger">
                                            {{ formatErrorMessage($msg,$field, $index) }}
                                        </div>
                                    @endforeach
                                @else
                                    <div>-</div>
                                @endif
                            </td>
                        @endforeach

                        {{-- <td>
                            @foreach ($fieldsError as $errs)
                                @foreach ($errs as $msg)
                                    <div class="text-danger">
                                        {{ formatErrorMessage($msg,$field, $index) }}
                                    </div>
                                @endforeach
                            @endforeach
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
