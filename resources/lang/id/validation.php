<?php

return [
    'accepted' => 'Kolom :attribute harus diterima.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus tanggal setelah :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, strip dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa array.',
    'before' => 'Kolom :attribute harus tanggal sebelum :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus antara :min dan :max.',
        'file'    => 'Ukuran file :attribute harus antara :min dan :max kilobytes.',
        'string'  => 'Kolom :attribute harus antara :min dan :max karakter.',
        'array'   => 'Kolom :attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus sama dengan tanggal :date.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus :digits digit.',
    'digits_between' => 'Kolom :attribute harus antara :min dan :max digit.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'exists' => 'Kolom :attribute yang dipilih tidak valid.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute wajib diisi.',
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Kolom :attribute yang dipilih tidak valid.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'file'    => 'Ukuran file :attribute tidak boleh lebih dari :max kilobytes.',
        'string'  => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        'array'   => 'Kolom :attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'min' => [
        'numeric' => 'Kolom :attribute minimal harus :min.',
        'file'    => 'Ukuran file :attribute minimal :min kilobytes.',
        'string'  => 'Kolom :attribute minimal :min karakter.',
        'array'   => 'Kolom :attribute minimal memiliki :min item.',
    ],
    'not_in' => 'Kolom :attribute yang dipilih tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'present' => 'Kolom :attribute harus ada.',
    'regex' => 'Format kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without' => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak terdapat semua dari :values.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file'    => 'Ukuran file :attribute harus :size kilobytes.',
        'string'  => 'Kolom :attribute harus :size karakter.',
        'array'   => 'Kolom :attribute harus mengandung :size item.',
    ],
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah digunakan.',
    'url' => 'Format kolom :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'pesan kustom',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'nama' => 'nama',
        'nik' => 'NIK',
        'tanggal_lahir' => 'tanggal lahir',
        'jenis_kelamin' => 'jenis kelamin',
        'alamat' => 'alamat',
        'provinsi_id' => 'provinsi',
        'kabupaten_id' => 'kabupaten',
        // Tambahkan lainnya sesuai kebutuhan
    ],
];
