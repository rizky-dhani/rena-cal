<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan kesalahan standar yang digunakan oleh
    | kelas validator. Beberapa aturan memiliki beberapa versi seperti
    | aturan ukuran. Jangan ragu untuk mengoptimalkan setiap pesan di sini.
    |
    */

    'accepted'        => ':attribute harus diterima.',
    'accepted_if'     => ':attribute harus diterima ketika :other berisi :value.',
    'active_url'      => ':attribute bukan URL yang valid.',
    'after'           => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal'  => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'           => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'      => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'       => ':attribute hanya boleh berisi huruf dan angka.',
    'array'           => ':attribute harus berupa sebuah array.',
    'ascii'           => ':attribute hanya boleh berisi karakter alfanumerik dan simbol single-byte.',
    'before'          => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'         => [
        'array'   => ':attribute harus memiliki antara :min sampai :max anggota.',
        'file'    => ':attribute harus berukuran antara :min sampai :max kilobita.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string'  => ':attribute harus berukuran antara :min sampai :max karakter.',
    ],
    'boolean'           => ':attribute harus bernilai true atau false.',
    'can'               => ':attribute berisi nilai yang tidak sah.',
    'confirmed'         => 'Konfirmasi :attribute tidak cocok.',
    'contains'          => ':attribute kekurangan nilai yang diperlukan.',
    'current_password'  => 'Kata sandi salah.',
    'date'              => ':attribute bukan tanggal yang valid.',
    'date_equals'       => ':attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'       => ':attribute tidak cocok dengan format :format.',
    'decimal'           => ':attribute harus memiliki :decimal tempat desimal.',
    'declined'          => ':attribute harus ditolak.',
    'declined_if'       => ':attribute harus ditolak ketika :other berisi :value.',
    'different'         => ':attribute dan :other harus berbeda.',
    'digits'            => ':attribute harus terdiri dari :digits angka.',
    'digits_between'    => ':attribute harus terdiri dari antara :min sampai :max angka.',
    'dimensions'        => ':attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'          => ':attribute memiliki nilai yang duplikat.',
    'doesnt_contain'    => ':attribute tidak boleh berisi salah satu dari berikut ini: :values.',
    'doesnt_end_with'   => ':attribute tidak boleh diakhiri dengan salah satu dari berikut ini: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari berikut ini: :values.',
    'email'             => ':attribute harus berupa alamat surel yang valid.',
    'ends_with'         => ':attribute harus diakhiri dengan salah satu dari berikut ini: :values.',
    'enum'              => ':attribute yang dipilih tidak valid.',
    'exists'            => ':attribute yang dipilih tidak valid.',
    'extensions'        => ':attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file'              => ':attribute harus berupa sebuah berkas.',
    'filled'            => ':attribute harus memiliki nilai.',
    'gt'                => [
        'array'   => ':attribute harus memiliki lebih dari :value anggota.',
        'file'    => ':attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari :value.',
        'string'  => ':attribute harus berukuran lebih besar dari :value karakter.',
    ],
    'gte' => [
        'array'   => ':attribute harus terdiri dari :value anggota atau lebih.',
        'file'    => ':attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string'  => ':attribute harus berukuran lebih besar dari atau sama dengan :value karakter.',
    ],
    'hex_color' => ':attribute harus berupa warna heksadesimal yang valid.',
    'image'     => ':attribute harus berupa gambar.',
    'in'        => ':attribute yang dipilih tidak valid.',
    'in_array'  => ':attribute tidak ada di dalam :other.',
    'integer'   => ':attribute harus berupa bilangan bulat.',
    'ip'        => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'      => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'      => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'      => ':attribute harus berupa string JSON yang valid.',
    'list'      => ':attribute harus berupa daftar.',
    'lowercase' => ':attribute harus berupa huruf kecil.',
    'lt'        => [
        'array'   => ':attribute harus memiliki kurang dari :value anggota.',
        'file'    => ':attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => ':attribute harus bernilai kurang dari :value.',
        'string'  => ':attribute harus berukuran kurang dari :value karakter.',
    ],
    'lte' => [
        'array'   => ':attribute tidak boleh memiliki lebih dari :value anggota.',
        'file'    => ':attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus bernilai kurang dari atau sama dengan :value.',
        'string'  => ':attribute harus berukuran kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max'         => [
        'array'   => ':attribute maksimal terdiri dari :max anggota.',
        'file'    => ':attribute maksimal berukuran :max kilobita.',
        'numeric' => ':attribute maksimal bernilai :max.',
        'string'  => ':attribute maksimal berukuran :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh memiliki lebih dari :max angka.',
    'mimes'      => ':attribute harus berupa berkas berjenis: :values.',
    'mimetypes'  => ':attribute harus berupa berkas berjenis: :values.',
    'min'        => [
        'array'   => ':attribute minimal terdiri dari :min anggota.',
        'file'    => ':attribute minimal berukuran :min kilobita.',
        'numeric' => ':attribute minimal bernilai :min.',
        'string'  => ':attribute minimal berukuran :min karakter.',
    ],
    'min_digits' => ':attribute harus memiliki setidaknya :min angka.',
    'missing'    => ':attribute harus tidak ada.',
    'missing_if' => ':attribute harus tidak ada ketika :other berisi :value.',
    'missing_unless' => ':attribute harus tidak ada kecuali :other berisi :value.',
    'missing_with' => ':attribute harus tidak ada ketika :values ada.',
    'missing_with_all' => ':attribute harus tidak ada ketika :values ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in'      => ':attribute yang dipilih tidak valid.',
    'not_regex'   => 'Format :attribute tidak valid.',
    'numeric'     => ':attribute harus berupa angka.',
    'password'    => [
        'letters'       => ':attribute harus berisi setidaknya satu huruf.',
        'mixed'         => ':attribute harus berisi setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers'       => ':attribute harus berisi setidaknya satu angka.',
        'symbols'       => ':attribute harus berisi setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present'              => ':attribute harus ada.',
    'present_if'           => ':attribute harus ada ketika :other berisi :value.',
    'present_unless'       => ':attribute harus ada kecuali :other berisi :value.',
    'present_with'         => ':attribute harus ada ketika :values ada.',
    'present_with_all'     => ':attribute harus ada ketika :values ada.',
    'prohibited'           => ':attribute dilarang.',
    'prohibited_if'        => ':attribute dilarang ketika :other berisi :value.',
    'prohibited_if_accepted' => ':attribute dilarang ketika :other diterima.',
    'prohibited_if_declined' => ':attribute dilarang ketika :other ditolak.',
    'prohibited_unless'    => ':attribute dilarang kecuali :other ada di :values.',
    'prohibits'            => ':attribute melarang :other untuk ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_array_keys'  => ':attribute harus berisi entri untuk: :values.',
    'required_if'          => ':attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => ':attribute wajib diisi ketika :other diterima.',
    'required_if_declined' => ':attribute wajib diisi ketika :other ditolak.',
    'required_unless'      => ':attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => ':attribute wajib diisi ketika terdapat :values.',
    'required_with_all'    => ':attribute wajib diisi ketika terdapat :values.',
    'required_without'     => ':attribute wajib diisi ketika tidak terdapat :values.',
    'required_without_all' => ':attribute wajib diisi ketika sama sekali tidak terdapat :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'array'   => ':attribute harus mengandung :size anggota.',
        'file'    => ':attribute harus berukuran :size kilobita.',
        'numeric' => ':attribute harus berukuran :size.',
        'string'  => ':attribute harus berukuran :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali salah satu dari berikut: :values.',
    'string'      => ':attribute harus berupa string.',
    'timezone'    => ':attribute harus berisi zona waktu yang valid.',
    'unique'      => ':attribute sudah ada sebelumnya.',
    'uploaded'    => ':attribute gagal diunggah.',
    'uppercase'   => ':attribute harus berupa huruf besar.',
    'url'         => 'Format :attribute tidak valid.',
    'ulid'        => ':attribute harus berupa ULID yang valid.',
    'uuid'        => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
    | konvensi "attribute.rule" untuk menamai baris. Ini membuat cepat dalam
    | menentukan baris bahasa kustom yang spesifik untuk aturan atribut tertentu.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar placeholder atribut kami
    | dengan sesuatu yang lebih ramah pengguna seperti "Alamat Surel" daripada
    | "email". Ini membantu kami membuat pesan kami lebih ekspresif.
    |
    */

    'attributes' => [],

];
