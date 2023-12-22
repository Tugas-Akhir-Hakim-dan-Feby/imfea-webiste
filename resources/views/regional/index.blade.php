@php
    use Carbon\Carbon;
    use App\Http\Facades\Region\City;
    use App\Http\Facades\Region\Province;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')

    <x-row>
        <x-col>
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <div>
                        <x-button route="web.user.korwil.clear" size="sm" color="secondary">Kembali ke
                            Pengguna</x-button>
                        <x-button route="web.regional.create" size="sm" color="primary">Tambah
                            Baru</x-button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <x-input margin="0" type="search" />
                        <x-pagination :paginator="$regionals" />
                    </div>
                </x-slot:header>
                <x-slot:body>
                    <x-table :isComplete="true" class="table-bordered table-hover">
                        <x-slot:thead>
                            <th>No.</th>
                            <th>Alamat</th>
                            <th>Kota/Kabupatan</th>
                            <th>Provinsi</th>
                            <th>Kode Pos</th>
                            <th>Aksi</th>
                        </x-slot:thead>
                        <x-slot:tbody>
                            @forelse ($regionals as $index => $regional)
                                <tr>
                                    <th>{{ $index + $regionals->firstItem() }}.</th>
                                    <td>{{ ucwords($regional->address) }}</td>
                                    <td>{{ ucwords(strtolower(City::show($regional->city_id)['name'])) }}</td>
                                    <td>{{ ucwords(strtolower(Province::show($regional->province_id)['name'])) }}</td>
                                    <td>{{ $regional->postal_code }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('web.regional.edit', $regional) }}"
                                                class="btn btn-sm btn-warning text-white me-2">Edit</a>
                                            <form action="{{ route('web.regional.destroy', $regional) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger text-white btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-table colspan="6" class="text-center">data tidak tersedia!</x-empty-table>
                            @endforelse
                        </x-slot:tbody>
                    </x-table>
                </x-slot:body>
            </x-card>
        </x-col>
    </x-row>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(".btn-non-active").click(function(e) {
                e.preventDefault();

                let form = $(this).closest("form");

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan non aktifkan berita ini!",
                    icon: 'warning',
                    showDenyButton: true,
                    denyButtonText: 'Non Aktif',
                    confirmButtonText: 'Batal',
                    confirmButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isDenied) {
                        form.submit()
                    }
                })
            })

            $(".btn-active").click(function(e) {
                e.preventDefault();

                let form = $(this).closest("form");
                form.submit()
            })
        })
    </script>
@endpush
